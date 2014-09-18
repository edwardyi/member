<?php
/*
 * Created on 2005/7/18
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
        $mysql_server = $app_env['MYSQL_HOST'];
        $mysql_user = $app_env['MYSQL_USER'];
        $mysql_password = $app_env['MYSQL_PASS'];
        $conn = @mysql_connect($mysql_server, $mysql_user, $mysql_password);
        $db_selected = mysql_select_db($app_env['MYSQL_DB'], $conn);
        
		if (!$db_selected)
		{
		  die ("Can\'t use DB : " . mysql_error());
		}
  
        mysql_query('SET NAMES utf8');  // add by Jeffrey Yeh 2007-4-11
        mysql_query('SET CHARACTER_SET_CLIENT=utf8');  // add by Jeffrey Yeh 2007-4-11
        mysql_query('SET CHARACTER_SET_RESULTS=utf8');  // add by Jeffrey Yeh 2007-4-11
         
?>
