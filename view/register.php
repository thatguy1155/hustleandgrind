<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register</title>
        <link rel="stylesheet" href="public/css/style.css"/>
        <link rel="stylesheet" type="text/css" href="public/css/mobileScreen.css">
    </head> 
    <body>
        <div id="formWrapper">
            <form method="post" action="index.php">
                <input type="hidden" name="action" value="vote">
                <label for="name">Name</label>
                <input type="text" name="name" id="name">
                <label for="email">Email</label>
                <input type="text" name="email" id="email">
            </form>
        </div>
    </body>
</html>