<?php
# --------------------------------------------------------------------------- #
#  DndClient/index.php
# --------------------------------------------------------------------------- #
#
# Главная страница проекта. Инклудит все остальные
#
# --------------------------------------------------------------------------- #
#  winzo.delirium
# --------------------------------------------------------------------------- #

# Засекаем время
  $time_start = microtime();

# Стартуем сессию
  session_start();

error_reporting(E_ALL);
ini_set('php_flag display_errors','on'); 
ini_set('php_value error_reporting', E_ALL);

# Конфигурация
$dnd_db_host     = 'localhost';
$dnd_db_name     = 'dnd';
$dnd_db_login    = 'root';
$dnd_db_password = 'wFuYJrMq';

# Инклудим контроллер
    include "controller.php";
