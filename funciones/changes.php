<?php
    session_start();  

    $host_db = "localhost";
    $user_db = "root";
    $pass_db = "";
    $db_name = "biplogin";
    $tbl_name = "users";
     
    // Connect to server and select databse.
    mysql_connect("$host_db", "$user_db", "$pass_db")or die("Cannot Connect to DataBase.");
     
    mysql_select_db("$db_name")or die("Cannot Select DataBase");
    
     
    $sql = "UPDATE `users` SET `modified` = now() WHERE `username` = '".$_SESSION['username']."';";
    echo $sql;
    $sql2 = "INSERT INTO `cambios` (`fecha`, `user`) VALUES (now(), '".$_SESSION['username']."');";
    mysql_query($sql)or die(mysql_error());
    mysql_query($sql2)or die(mysql_error());

?>