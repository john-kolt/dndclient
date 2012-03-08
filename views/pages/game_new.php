<form name="game_new" action="<?php echo $this->serverUrl."games/new" ?>" method="post">
  <table cellpadding=1 cellspacing=1 class="list" style="width:auto;">
    <tr>
      <td>
        Name:
      </td>
      <td>
        <input name="name" value="<?php echo isset($_POST['name'])? $_POST['name'] : ''?>" placeholder="Game name...">
      </td>
    </tr>
    <tr>
      <td>
        Description:
      </td>
      <td>
        <textarea name="description" placeholder="Description..."><?php echo isset($_POST['description'])? $_POST['description'] : ''?></textarea>
      </td>
    </tr>
    <tr>
      <td>
        Tutorial:
      </td>
      <td>
        <textarea name="tutorial" placeholder="Tutorial..."><?php echo isset($_POST['tutorial'])? $_POST['tutorial'] : ''?></textarea>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <a class=add href="javascript:document.game_new.submit();">Submit</a>
      </td>
    </tr>
  </table>
<input type=submit value="" style="width: 1px; height: 1px;">
</form>
