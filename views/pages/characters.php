  <table cellpadding=1 cellspacing=1 class="list" style="width:auto;">
    <tr>
      <th>id</th><th>name</th><th>gid</th><th>dead</th><th>approved</th><th>modified</th>
    </tr>
    <?php
      if($this->db_characters):
        foreach($this->db_characters as $item):
    ?>
    <tr>
      <td><?php echo $item['id']?></td>
      <td><a class="action" href="<?php echo $this->serverUrl.'characters/'.$item['id']?>"><?php echo $item['name']?></a></td>
      <td><?php
        $gid = find($this->db_games, $item['gid']);
        echo $gid['name'];
        ?></td>
      <td><?php echo $item['dead'] ? $item['dead'] : 'Жив'?></td>
      <td><?php echo $item['approved'] ? 'Подтвержден': 'Не подтвержден'?></td>
      <td><?php echo $item['modified']?></td>
    <?php endforeach;
      else:
    ?>
      <td colspan="5">У Вас нет персонажей</td>
        <?php endif; ?>
    </tr>
  </table>
