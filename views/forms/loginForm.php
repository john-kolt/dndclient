<form action="<?php echo $this->serverUrl."user/login" ?>" method="post" name=login>
<table class="list" style="width:auto;">
<tr><td>
  <label for="login">Login:</label>
</td><td>
  <input name="login" type="text" placeholder="Login..." required value="<?php echo (isset($_POST['login']) ? $_POST['login'] : '') ?>">
</td></tr>
<tr><td>
  <label for="password">Password:</label>
</td><td>
  <input name="password" type="password" placeholder="Password..." required value="<?php echo (isset($_POST['password']) ? $_POST['password'] : '') ?>">
</td></tr>
<tr><td class=button colspan=2>
  <a class=users href="javascript:document.login.submit();">Enter</a>
</td></tr>
</table>
  <input type=submit value="" style="width: 1px; height: 1px;">
</form>
