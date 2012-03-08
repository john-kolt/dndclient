  <table cellpadding=1 cellspacing=1 class="list" style="width:auto;">
    <tr>
      <th>owner</th><th>playing</th><th>tutorial</th><th>description</th>
    </tr>
    <?php
      if($this->db_game):
    ?>
    <tr>
      <td><?php echo $this->db_owner['name']?></td>
      <td><?php echo $this->db_game['playing'] ? 'Идет игра' : 'Закрыта';?></td>
      <td><?php
        if(isset($this->db_game['tutorial']))
          echo $this->db_game['tutorial']
      ?></td>
      <td><?php
        if(isset($this->db_game['description']))
          echo $this->db_game['description']
        ?></td>
    </tr>
    <?php endif; ?>
  </table>
