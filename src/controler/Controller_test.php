<?php

namespace cocktails\controler;

use \cocktails\vue\Vue_test;

class Controller_test {

  public function test() {
    if (isset($_GET) && sizeof($_GET) == 2){
      $calcul = $_GET['x'] * $_GET['y'];
      $vue = new Vue_test($calcul);
      echo $vue->render(1);
    } else {
      echo "C'est pas bon";
    }

  }

}
