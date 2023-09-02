<?php

    require "./Core/Database.php";
    require "./Core/Config.php";

    $mysqlConfig = new \Core\Config('/var/www/config/mysql.ini');
    $database = \Core\Database::getInstance();
    $conn = $database->connect($mysqlConfig->getPdoDsnForDatabase('aooty'));

    echo '<pre>';
    var_dump($conn->query('SELECT * FROM users')->fetchAll(PDO::FETCH_ASSOC));
    echo '</pre>';
