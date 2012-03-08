<?php
#  DndClient/models/guard.php
#  winzo.delirium

#$gpADMIN = 1;
#$gpMODER = 2;

class tGuard
{
  //private $permissions;
  //private $gpADMIN = 1;
  //private $gpMODER = 2;
  
  function __construct($db, $mailer)
  {
    $this->db = $db;
    $this->mailer = $mailer;
    $this->logged = isset($_SESSION['dnd_user_login']);
    if($this->logged)
    {
      $this->login = $_SESSION['dnd_user_login'];
      $this->email = $_SESSION['dnd_user_email'];
      $this->games = $_SESSION['dnd_user_games'];
      $this->characters = $_SESSION['dnd_user_characters'];
      //$this->permissions = $_SESSION['dnd_user_permissions'];
    }
  }
  
  /*public function hasPermission($permision)
  {
    switch($permission)
    {
      case 'admin':
        return $gpADMIN & $this->permissions != 0;
      break;
      case 'moderator':
        return $gpMODER & $this->permissions != 0;
      break;
    }
  }*/

  public function login($login, $password)
  {
    $e_login = $this->isNotValidLogin($login);
    $e_password = $this->isNotValidPassword($password);
    $e = $e_login."<br>".$e_password;
    if(!$e_login && !$e_password)
    {
      if($user = $this->db->getUserData($login));
        if($user['password']==md5($password))
        {
          $_SESSION['dnd_user_id'] = $user['id'];
          $_SESSION['dnd_user_login'] = $user['login'];
          $_SESSION['dnd_user_email'] = $user['email'];
          $_SESSION['dnd_user_games'] = $this->db->getUserGames($user['id']);
          $_SESSION['dnd_user_characters'] = $this->db->getUserCharacters($user['id']);
          return false;
        }
      return 'Bad login or password';
    }
    else
      return $e;
  }

  public function register($login, $email, $password)
  {
    $e_login = $this->isNotValidLogin($login);
    $e_email = $this->isNotValidEmail($email);
    $e_password = $this->isNotValidPassword($password);
    
    $e = $e_login."<br>".$e_email."<br>".$e_password;
    
    if(!$e_login && !$e_email && !$e_password)
    {
      if(!$this->db->addUser(array(
        'login' => $login,
        'email' => $email,
        'password' => $password)));
      {
        $user = $this->db->getUserData($login);
        
        $_SESSION['dnd_user_id'] = $user['id'];
        $_SESSION['dnd_user_login'] = $user['login'];
        $_SESSION['dnd_user_email'] = $user['email'];
        $_SESSION['dnd_user_games'] = $this->db->getUserGames($user['id']);
        $_SESSION['dnd_user_characters'] = $this->db->getUserCharacters($user['id']);
        
        if(!$this->mailer->send("DndClient",
        $login.", welcome!<br>You are registered with email ".$email, $email))
          return 'Не удалось отправить Вам письмо';

        return false;
      }
    }
    else
      return $e;
  }
  
  public function logout()
  {
    if($this->login)
    {
      unset($this->login, $this->email, $this->games, $this->characters);
      unset($_SESSION['dnd_user_login'], $_SESSION['dnd_user_email'],
        $_SESSION['dnd_user_games'], $_SESSION['dnd_user_characters']);
      
      return false;
    }
    else return 'Вы не авторизованы';
  }
  
  private function isNotValidLogin($login)
  {
    if(!preg_match("/^[a-zA-Z][-_a-zA-Z0-9]{4,59}$/", $login))
    {
      return 'Login can only contain characters: - a-z A-Z 0-9 and have a length from 5 to 60 characters long and begin with a-z A-Z';
    }
    else return '';
  }

  private function isNotValidEmail($email)
  {
    if(!preg_match('/^([a-zA-Z0-9_\.-]+)@([a-zA-Z0-9_\.-]+)\.([a-zA-Z\.]{2,6})$/', $email))
    {
      return 'Email is not valid';
    }
    else return '';
  }

  private function isNotValidPassword($pass)
  {
    if(!preg_match('/^[-&%+#*$_a-zA-Z0-9а-яА-Я]{6,60}$/', $pass))
    {
      return 'Password can only contain characters: & % + # * $ _ - a-z A-Z 0-9 а-я А-Я and have a length from 6 to 60 characters';
    }
    else return '';
  }
}
