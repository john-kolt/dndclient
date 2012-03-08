<?php
# DndClient/controller.php
# Собственно, главный модуль реализации логики
# winzo.delirium

require_once('models/db.php');
require_once('models/view.php');
require_once('models/guard.php');

function find($array, $id)
{
  foreach($array as $item)
    if($item['id'] == $id)
      return $item;
  return false;
}

class tMailer
{
  public function __construct($mailer, $address)
  {
    $this->mailer = $mailer;
    $this->address = $address;
  }
  public function send($subject, $message, $to)
  {
    $header = //'From: '.$this->address."\r\n".
      //'Reply-to: '.$this->address."\r\n".
      'Content-type: text/html; charset="utf-8"'."\r\n";
    return mail($to, $subject, $message, $header);
  }
}

class tDndClient
{
  public function __construct($time_start)
  {
    $this->DEBUG = '';
    
    $this->actions = explode('/',$_SERVER['REQUEST_URI']);
    
    $this->view = new tView();
    $this->mailer = new tMailer('winzo','winzo.delirium@gmail.com');
    $this->db = new tDataBase('localhost','dnd','root','wFuYJrMq');
    $this->user = new tGuard($this->db, $this->mailer);
    $this->view->db_user = $this->user->data;
    
    $this->view->time_start = $time_start;
    $this->view->logged = $this->user->logged;
    if(isset($_SESSION['dnd_error']))
    {
      $this->error = $_SESSION['dnd_error'];
      unset($_SESSION['dnd_error']);
    }
    $a = array();
    for ($i = 1; $i < count($this->actions); $i++)
    {
      $a[] = $this->actions[$i];
    }
    $this->actions = $a;
    $this->view->actions = $a;
  }
  
  public function location($url)
  {
    if($this->view->error)
      $_SESSION['dnd_error'] = $this->view->error;
    header('Location: '.$url);
    exit(0);
  }

  public function return404()
  {
    header('HTTP/1.0 404 Not Found');
    $this->view->title = 'Error 404';
    $this->view->header = 'Error 404';
    $this->view->addError('Error 404: file not found');
    $this->view->setBody('404');
    $this->view->show();
  }

  public function mustBeAuthorized()
  {
    if(!$this->user->logged)
    {
      header('Location: /user/login');
      $this->view->title = 'Authorization';
      $this->view->header = 'You must be logged in';
      $this->view->addError('Error: You are not logged in the system');
      $this->view->setBody('forms/loginForm');
      $this->view->show();
    }
  }

  public function mustBeNotAuthorized()
  {
    if($this->user->logged)
    {
      $this->view->addError('Error: You are logged in the system');
      $this->indexAction();
      $this->view->show();
    }
  }

  public function indexAction()
  {
    $this->mustBeAuthorized();
    $this->view->title = 'Main';
    $this->view->header = 'Main';
    $this->view->body = 'The text of the main page<br>';
  }

  public function userAction()
  {
    if(!isset($this->actions[1]))
      $this->actions[1]='';
    switch($this->actions[1])
    {
      case '':
        $this->mustBeAuthorized();
        $this->view->title = 'User';
        $this->view->header = 'User';
        $this->view->body = '';
        $this->view->db_users = $this->db->getTable('Users');
        $this->view->db_games = $this->user->getGames();
        $this->view->db_characters = $this->user->getCharacters();
        $this->view->setBody('pages/user');
      break;
      case 'login':
        $this->mustBeNotAuthorized();
        $this->view->title = 'Authorization';
        $this->view->header = 'Authorization';
        $this->view->setBody('forms/loginForm');
        if($_POST)
        {
          if(!$this->view->addError($this->user->login($_POST['login'],$_POST['password'])))
            $this->location('/');
        }
      break;
      case 'register':
        $this->mustBeNotAuthorized();
        $this->view->title = 'Registration';
        $this->view->header = 'Registration';
        $this->view->setBody('forms/registerForm');
        $error = '';
        if($_POST)
        {
          if(!$this->view->addError($this->user->register($_POST['login'], $_POST['email'], $_POST['password'])))
            $this->location('/');
        }
      break;
      case 'logout':
        $this->view->addError($this->user->logout());
        $this->location('/');
      break;
      default:
        $this->return404();
      break;
    }
  }

  public function gamesAction()
  {
    $this->mustBeAuthorized();
    if(!isset($this->actions[1]))
      $this->actions[1]='';
    switch($this->actions[1])
    {
      case '':
        $this->view->title = 'Games';
        $this->view->header = 'Games';
        $this->view->db_games = $this->db->getTable('Games');
        $this->view->setBody('pages/games');
      break;
      case 'new':
        $this->view->title = 'Creating new game';
        $this->view->header = 'Creating new game';
        $this->view->db_games = $this->db->getTable('Games');
        $this->view->setBody('pages/game_new');
        if($_POST)
        {
          if(!$this->view->addError($this->db->addGame($_POST['name'], $this->user->data['id'], $_POST['tutorial'], $_POST['description'])))
            $this->location('/');
        }
      break;
      default:
        if(is_numeric($this->actions[1]))
        {
          $this->view->db_game = find($this->user->games, $this->actions[1]);
          
          if(!$this->view->db_game)
            $this->view->db_game = $this->getGame($this->actions[1]);
          else
            $this->view->db_owner = $this->user->data;
          if(!$this->view->db_owner)
            $this->view->db_owner = $this->db->getUserDataFromId($this->view->db_game['uid']);
          
          if(!$this->view->db_game)
            $this->return404();
          
          $this->view->title = $this->view->db_game['name'];
          $this->view->header = $this->view->db_game['name'];
          $this->view->setBody('pages/game');
        }
        else
          $this->return404();
      break;
    }
  }

  public function charactersAction()
  {
    $this->mustBeAuthorized();
    if(!isset($this->actions[1]))
      $this->actions[1]='';
    switch($this->actions[1])
    {
      case '':
        $this->view->title = 'Characters';
        $this->view->header = 'Characters';
        $this->view->db_games = $this->user->games;
        $this->view->db_characters = $this->db->getTable('Characters');
        $this->view->setBody('pages/characters');
      break;
      default:
        $this->return404();
      break;
    }
  }
}

$dndclient = new tDndClient($time_start);

switch($dndclient->view->actions[0])
{
  case '':
    $dndclient->indexAction();
  break;
  case 'user':
    $dndclient->userAction();
  break;
  case 'games':
    $dndclient->gamesAction();
  break;
  case 'characters':
    $dndclient->charactersAction();
  break;
  default:
    $dndclient->return404();
  break;
}

$dndclient->view->show();
