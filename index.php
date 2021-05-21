<?php

session_start();
include 'db.php';

if (isset($_SESSION["user"]) && $_SESSION["user"]->is_verified) {

$user_id = $_SESSION["user"]->id;

if (isset($_POST["toggle_tfa"])) {
    $is_tfa_enabled = $_POST["is_tfa_enabled"];

    $sql = "UPDATE users SET is_tfa_enabled = '$is_tfa_enabled' WHERE id = '$user_id'";
    mysqli_query($conn, $sql);

    echo "<p>Setările s-au schimbat</p>";

}

$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_object($result);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-compatible" content="ie=edge">
    <title>2AF</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div style="text-align: center;" class=container4>

    <form method="POST" action="index.php">
        <h5>Sunteti autorizat cu succes, doriti sa modificati autentificare?</h5>

        <p>
            <input type="radio" name="is_tfa_enabled"
                   value="1" <?php echo $row->is_tfa_enabled ? "checked" : ""; ?>> Autentificare dubla
        </p>
        <p>
            <input type="radio" name="is_tfa_enabled"
                   value="0" <?php echo !$row->is_tfa_enabled ? "checked" : ""; ?>> Autentificare simpla
        </p>

        <input type="submit" name="toggle_tfa">
    </form>

    <a href="logout.php">
        Ieșiți
    </a>

    <?php
    } else {
        header("Location: login.php");
    }
    ?>


</div>

</body>
</html>







