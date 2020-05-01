<?php

if(strtolower(basename($_SERVER["SCRIPT_FILENAME"])) === strtolower("ShortLink.php")) {
  setcookie('EM', '09', '0', '/');
  header('Location: /');
	exit;
}
class ShortLink
{

  protected static $chars = SHORTLINK_CODE_CHARS;

  protected static $table = "short_links";

  protected static $checkUrlExists = true;

  protected $pdo;

  protected $timestamp;

  public function __construct(PDO $pdo) {
    $this->pdo = $pdo;
    $this->timestamp = $_SERVER["REQUEST_TIME"];
  }

  public function urlToShortCode($url, $customScode = '') {
    if (empty($url)) {
      throw new \Exception("Ссылка не была предоставлена.");
    }

    if ($this->validateUrlFormat($url) == false) {
      throw new \Exception("Ссылка не имеет допустимого формата.");
    }

    $codeExists = $this->codeExistsInDb($customScode);
    if ($codeExists != false && $this->shortCodeToUrl($customScode) != $url) {
      throw new \Exception("Cсылка уже есть в базе данных.");
    }

    $shortCode = $this->urlExistsInDb($url, $customScode);
    if ($shortCode == false) {
      $shortCode = $this->createShortCode($url, $customScode);
    }

    return $shortCode;
  }

  public function shortCodeToUrl($code, $increment = true) {
    if (empty($code)) {
      throw new \Exception("Короткий код не был предоставлен.");
    }

    $urlRow = $this->getUrlFromDb($code);
    if (empty($urlRow)) {
      throw new \Exception(
        "Короткий код не существует.");
    }

    if ($increment == true) {
      $this->incrementCounter($urlRow["id"]);
    }

    return $urlRow["long_url"];
  }

  public function is_profane($object, $sltype) {
    if($sltype != 'keyword' && $sltype != 'domain') {
      throw new \Exception("Неверный аргумент: тип объекта неизвестен.");
    }
    $profane = false;
    if($sltype == 'keyword') {
      global $kw_blacklist;
      if (isset($kw_blacklist)) {
        foreach ($kw_blacklist as $kw) {
          if(!empty($kw) && !is_null($kw)) {
            if (fnmatch(strtolower($kw), strtolower($object)) !== FALSE) {
              $profane = true;
            }
          }
        }
      }
    }
    if($sltype == 'domain') {
      $object = parse_url($object)['host'];
      global $dom_blacklist;
      if (isset($dom_blacklist)) {
        foreach ($dom_blacklist as $dom) {
          if(!empty($dom) && !is_null($dom)) {
            if (fnmatch(strtolower($dom), strtolower($object)) !== FALSE) {
              $profane = true;
            }
          }
        }
      }
    }
    return $profane;
  }

  /**
   * Check to see if the supplied URL is a valid format
   *
   * @param string $url the long URL
   * @return boolean whether URL is a valid format
   */
  public function validateUrlFormat($url) {
    if (false === filter_var($url, FILTER_VALIDATE_URL)) {
      $host = parse_url($url, PHP_URL_HOST);
      $ipv6 = trim($host, '[]');
      if (false === filter_var($ipv6, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
        return false;
      } else {
        $newUrl = str_replace($host, 'www.example.com', $url);
        if (false === filter_var($newUrl, FILTER_VALIDATE_URL)) {
          return false;
        }
      }
    }

    return true;
  }

  protected function verifyUrlExists($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return (!empty($response) && $response != 404);
  }

  public function codeExistsInDb($customScode) {
    $query = "SELECT short_code FROM " . self::$table .
      " WHERE custom_short_code = TRUE AND short_code = :short_code LIMIT 1";
    $stmt = $this->pdo->prepare($query);
    $params = array(
      "short_code" => $customScode
    );
    $stmt->execute($params);

    $result = $stmt->fetch();
    return (empty($result)) ? false : $result["short_code"];
  }

  /**
   * Check the database for the long URL.
   *
   * If the URL is already in the database then the short code for it is
   * returned.  If the URL is not, false is returned.  An exception is thrown
   * if there is a database error.
   *
   * @param string $url the long URL
   * @return string|boolean the short code if it exists - false if it does not
   * @throws PDOException if a database exception occurs
   */
  protected function urlExistsInDb($url, $customScode) {
    $query = "SELECT short_code FROM " . self::$table .
      " WHERE custom_short_code = FALSE AND long_url = :long_url LIMIT 1";
    $stmt = $this->pdo->prepare($query);
    $params = array(
      "long_url" => $url
    );
    $stmt->execute($params);

    $result = $stmt->fetch();
    if(isset($customScode) && !empty($customScode)) {
      return false;
    } else {
      return (empty($result)) ? false : $result["short_code"];
    }
  }

  /**
   * Delegates creating a short code from a long URL.
   *
   * Delegates inserting the URL into the database, converting the integer
   * of the row's ID column into a short code, and updating the database with
   * the code. If successful, it returns the short code. If there is an error,
   * an exception is thrown.
   *
   * @param string $url the long URL
   * @return string the created short code
   * @throws Exception if an error occurs
   */
  protected function createShortCode($url, $customScode) {
    $id = $this->insertUrlInDb($url, $customScode);
    $shortCode = 'r/'.$this->convertIntToShortCode($id);
    $this->insertShortCodeInDb($id, $shortCode);
    if(!empty($customScode)) {
      $this->insertShortCodeInDb($id, $customScode);
      return $customScode;
    } else {
      return $shortCode;
    }
  }

  /**
   * Inserts a new row into the database.
   *
   * Inserts a new row into the database with the URL and returns the ID of
   * the row. If there is a database error an exception is thrown.
   *
   * @param string $url the long URL
   * @return integer on success the integer of the newly inserted  row
   * @throws PDOException if an error occurs
   */
  protected function insertUrlInDb($url, $customScode) {
    $CSC = 0;
    if(isset($customScode) && !empty($customScode)) {
      $CSC = 1;
    }
    $query = "INSERT INTO " . self::$table .
      " (long_url, date_created, custom_short_code) " .
      " VALUES (:long_url, :timestamp, :CSC)";
    $stmnt = $this->pdo->prepare($query);
    $params = array(
      "long_url" => $url,
      "timestamp" => $this->timestamp,
      "CSC" => $CSC
    );
    $stmnt->execute($params);

    return $this->pdo->lastInsertId();
  }

  /**
   * Convert an integer to a short code.
   *
   * This method does the actual conversion of the ID integer to a short code.
   * If successful, it returns the created code. If there is an error, an
   * exception is thrown.
   *
   * @param int $id the integer to be converted
   * @return string the created short code
   * @throws Exception if an error occurs
   */
  protected function convertIntToShortCode($id) {
    $id = intval($id);
    if ($id < 1) {
      throw new \Exception(
        "The ID is not a valid integer");
    }

    $length = strlen(self::$chars);
    // make sure length of available characters is at
    // least a reasonable minimum - there should be at
    // least 10 characters
    if ($length < 10) {
      throw new \Exception("Length of chars is too small");
    }

    $code = "";
    while ($id > $length - 1) {
      // determine the value of the next higher character
      // in the short code should be and prepend
      $code = self::$chars[fmod($id, $length)] .
        $code;
      // reset $id to remaining value to be converted
      $id = floor($id / $length);
    }

    // remaining value of $id is less than the length of
    // self::$chars
    $code = self::$chars[$id] . $code;

    return $code;
  }

  /**
   * Updates the database row with the short code.
   *
   * Updates the row with a specific ID with the provided short code. If
   * successful, true is returned. An exception is thrown if there is an
   * error.
   *
   * @param int $id the ID of the database row to update
   * @param string $code the short code to associate with the row
   * @return boolean on success
   * @throws Exception if an error occurs
   */
  protected function insertShortCodeInDb($id, $code) {
    if ($id == null || $code == null) {
      throw new \Exception("Input parameter(s) invalid.");
    }
    $query = "UPDATE " . self::$table .
      " SET short_code = :short_code WHERE id = :id";
    $stmnt = $this->pdo->prepare($query);
    $params = array(
      "short_code" => $code,
      "id" => $id
    );
    $stmnt->execute($params);

    if ($stmnt->rowCount() < 1) {
      throw new \Exception(
        "Row was not updated with short code.");
    }

    return true;
  }

  /**
   * Check to see if the supplied short code is a valid format
   *
   * @param string $code the short code
   * @return boolean whether the short code is a valid format
   */
  protected function validateShortCode($code) {
    return preg_match("|[" . self::$chars . "]+|", $code);
  }

  /**
   * Get the long URL from the database.
   *
   * Retrieve the URL associated with the short code from the database. If
   * there is an error, an exception is thrown.
   *
   * @param string $code the short code to look for in the database
   * @return string|boolean the long URL or false if it does not exist
   * @throws PDOException if an error occurs
   */
  protected function getUrlFromDb($code) {
    $query = "SELECT id, long_url FROM " . self::$table .
      " WHERE short_code = :short_code LIMIT 1";
    $stmt = $this->pdo->prepare($query);
    $params=array(
      "short_code" => $code
    );
    $stmt->execute($params);

    $result = $stmt->fetch();
    return (empty($result)) ? false : $result;
  }

  /**
   * Increment the record's access count.
   *
   * Increment the number of times a short code has been looked up to retrieve
   * its URL.
   *
   * @param integer $id the ID of the row to increment
   * @throws PDOException if an error occurs
   */
  protected function incrementCounter($id) {
    $query = "UPDATE " . self::$table .
      " SET counter = counter + 1 WHERE id = :id";
    $stmt = $this->pdo->prepare($query);
    $params = array(
      "id" => $id
    );
    $stmt->execute($params);
  }
}

function slugify($text) {
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  $text = preg_replace('~[^-\w]+~', '', $text);
  $text = trim($text, '-');
  $text = preg_replace('~-+~', '-', $text);
  $text = strtolower($text);
  if (empty($text)) {
    return 'n-a';
  }
  return $text;
}
