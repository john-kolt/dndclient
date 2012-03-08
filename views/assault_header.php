<!DOCTYPE html>
<html lang="ru">
<head>
  <title><?php echo $this->title; ?></title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="<?php echo $this->css; ?>">
  <script src="<?php echo $this->js; ?>"></script>  
</head>
<body>
<section class=header>
  <nav>
    <?php
      $nav_this = '<span class=this>';
      $nav_this_end = '</span>';
      
      if ($this->logged):
        
        echo "<a class=nav style='float: right;' href='/user/logout'>logout</a>";
      
        if($this->actions[0]!='')
          {echo "<a class=nav href='/'>main</a>";}
        else
          {echo $nav_this."main$nav_this_end";}
      
        if($this->actions[0]=='user' && !isset($this->actions[1]))
          {echo $nav_this."user$nav_this_end";}
        else
          {echo "<a class=nav href='/user'>user</a>";}
      
        if($this->actions[0]!='games')
            {echo "<a class=nav href='/games'>games</a>";}
        else
            {echo $nav_this."games$nav_this_end";}
        
        if($this->actions[0]!='characters')
            {echo "<a class=nav href='/characters'>characters</a>";}
        else
            {echo $nav_this."characters$nav_this_end";}

        echo "You logged as ".$this->db_user['name'];
            
      else:
      
        if(isset($this->actions[1]) && $this->actions[1]=='login')
            {echo $nav_this."login$nav_this_end";}
        else
            {echo "<a class=nav href='/user/login'>login</a>";}
        
        if(isset($this->actions[1]) && $this->actions[1]=='register')
            {echo $nav_this."register$nav_this_end";}
        else
            {echo "<a class=nav href='/user/register'>register</a>";}
        
      endif;
    ?>

  </nav>
  <?php
  /*if(isset($this->notice))
    echo '<div class=notice>'.$this->notice.'</div>';*/
    
  if($this->success)
    echo '<div class=success>'.$this->success.'</div>';

  if($this->error)
    echo '<div class=error>'.$this->error.'</div>';
  ?>

  <header>
<?php
  if(isset($this->header))
  {
    echo $this->header;
  }
?>

  </header>
</section>
<section class=content>
  <article>
