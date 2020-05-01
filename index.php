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
include_once('./inc/page.header.php');
?>

   <section class="section main">
    <div class="container">

      <div class="column">
        <div class="box">
         <form action="/create.php" method="post">
          <input readonly style="display: none;" name="token" value="<?=bin2hex(openssl_random_pseudo_bytes(10));?>">
          <h2 class="title">Создать короткую ссылку</h2>
          <label title="Required" class="label">Введите ссылку <span style="color: red;">*</span></label>
          <p style="border-bottom: 1px solid #f1f1f1; padding-bottom: 15px;" class="control has-icon has-addons">
            <input autocomplete="off" style="min-width: 90%;" class="input" type="text" required name="url" id="url" placeholder="https://my-url.com/long?id=kg8rDwAAQBAJ&pg=PA251&lpg=PA251&dq=long+url+wiki&source=bl&ots=mU6Aa7lKRq">
            <span style="margin-top: -1px;" class="icon">
              <i class="fa fa-chain"></i>
            </span>
            <button style="min-width: 10%;" type="submit" class="button is-info" onclick="init_shorten(this)" value="Shorten">Создать</button>
          </p>

          <div style="display: flex;" class="columns">
            <div class="sbs">
              <div style="width: 325px; flex: none;" class="column SL">
                  <label title="Optional" class="label">Кастомная ссылка</label>
                  <p class="control has-icon">
                    <input autocomplete="off" style="max-width: 100%;" class="input" type="text" name="customcode" id="customcode" placeholder="MyCustomUrl">
                    <span style="margin-top: -1px;" class="icon">
                      <i class="fa fa-pencil-square-o"></i>
                    </span>
                    <span style="display: block; margin-left: 14px;">
                        ↳
                        <kbd style="background-color: #444444;color: white;font-size: 90%; padding: 2px 8px; border-radius: 10px; margin-top: 5px; margin-left: 5px;">
                            a<span style="color: #888888;">-</span>z A<span style="color: #888888;">-</span>Z 0<span style="color: #888888;">-</span>9 -
                        </kbd>
                    </span>
                  </p>
              </div>
              <?php if(reCAPTCHA_ENABLED): ?>
              <div style="width: 325px; flex: none;" class="column">
                <label title="Required" class="label">Подтверждение <span style="color: red;">*</span></label>
                <div class="g-recaptcha" data-sitekey="<?=reCAPTCHA_SITEKEY;?>"></div></script>
              </div>
              <?php endif; ?>
            </div>
            <div style="border-left: 1px solid #f1f1f1;" class="column">
              <p>Захотели полностью изменим вашу самую длинную ссылку, на более короткую?
			  Тогда вы пришли в нужное место. Введя URL-адрес в текстовое поле выше, Мы создадим короткую ссылку,
			  которая не будет прерываться в сообщениях и<i><b>никогда не истечет.</b></i></p>
            </div>
          </div>
         </form>
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
