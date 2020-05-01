<?php
include('./inc/vars.php');
include('./inc/core.php');

if(isset($_COOKIE['EM'])) {
  $EM = $_COOKIE['EM'];
  setcookie('EM', '', '0', '/');
}
if(isset($_COOKIE['BL'])) {
  $BL = $_COOKIE['BL'];
  setcookie('BL', '', '0', '/');
}
if(!isset($EM) && $EM != '00') {
  setcookie('EM', '09', '0', '/');
  header('Location: /');
	exit;
}
if(!isset($BL)) {
  setcookie('EM', '10', '0', '/');
  header('Location: /');
  exit;
}
$SLComplete = SHORTLINK_PREFIX.$BL;
include_once('./inc/page.header.php');
?>

       <section class="section main">
        <div class="container">
          <div class="column">
            <div class="box">
              <h2 class="title">Короткая ссылка создана</h2>
              <label class="label">Ссылка</label>
              <p class="control has-icon has-addons">
                <input readonly class="url-code-block" id="Rlink" value="<?=htmlspecialchars($SLComplete);?>">
                <button class="button is-info copy" data-copytarget="#Rlink">Копировать</button>
                <a href="<?=htmlspecialchars($SLComplete);?>"><button class="button is-primary copy">Открыть</button></a>
              </p>
              <?php
              include_once('./inc/EM.php');
              ?>
            </div>
          </div>
        </div>
       </section>
     </div>

<?php
include_once('./inc/page.footer.php');
?>
