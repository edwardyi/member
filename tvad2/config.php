<?php
   ini_set("display_errors",0);
   session_start();
   date_default_timezone_set("Asia/Taipei");
 
   // 檔案路徑設定
   $scriptfilename = __FILE__;

	 @eregi("(.*)config", $scriptfilename, $regs);
   $_root_path = $regs[1];
   unset($scriptfilename);
   unset($regs);
   
   $_app_path = $_root_path ."/";
   $url = "/";
    
   
   define('APP_ROOT_PATH', $_app_path);
   define('HTML_ROOT_PATH', $_root_path);
   
   define('HTML_URL', $url);
   define('HTML_ROOT_URL', $url);
   
   define('HTML_LANG_URL', $url."language/");
   define('HTML_LANG_PATH', $_root_path."language/");
   
   define('HTML_VIDEO_PATH', "/home/");

   include_once(APP_ROOT_PATH."_config/app_env.php");
   include_once(APP_ROOT_PATH."_config/db_conn.php");
   // require_once(APP_ROOT_PATH.'_lib/DB_class.php');


    //LINUX須實做
    function autoload_class ( $namespace_class ){ 
          // Adapt to OS. Windows uses '\' as directory separator, linux uses '/' 
          $path_file = str_replace( '\\', DIRECTORY_SEPARATOR, $namespace_class ); 
          // Get the autoload extentions in an array 
          $autoload_extensions = explode( ',', spl_autoload_extensions('.php') ); 
          // Loop over the extensions and load accordingly 
          foreach( $autoload_extensions as $autoload_extension ){ 
            include_once( $path_file . $autoload_extension ); 
          } 
    }
   // Your custom class dir
   define('DB_DIR', '_lib/db/');
   define('CONTROLLER_DIR', '_app/');
    // Add your class dir to include path
    set_include_path(get_include_path().PATH_SEPARATOR.DB_DIR);
    set_include_path(get_include_path().PATH_SEPARATOR.CONTROLLER_DIR);
    // You can use this trick to make autoloader look for commonly used "My.class.php" type filenames
    spl_autoload_extensions('.php');
   
    // Use default autoload implementation
    spl_autoload_register('autoload_class');
   
   require_once(APP_ROOT_PATH.'_lib/Template.php');

   

  
?>