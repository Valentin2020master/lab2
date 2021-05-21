<?php

session_start();

require_once "vendor/autoload.php";

use Twilio\Rest\Client;

$sid = "ACc34280bfa5a34e2fa92487b89d2dfa7b";
$token = "ca6ffa6afc431efe4d2e6315f0d6b8d1";

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    include 'db.php';
    

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_object($result);
        if (password_verify($password, $row->password)) {
            if ($row->is_tfa_enabled) {
                $row->is_verified = false;
                $_SESSION["user"] = $row;

                $pin = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);

                $sql = "UPDATE users SET pin = '$pin'  WHERE id = '" . $row->id . "'";
                mysqli_query($conn, $sql);

                $client = new Client($sid, $token);
                $client->messages->create(
                    $row->phone, array(
                        "from" => "+17343898522",
                        "body" => "Codul dvs. de autentificare cu 2 factori este: " . $pin
                    )
                );

                header("Location: enter-pin.php");
            } else {
                $row->is_verified = true;
                $_SESSION["user"] = $row;
                header("Location: index.php");
            }
        } else {
            echo "Parola gresita";
        }
    } else {
        echo "Nu există";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-compatible" content="ie=edge">
    <title>Autentificarea</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div style="text-align: center;" class=container4>
    <h5>Autentificarea</h5>
    <form method="POST" action="login.php">
        <p>
            <input type="email" name="email" placeholder="Introduceti email">
        </p>
        <p>
            <input type="password" name="password" placeholder="Password">
        </p>

        <p>
            <input type="submit" name="login">
        </p>
        Daca nu sunteti inregistrati,
        <a href="register.php">
            Inregistrativa
        </a>
    </form>
</div>
</body>
</html>




