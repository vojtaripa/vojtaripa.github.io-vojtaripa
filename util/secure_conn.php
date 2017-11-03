<?php
/*
    // make sure the page uses a secure connection
    $https = filter_input(INPUT_SERVER, 'HTTPS');
    if (!$https) {
        $host = filter_input(INPUT_SERVER, 'HTTP_HOST');
        $uri = filter_input(INPUT_SERVER, 'REQUEST_URI');
        $url = 'https://' . $host . $uri;
        header("Location: " . $url);
        exit();
    }
	*/
?>
<?php
    // make sure the page uses a secure connection
    if (!isset($_SERVER['HTTPS']))
    {
        $host = $_SERVER['HTTP_HOST'];
        $uri = $_SERVER['REQUEST_URI'];
        $url = 'https://' . $host . $uri;
        header("Location: " . $url);
        exit();
    }
?>