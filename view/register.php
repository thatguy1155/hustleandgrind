<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register</title>
        <link rel="stylesheet" href="public/styles/style.css"/>
        <link rel="stylesheet" type="text/css" href="public/styles/mobileScreen.css">
    </head> 
    <body>
        <div id="registerFormWrapper">
            <form method="post" action="index.php" id="registerForm">
                <p id="errorMsg"><?= $errorMsg = isset($errorMsg) ? $errorMsg : ''; ?></p>
                <input type="hidden" name="action" value="register">
                <label for="name">Name</label>
                <input type="text" name="name" id="name">
                <label for="email">Email</label>
                <input type="text" name="email" id="email">
                <input type="submit" name="register" id="register" value="Register">
            </form>
        </div>
    </body>
</html>

