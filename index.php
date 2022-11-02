<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google API Video App</title>
</head>

<body>
<h1>Google API Development App</h1>

    <?php
    //print_r($_SESSION['google_access_tokens']);
    if (!isset($_SESSION['google_access_tokens'])) {
    ?>
        <a href="requests/google_redirect.php"><input type="button" id="loginGoogle" class="btn btn-primary" value="Log In" /></a>
    <?php
    } else {
        ?>
        <p><a href="log_off.php"><input type="button" id="loginGoogle" class="btn btn-primary" value="Log Off" /></a></p>
        <p><a href="youtube_analytics">YouTube Analytics API</a></p>
        <p><a href="voice_to_text">Speech to Text API</a></p>
        <?php
    }
    ?>
</body>

</html>