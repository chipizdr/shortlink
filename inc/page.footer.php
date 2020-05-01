<?php
if(strtolower(basename($_SERVER["SCRIPT_FILENAME"])) === strtolower("page.footer.php")) {
  setcookie('EM', '09', '0', '/');
  header('Location: /');
  exit;
}
?>    <footer class="footer">
      <div class="container">
        <div class="content has-text-centered">
          <span><a style="color: #999999;" href="https://github.com/chipizdr/shortlink"><b>Github</b></a><br><i><?=FOOTER_TXT?></i></span>
        </div>
      </div>
    </footer>
    <script type="text/javascript" src="/assets/design.js<?='?'.slugify(FOOTER_TXT);?>"></script>
    <script type="text/javascript" id="cookiebanner" src="/assets/cookiebanner.js<?='?'.slugify(FOOTER_TXT);?>"
        data-message="Посещая данный сайт, вы соглашаетесь с правилами использования Cookies."></script>
  </body>
</html>
