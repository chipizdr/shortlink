<?php
define("DB_PDODRIVER", "mysql");
define("DB_HOST", "localhost");
define("DB_DATABASE", "db");
define("DB_USERNAME", "user");
define("DB_PASSWORD", "pass");

define("SHORTLINK_PREFIX", "http://".$_SERVER['SERVER_NAME']."/"); 
define("CONTACT_EMAIL", "support@".$_SERVER['SERVER_NAME']); 

define("reCAPTCHA_ENABLED", true); // true or false;  Интеграция reCAPTCHA является дополнительной функцией
define("reCAPTCHA_SITEKEY", "site_key"); // получите ключ вашего сайта на https://www.google.com/recaptcha/admin и установить reCAPTCHA_ENABLED на true
define("reCAPTCHA_SECRETKEY", "sekret_key"); // please obtain your secret key at https://www.google.com/recaptcha/admin и установить reCAPTCHA_ENABLED на true
define("reCAPTCHA_LANG", "ru"); // reCAPTCHA supported 40+ languages listed here: https://developers.google.com/recaptcha/docs/language и установить reCAPTCHA_ENABLED на true

define("SHORTLINK_CODE_CHARS", "123456789bcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ"); 

define("FORWADER_PREVIEW", false); // включение этой функции предотвращает автоматическое перенаправление на вредоносные веб-сайты; переключение этой функции требует очистки кеша

define("FOOTER_TXT", 'YVBCR prod.'); // текст нижнего колонтитула

// Черный список
$kw_blacklist = array (
'*--*',
'*fuck*',
'*shit*',
'*asshole*',
'*cunt*',
'*nigger*',
'*bitch*',
'*faggot*',
'*dick*',
'*dumbass*',
'*nigga*',
'*pussy*',
'*slut*',
'*whore*',
'*axwound*',
'*dildo*',
'*vagina*',
'*penis*',
'*clitoris*',
'*creampie*',
'*cum*',
'*Ebal*',
'*Pidar*',
'*Pidr*',
'*Naxui*',
'*Naxuy*',
'*Nahui*',
'*Nahuy*',
'*Xui*',
'*Xyi*',
'*Xuy*',
'*Sosi*',
'*Blyat*',
'*Blya*',
'*Yebok*',
'*Pizda*',
'*Pizdyn*',
'*Pizdun*',
'*Pizdec*',
'*Pidoras*',
'*Huila*',
'*Huyla*',
'*Hyila*',
'*Xyila*',
'*mudak*',
'*mydak*',
'*gondon*',
'*gandon*',
'*pidaras*',
'*yeban*',
'*ueban*',
'*mydila*',
'*mudila*',
'*gnoiniy*',
'*gnoyniy*',
'*suka*',
'*syka*',
'*sykinsin*',
'*nah*',
'*nax*',
'*sosat*',
'*sasat*',
'*suk1nsin*',
'*sukins1n*',
'*suk1ns1n*',
'*pizdos*',
'*zalupa*',
'*vagina*',
'*ipal*',
'*ibal*',
'*cyka*',
'*cuka*',
'*shalava*',
'*shkura*',
'*fuck*',
'*fuk*',
'*dolboeb*',
'*dalbaeb*',
'*dolbaeb*',
'*dalboeb*',
'*eblan*',
'*mamka*',
'*viblyadk*'
);

// Любой домен URL, который совпадает с ключами этого массива, будет заблокирован. - ПРИНИМАЕТ ОБОЛОЧКИ 
$dom_blacklist = array (
'*porn*',
'*adult*',
'*sex*',
'*xxx*',
'*brazzers*',
'*bdsm*',
'*fuck*',
'*bigtit*',
'*bitch*',
'*homo*',
'*horny*',
'*virgin*',
'*Ebal*',
'*Pidar*',
'*Pidr*',
'*Naxui*',
'*Naxuy*',
'*Nahui*',
'*Nahuy*',
'*Xui*',
'*Xyi*',
'*Xuy*',
'*Sosi*',
'*Blyat*',
'*Blya*',
'*Yebok*',
'*Pizda*',
'*Pizdyn*',
'*Pizdun*',
'*Pizdec*',
'*Pidoras*',
'*Huila*',
'*Huyla*',
'*Hyila*',
'*Xyila*',
'*mudak*',
'*mydak*',
'*gondon*',
'*gandon*',
'*pidaras*',
'*yeban*',
'*ueban*',
'*mydila*',
'*mudila*',
'*gnoiniy*',
'*gnoyniy*',
'*suka*',
'*syka*',
'*sykinsin*',
'*nah*',
'*nax*',
'*sosat*',
'*sasat*',
'*suk1nsin*',
'*sukins1n*',
'*suk1ns1n*',
'*pizdos*',
'*zalupa*',
'*vagina*',
'*ipal*',
'*ibal*',
'*cyka*',
'*cuka*',
'*shalava*',
'*shkura*',
'*fuck*',
'*fuk*',
'*dolboeb*',
'*dalbaeb*',
'*dolbaeb*',
'*dalboeb*',
'*eblan*',
'*mamka*',
'*viblyadk*',
$_SERVER['SERVER_NAME'] // предотвращает создание ShortLinks из существующих ShortLinks
);
