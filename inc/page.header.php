<?php
if(strtolower(basename($_SERVER["SCRIPT_FILENAME"])) === strtolower("page.header.php")) {
  setcookie('EM', '09', '0', '/');
  header('Location: /');

	exit;
}
?><!DOCTYPE html>
<html lang="en">
  <head>
    <title>ShortLink</title>
    <link rel="stylesheet" href="/assets/design.css<?='?'.slugify(FOOTER_TXT);?>">
    <link rel="stylesheet" href="/assets/bulma.css<?='?'.slugify(FOOTER_TXT);?>">
    <link rel="stylesheet" href="/assets/font-awesome.css<?='?'.slugify(FOOTER_TXT);?>">
	<link rel="shortcut icon" href="/img/time.png" type="image/png">
    <meta property="og:title" content="ShortLink | Делаем короткие ссылки"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="<?php echo "http://".$_SERVER['SERVER_NAME']."/"; ?>"/>
    <meta property="og:image" content="<?php echo "http://".$_SERVER['SERVER_NAME']."/"; ?>logo/banner.jpg"/>
    <meta property="og:site_name" content="ShortLink"/>
    <meta property="og:description" content="ShortLink - это простое веб-приложение для сокращения URL с открытым исходным кодом."/>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />


  <?php if(reCAPTCHA_ENABLED): ?>  <script src='https://www.google.com/recaptcha/api.js?hl=<?=reCAPTCHA_LANG?>'></script><?php endif; ?></head>
  <body style="min-width: 800px;">
     <div class="design">
       <section class="hero is-dark">
         <div class="hero-body">
           <div class="container">
             <div style="display: flex;" class="columns">
               <div style="text-align: left;" class="column">
                 <a href="/">
				 <h1 style="font-size: 50px;" class="title">
                   Short Link
                 </h1></a>
                 <h2 class="subtitle">
                   <span style="margin-left: 14px; margin-right: 14px;"></span> Делаем короткие ссылки
                 </h2>
               </div>
            </div>
           </div>
         </div>
       </section>
