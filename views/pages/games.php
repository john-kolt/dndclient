  <table cellpadding=1 cellspacing=1 class="list" style="width:auto;">
    <tr>
      <th>id</th><th>uid</th><th>name</th><th>playing</th>
    </tr>
    <?php
      if($this->db_games):
      foreach($this->db_games as $item):
    ?>
    <tr>
      <td><?php echo $item['id']?></td>
      <td><?php echo $item['uid']?></td>
      <td><a class="action" href="<?php echo $this->serverUrl.'games/'.$item['id']?>"><?php echo $item['name']?></a></td>
      <td align="center"><?php echo $item['playing'] ? 'Идет игра' : 'Закрыта';
          echo ' [<a class="action" href="'.$this->serverUrl.'games/'.$item['id']
            .'/'.($item['playing'] ? 'close' : 'open').'">'.
            ($item['playing'] ? 'Закрыть' : 'Открыть').'</a>]';
      ?></td>
    </tr>
    <?php endforeach;
      else:
    ?>
      <td colspan="4">Вы не ведете ни одной игры</td>
    <?php endif; ?>
  </table>
