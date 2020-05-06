<?php include "templates/include/header.php" ?>
  <form action="session.php?action=login" method="post" style="width: 50%;">
    <input type="hidden" name="login" value="true" />

<?php if (isset($results['errorMessage'])) { ?>
    <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>
    <ul>
      <li>
        <input type="text" name="userid" placeholder="아이디" required autofocus maxlength="20" />
      </li>
      <li>
        <input type="password" name="userpw" placeholder="비밀번호" required maxlength="20" />
      </li>
      <!--TODO : 아이디 저장-->
    </ul>
    <div class="buttons">
      <input type="submit" name="login" value="Login" />
    </div>
  </form>
<?php include "templates/include/footer.php" ?>