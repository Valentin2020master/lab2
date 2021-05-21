<?php

session_start();

if (isset($_POST["enter_pin"]))
{
    $pin = $_POST["pin"];
    $user_id = $_SESSION["user"]->id;

    include 'db.php';

    $sql = "SELECT * FROM users WHERE id = '$user_id' AND pin = '$pin'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0)
    {
        $sql = "UPDATE users SET pin = '' WHERE id = '$user_id'";
        mysqli_query($conn, $sql);

        $_SESSION["user"]->is_verified = true;
        header("Location: index.php");
    }
    else
    {
        echo "Pin greșit";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-compatible" content="ie=edge">
    <title>PIN</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div style="text-align: center;" class=container4>

            <form method="POST" action="enter-pin.php">
                <p>
                    <input type="text" name="pin" placeholder="Enter Pin">
                </p>
                <input type="submit" name="enter_pin">
            </form>


        </div>

</body>
</html>




