<?php
    try {
        $con = new PDO('mysql:host=localhost;dbname=book_store', 'root', '');
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $con->exec("SET NAMES 'utf8'");

    } catch (PDOException $e) {
        echo "Connection failed: ";
    }
?>
