<?php
  include_once("config.php");

    $uri = empty($_GET['r']) ? "":$_GET['r'];
    $str = explode("/",$uri);

    if(empty($str[0])){
      $str[0] = "index";
    }
    if(empty($str[1])){
      $str[1] = "index";
    }

    $controllerName = ucfirst($str[0])."Controller";
    $controllerAction = $str[1];


    // echo $controllerName.$controllerAction."---";
  try {
      if (class_exists($controllerName)) {
         $oController = new $controllerName();
         
         try {
                if (method_exists($controllerName,$str[1])) 
                    $oController->$str[1](); 
                else
                  echo "no method";
            } catch (Exception $e) {
                // echo 'Caught exception: ',  $e->getMessage(), "\n";
              echo "no method";
            }

      }

  } catch (Exception $e) {
      // echo 'Caught exception: ',  $e->getMessage(), "\n";
    echo "Class not found";
  }
    

?>