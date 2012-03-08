<form action="<?php echo $this->serverUrl."user/register" ?>" method="post" name=register>
<table class="list" style="width:auto;">
<tr><td>
  <label for="login">Login:</label>
</td><td>
  <input name="login" type="text" placeholder="Login..." required value="<?php echo (isset($_POST['login']) ? $_POST['login'] : '') ?>">
</td></tr>
<tr><td>
  <label for="email">Email:</label>
</td><td>
  <input name="email" type="email" placeholder="Email..." required value="<?php echo (isset($_POST['email']) ? $_POST['email'] : '') ?>"><br>
</td></tr>
<tr><td>
  <label for="password">Password:</label>
</td><td>
  <input name="password" type="password" placeholder="Password..." required value="<?php echo (isset($_POST['password']) ? $_POST['password'] : '') ?>"><br>
</td></tr>
<tr><td class=button colspan=2>
  <!-- <input type=submit value="&#10553; Register "> /-->
  <a class=users-add href="javascript:document.register.submit();">Register</a>
</td></tr>
</table>
  <input type=submit value="" style="width: 1px; height: 1px;">
</form>
