<?php include "templates/include/header.php" ?>
  <form method="post" action="session.php?action=register">
    <input type="hidden" name="register" value="true" />
    <h1>회원가입</h1>
    <fieldset>
      <?php if (isset($results['errorMessage'])) { ?>
        <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
      <?php } ?>

      <legend>입력사항</legend>
      <table>
        <tr>
          <td>아이디</td>
          <td><input type="text" size="35" name="userid" placeholder="아이디" required></td>
        </tr>
        <tr>
          <td>비밀번호</td>
          <td><input type="password" size="35" name="userpw" placeholder="비밀번호" required></td>
        </tr>
        <tr>
          <td>이름</td>
          <td><input type="text" size="35" name="realname" placeholder="이름" required></td>
        </tr>
        <tr>
          <td>이메일</td>
          <td><input type="text" name="email" required>@<select name="emadress"><option value="gmail.com">gmail.com</option><option value="naver.com">naver.com</option>
          <option value="nate.com">nate.com</option></select></td>
        </tr>
      </table>
      <input type="submit" name="register" value="가입하기" /><input type="reset" value="다시쓰기" />
    </fieldset>
  </form>
<?php include "templates/include/footer.php" ?>