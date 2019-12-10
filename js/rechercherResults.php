<?php

require_once('../vendor/autoload.php');

use \cocktails\controleur\ControleurRecettes;

session_start();

if (isset($_POST['souhaites']) || isset($_POST['nonsouhaites'])){
  $_SESSION['souhaites'] = $_POST['souhaites'];
  $_SESSION['nonsouhaites'] = $_POST['nonsouhaites'];
}
