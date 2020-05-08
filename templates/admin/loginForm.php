<head>
  <link rel="stylesheet" href="css/styleMain.css">
</head>

<?php #include "templates/include/header.php" ?>
  <?php if (isset($results['errorMessage'])) { ?>
    <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
  <?php } ?>
  <div class="box">
    <h2>로그인</h2>
    <p>서일대학교 커뮤니티 시스템 </p>
    <form action="session.php?action=login" method="post">
      <input type="hidden" name="login" value="true" />
      <div class="inputBox">
        <input type="text" name="userid" required onkeyup="this.setAttribute('value', this.value);"  value="">
        <label>Username</label>
      </div>
      <div class="inputBox">
            <input type="password" name="userpw" required onkeyup="this.setAttribute('value', this.value);" value="">
            <label>Passward</label>
          </div>
      <input type="submit" name="login" value="Sign In">
    </form>
  </div>
<?php #include "templates/include/footer.php" ?>