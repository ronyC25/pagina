<?php
include("connection.php");
$con = connection();

$id = $_GET['id'];

$sql = "SELECT * FROM users WHERE id=$id";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_array($query);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div clas="users-form">
        <form action="edit_user.php" method = "POST">
            <h1>EDITAR </h1>
            <input type="hidden" name="id" value="<?= $row['id']?>">
            <input type="text" name="name" value="<?= $row['name']?>">
            <input type="text" name="lastname" value="<?= $row['lastname']?>">
            <input type="text" name="username" value="<?= $row['username']?>">
            <input type="text" name="password" value="<?= $row['password']?>">
            <input type="text" name="email" value="<?= $row['email']?>">

            <input type="submit" value="Actualizar Usuario">

        </form>

    </div>
    
</body>
</html>