<?php

if (isset($_POST["register"])) {
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $password = password_hash($password, PASSWORD_DEFAULT);

    include 'db.php';
    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    $sql = "INSERT INTO users (email, phone, password, is_tfa_enabled, pin) VALUES ('$email', '$phone', '$password', 0, '')";
    mysqli_query($conn, $sql);

    header("Location: login.php");

}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-compatible" content="ie=edge">
    <title>Forma de inregistrare</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div style="text-align: center;" class=container4>

    <h5>Forma de inregistrare</h5>
    <form method="POST" action="register.php">
        <p>
            <input type="email" name="email" placeholder="Introduceti email">
        </p>
        <p>
            <input type="text" name="phone" placeholder="Phone">
        </p>
        <p>
            <input type="password" name="password" placeholder="Password">
        </p>
        <p>
            <input type="submit" name="register">
        </p>
        Daca deja aveti un cont,
        <a href="login.php">
            Autentificațivă
        </a>
    </form>
</div>


</body>
</html>