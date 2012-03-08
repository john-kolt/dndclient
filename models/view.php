<?php
#  DndClient/models/view.php
#  winzo.delirium

class tView
{
  public function __construct()
  {
    $this->success = '';
    if(isset($_SESSION['dnd_error']))
    {
      $this->error = $_SESSION['dnd_error'];
      unset($_SESSION['dnd_error']);
    }
    else
      $this->error = '';
    $this->serverUrl = "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/";
    $this->theme = 'assault';

    $this->file = $this->theme;
    $this->file_body = $this->theme;
    $this->css = $this->serverUrl."public/css/$this->theme.css";
    //$this->js = "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/public/css/$this->theme.js";
    $this->js = 'http://html5shim.googlecode.com/svn/trunk/html5.js';
  }

  public function addError($error)
  {
    if($error)
    {
      $this->error .= "$error<br>";
      return $error;
    }
  }

  public function set($template)
  {
    if($template)
    {
      $this->file = $template;
      $this->file_body = $template;
    }
    else
      die("tView::set($template): template not set");
  }

  public function setBody($template)
  {
    if($template)
      $this->file_body = $template;
    else
      die("tView::setBody($template): template not set");
  }

  public function show($fileShow="")
  {
    if($fileShow)
      $this->file = $fileShow;
    include 'views/'.$this->file.'_header.php';
    include 'views/'.$this->file_body.'.php';
    include 'views/'.$this->file.'_footer.php';
    
    exit(0);
  }
}
