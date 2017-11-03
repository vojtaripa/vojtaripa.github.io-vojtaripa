<?php
    /*$dsn = 'mysql:host=vojta-data.db.sonic.net;dbname=vojta_ripa';
	//vojta-data.db.sonic.net
	//b.custsql.sonic.net
    $username = 'vojta_data';
    $password = '623ae2ef';*/
	/*
	 $dsn = 'mysql:host=wren.arvixe.com;dbname=look4ter_7294';
    $username = 'look4ter_7294';
    $password = 'cs551372';
    */
	
	
    mysql_connect("vojta-data.db.sonic.net", "vojta_data-all", "623ae2ef") or die(mysql_error());  
	mysql_select_db("vojta_data") or die(mysql_error()); 
	/*
    try {
        $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('database_error.php');
        exit();
    }*/
?>