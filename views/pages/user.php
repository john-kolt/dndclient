<table cellpadding=0 cellspacing=0 class="simple">
  <tr>
    <td>
      Пользователи
      <table cellpadding=1 cellspacing=1 class="list">
        <tr>
          <th>id</th><th>login</th><th>email</th>
        </tr>
        <?php
          foreach($this->db_users as $item):
        ?>
        <tr>
          <td><?php echo $item['id']?></td>
          <td><?php echo $item['login']?></td>
          <td><?php echo $item['email']?></td>
        </tr>
        <?php endforeach; ?>
      </table>
    </td>
    <td>
      Ваши игры [<a class="action" href="<?php echo $this->serverUrl;?>games/new">Создать</a>]
      <table cellpadding=1 cellspacing=1 class="list">
        <tr>
          <th>id</th><th>name</th><th>description</th><th>playing</th>
        </tr>
        <?php
        if($this->db_games):
          foreach($this->db_games as $item):
        ?>
        <tr>
          <td><?php echo $item['id']?></td>
          <td><?php echo $item['name']?></td>
          <td><?php echo $item['description']?></td>
          <td align="center"><?php echo $item['playing'] ? 'Идет игра' : 'Закрыта';
                    echo '<br>[<a class="action" href="'.$this->serverUrl.'games/'.$item['id']
                    .'/'.($item['playing'] ? 'close' : 'open').'">'.
                    ($item['playing'] ? 'Закрыть' : 'Открыть').'</a>]';
          ?></td>
        </tr>
        <?php endforeach;
        else:
          ?>
          <td colspan="4">Вы не ведете ни одной игры</td>
        <?php endif; ?>
      </table><br>
      Ваши персонажи
      <table cellpadding=1 cellspacing=1 class="list">
        <tr>
          <th>id</th><th>gid</th><th>name</th><th>dead</th><th>approved</th><th>modified</th>
        </tr>
        <?php
        if($this->db_characters):
          foreach($this->db_characters as $item):
        ?>
        <tr>
          <td><?php echo $item['id']?></td>
          <td><?php echo $item['gid']?></td>
          <td><?php echo $item['name']?></td>
          <td><?php echo $item['dead'] ? $item['dead'] : 'Жив'?></td>
          <td><?php echo $item['approved'] ? 'Подтвержден': 'Не подтвержден'?></td>
          <td><?php echo $item['modified']?></td>
        </tr>
        <?php endforeach;
        else:
          ?>
          <td colspan="5">У Вас нет персонажей</td>
        <?php endif; ?>
      </table>
    </td>
  </tr>
</table>
