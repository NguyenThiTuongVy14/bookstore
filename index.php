<?php
session_start();


include('./database/connectdb.php');
include('./functions/function.php');
include('class/PageSize.php');

//add view
include('./includes/header.php');
include('./includes/home.php');
include('./includes/footer.php');

?>