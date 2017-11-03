<?php
    require('secure_conn.php');//_once
?>
<!DOCTYPE html>
<html>
    <head>
        <title>My Secure Page</title>
        <link rel="stylesheet" type="text/css" href="../main.css"/>
    </head>
    <body>
        <header>
            <h1>My Secure Page</h1>
        </header>
        <main>
            <h1>SSL</h1>
            <p>This page contains sensitive data.</p>
            <p><a href="index.php">
                   Continue using a secure connection</a></p>
            <p><a href="http://terryhaynes.org/php7294/Ass11/matchups/index.php">
                   Return to a regular connection</a></p>
        </main>
    </body>
</html>