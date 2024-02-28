<?php 
    require 'db_connect.php' ;
    if(isset($_POST['username'])){
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $type = $_POST['type'];

    $sql ="INSERT INTO users (name, username, password, type) VALUES (?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $exec = $stmt->execute(array($name, $username, $password, $type));

        if($exec){
            header("Location: login.php");
        }

    }else {
        echo "Register unsuccessful";
    }



?>