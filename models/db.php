<?php
# --------------------------------------------------------------------------- #
#  DndClient/models/db.php
# --------------------------------------------------------------------------- #
#
# Объект для работы с БД
#
# --------------------------------------------------------------------------- #
#  winzo.delirium
# --------------------------------------------------------------------------- #

class tDataBase
{
  function __construct($host, $db, $login, $password)
  {
    //$this->DEBUG = '';
    
    $this->host = $host;
    $this->db = $db;
    $this->login = $login;
    $this->password = $password;
    $this->connected = NULL;
  }
  
  public function connect()
  {
    if (!$this->connected)
    {
      $this->connected = mysql_connect($this->host,$this->login ,$this->password)
        or die(mysql_error());
      mysql_select_db($this->db, $this->connected)
        or die(mysql_error());
    }  
  }
  
  function __destruct()
  {
    if ($this->connected)
      mysql_close();
  }
    
// //// Общие функции
  public function getTable($table,$sort="")
  # Table: *
  {
    if (!$this->connected)
      $this->connect();
    // Возвращает массив данных из бд
    if($sort)
      $sort = ' ORDER BY '.$sort;
    $query = mysql_query("SELECT * FROM `$table`".$sort)
      or die(mysql_error());
    /*if(isset($this->DEBUG))
      $this->DEBUG .= "SQL: SELECT * FROM `$table`".$sort;*/
    $result = array();
    while($row = mysql_fetch_assoc($query))
      $result[] = $row;
    return $result;
  }

// //// Операции над пользователями
  public function addUser($user)
  # Table: Users
  {
    if (!$this->connected)
      $this->connect();
    // Создание нового пользователя
    $query = mysql_query("INSERT INTO `Users` (login,email,password)".
      "VALUES ('".$user['login']."', '".$user['email']."', '".md5($user['password'])."')");
    if(!$query)
      return mysql_error();
    else
      return false;
  }

// //// Функции пользователя
  public function getUserData($login) # Table: Users
  {
    if (!$this->connected)
      $this->connect();
    // Массив данных о юзере
    $query = mysql_query("SELECT id,login,email,password FROM `Users` ".
      "WHERE login = '".$login."'");
    if(!$query || !$user = mysql_fetch_assoc($query))
      return false;
    else
      return $user;
  }
  public function getUserDataFromId($uid) # Table: Users
  {
    if (!$this->connected)
      $this->connect();
    // Массив данных о юзере
    $query = mysql_query("SELECT id,login,email,password FROM `Users` ".
      "WHERE id = '".$uid."'");
    if(!$query || !$user = mysql_fetch_assoc($query))
      return false;
    else
      return $user;
  }

  public function getGame($gid) # Table: Games
  {
    if (!$this->connected)
      $this->connect();
    // Данные игры
    $query = mysql_query("SELECT id,uid,name,playing,tutorial,description FROM `Games` ".
      "WHERE id = '".$gid."'");
    if(!$query)
      return false;
    return mysql_fetch_assoc($query);
  }

  public function getUserGames($uid) # Table: Games
  {
    if (!$this->connected)
      $this->connect();
    // Массив игр, владельцем которых является юзер
    $query = mysql_query("SELECT id,name,playing,description FROM `Games` ".
      "WHERE uid = '".$uid."'");
    if(!$query)
      return false;
    $result = array();
    while($row = mysql_fetch_assoc($query))
      $result[] = $row;
    return $result;
  }

  public function getUserCharacters($uid) # Table: Characters
  {
    if (!$this->connected)
      $this->connect();
    // Массив игр, владельцем которых является юзер
    $query = mysql_query("SELECT id,name,approved,dead,modified FROM `Characters` ".
      "WHERE uid = '".$uid."'");
    if(!$query)
      return false;
    $result = array();
    while($row = mysql_fetch_assoc($query))
      $result[] = $row;
    return $result;
  }
  

// //// Функции ГМа
// Персонажи
    public function getGameCharacters($game)
    # Table: Games
    {
        // Массив всех персонажей игры
    }
    public function addGameCharacter($game,$characterOwner)
    # Table: Games, Characters
    {
        // Добавление нового персонажа в игру
    }
    public function delGameCharacters($game)
    # Table: Games
    {
        // Добавление новых персонажей
    }
// Игра
    public function addGame($game)
    # Table: Games
    {
        // Добавление новой игры
        return 'Function not finished';
    }
    public function delGame($game)
    # Table: Games
    {
        // Удаление игры
    }
    public function setGameName($name)
    # Table: Games
    {
        // Изменение названия игры
    }
    public function setGameData($game)
    # Table: GameData
    {
        // Изменение полей данных игры
    }

// //// Функции и пользователя и ГМа
    public function getCharacter($character)
    # Table: Characters
    {
        // Массив данных одного персонажа
    }
    public function setCharacter($character,$data)
    # Table: Characters
    {
        // Изменение данных персонажа
    }
}
