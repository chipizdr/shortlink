<?php
if(strtolower(basename($_SERVER["SCRIPT_FILENAME"])) === strtolower("EM.php")) {
  setcookie('EM', '09', '0', '/');
  header('Location: /');
	exit;
}
if(isset($EM)) {
  if($EM == '01') {
    echo '<div class="msg2f"><hr><article class="message is-danger">
      <div class="message-header">
      <p><strong>Недействительная ссылка</strong>!</p>
      <button class="delete"></button>
      </div>
      <div class="message-body">
      Ссылка должна быть объявлена.
      </div>
      </div></article>';
  }
  if($EM == '02') {
    echo '<div class="msg2f"><hr><article class="message is-danger">
      <div class="message-header">
      <p><strong>Недействительная ссылка</strong>!</p>
      <button class="delete"></button>
      </div>
      <div class="message-body">
      Ссылка не должна быть пустой.
      </div>
      </div></article>';
  }
  if($EM == '03') {
    echo '<div class="msg2f"><hr><article class="message is-danger">
      <div class="message-header">
      <p><strong>Недействительная ссылка</strong>!</p>
      <button class="delete"></button>
      </div>
      <div class="message-body">
      Ссылка не должна быть больше 1999 символов.
      </div>
      </div></article>';
  }
  if($EM == '04') {
    echo '<div class="msg2f"><hr><article class="message is-danger">
      <div class="message-header">
      <p><strong>Недействительная ссылка</strong>!</p>
      <button class="delete"></button>
      </div>
      <div class="message-body">
      Ссылка должна быть действительной. Пожалуйста используйте (`http://`, `https://`, `ftp://`, `mailto:`, etc) в своей ссылке.
      </div>
      </div></article>';
  }
  if($EM == '05') {
    echo '<div class="msg2f"><hr><article class="message is-danger">
      <div class="message-header">
      <p><strong>Custom ShortLink Unavailable</strong>!</p>
      <button class="delete"></button>
      </div>
      <div class="message-body">
      Пользовательская ссылка уже используется, но Мы создали новую для Вас.
      </div>
      </div></article>';
  }
  if($EM == '06') {
    echo '<div class="msg2f"><hr><article class="message is-danger">
      <div class="message-header">
      <p><strong>Запрещенная пользовательская ссылка</strong>!</p>
      <button class="delete"></button>
      </div>
      <div class="message-body">
      Пользовательская ссылка должна содержать не более 20 символов.
      </div>
      </div></article>';
  }
  if($EM == '07') {
    echo '<div class="msg2f"><hr><article class="message is-danger">
      <div class="message-header">
      <p><strong>Запрещенная пользовательская ссылка</strong>!</p>
      <button class="delete"></button>
      </div>
      <div class="message-body">
      Пользовательская ссылка должна содержать не менее 3 символов.
      </div>
      </div></article>';
  }
  if($EM == '08') {
    echo '<div class="msg2f"><hr><article class="message is-danger">
      <div class="message-header">
      <p><strong>Запрещенная пользовательская ссылка</strong>!</p>
      <button class="delete"></button>
      </div>
      <div class="message-body">
      Пользовательская ссылка должна содержать только тире и буквенно-цифровые символы.
      </div>
      </div></article>';
  }
  if($EM == '09') {
    echo '<div class="msg2f"><hr><article class="message is-danger">
      <div class="message-header">
      <p><strong>Доступ закрыт</strong>!</p>
      <button class="delete"></button>
      </div>
      <div class="message-body">
      Ваш доступ к этой ссылке был определен как несанкционированный.
      </div>
      </div></article>';
  }
  if($EM == '10') {
    echo '<div class="msg2f"><hr><article class="message is-danger">
      <div class="message-header">
      <p><strong>Неверное действие</strong>!</p>
      <button class="delete"></button>
      </div>
      <div class="message-body">
      Ваши действия не применимы.
      </div>
      </div></article>';
  }
  if($EM == '11') {
    echo '<div class="msg2f"><hr><article class="message is-danger">
      <div class="message-header">
      <p><strong>Запрещенная ссылка</strong>!</p>
      <button class="delete"></button>
      </div>
      <div class="message-body">
      Эта ссылка была заблокирована администратором по некоторым причинам.
      Если вы считаете, что Мы допустили ошибку, свяжитесь с нами по адресу <a href="mailto:'.CONTACT_EMAIL.'">'.CONTACT_EMAIL.'</a>
      </div>
      </div></article>';
  }
  if($EM == '12') {
    echo '<div class="msg2f"><hr><article class="message is-danger">
      <div class="message-header">
      <p><strong>Запрещенный домен</strong>!</p>
      <button class="delete"></button>
      </div>
      <div class="message-body">
      Этот домен был заблокирован администратором по некоторым причинам.
      Если вы считаете, что Мы допустили ошибку, свяжитесь с нами по адресу <a href="mailto:'.CONTACT_EMAIL.'">'.CONTACT_EMAIL.'</a>
      </div>
      </div></article>';
  }
  if(reCAPTCHA_ENABLED && $EM == '13') {
    echo '<div class="msg2f"><hr><article class="message is-danger">
      <div class="message-header">
      <p><strong>Ошибка проверки</strong>!</p>
      <button class="delete"></button>
      </div>
      <div class="message-body">
      Система проверки не может подтвердить, что вы не робот. Пожалуйста, попробуйте еще раз.
      </div>
      </div></article>';
  }
  if($EM == '14') {
    echo '<div class="msg2f"><hr><article class="message is-danger">
      <div class="message-header">
      <p><strong>Server Error</strong>!</p>
      <button class="delete"></button>
      </div>
      <div class="message-body">
      Серверу не удалось подключиться к базе данных.
      Пожалуйста свяжитесь с нами <a href="mailto:'.CONTACT_EMAIL.'">'.CONTACT_EMAIL.'</a>
      </div>
      </div></article>';
  }
}
