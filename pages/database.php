
<?php
    $dsn = 'mysql:host=vojta-data.db.sonic.net;dbname=vojta_data';
    $username = 'vojta_data-all';
    $password = '590d05cd';

    try {
        $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('database_error.php');
        exit();
    }
?>