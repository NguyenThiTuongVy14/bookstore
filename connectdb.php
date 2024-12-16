<?php
    try {
        $con = new PDO('mysql:host=sql307.infinityfree.com;dbname=if0_37926420_book_store', 'if0_37926420', 'Tuongvy140703');
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $con->exec("SET NAMES 'utf8'");

    } catch (PDOException $e) {
        echo "Connection failed: ";
    }
?>
