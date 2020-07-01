<?php include "templates/include/header.php" ?>
<form method="post" action="session.php?action=register" class = "registration">
  <input type="hidden" name="register" value="true" />
<?php if (isset($results['errorMessage'])) { ?>
  <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>

  <legend>회원가입</legend>
  <fieldset>
    <div class = "registration-agreement-container">
      <div class = "registration-agreement-content">
        <?php include "templates/contents/terms_of_use.php" ?>
      </div>
      <hr class = "registration-hr1">
      <div class ="registration-agreement-confirm">
        <input type="checkbox" required>
        <label> 약관을 모두 읽었으며 동의합니다.</label>
      </div>
    </div>

    <table>
      <tr>
        <td><span class = "registration-required">*</span><label>아이디</label></td>
        <td><input type="text" size="35" name="userid" placeholder="아이디" required></td>
      </tr>
      <tr>
        <td><span class = "registration-required">*</span><label>비밀번호</label></td>
        <td><input type="password" size="35" name="userpw" placeholder="비밀번호" required></td>
      </tr>
      <tr>
        <td><span class = "registration-required">*</span><label>비밀번호 확인</label></td>
        <td><input type="password" size="35" placeholder="비밀번호 재입력" required> <label class = "registration-caption">비밀번호는 6자리 이상이어야 하며 영문과 숫자를 반드시 포함해야 합니다.</label></td>
      </tr>
      <tr>
        <td><span class = "registration-required">*</span><label>이름</label></td>
        <td><input type="text" size="35" name="realname" placeholder="이름" required></td>
      </tr>
      <tr>
        <td><span class = "registration-required">*</span><label>이메일</label></td>
        <td><input type="text" name="email" placeholder ="이메일 주소" required> @ 
        <select name="emadress">
          <option value="gmail.com">gmail.com</option>
          <option value="naver.com">naver.com</option>
          <option value="nate.com">nate.com</option>
        </select></td>
      </tr>
    </table>
    <hr class = "registration-hr2">
    <div class = "registration-submit">
      <input type="reset" value="다시쓰기" />
      <input type="submit" name="register" value="가입하기" />
    </div>
  </fieldset>
</form>
<?php include "templates/include/footer.php" ?>