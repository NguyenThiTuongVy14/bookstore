<?php
    try {
        $con = new PDO('mysql:host=localhost;dbname=mystore-complete', 'root', '');
        // Set the PDO error mode to exception
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: ";
    }
?>
