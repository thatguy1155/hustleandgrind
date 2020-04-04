<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register</title>
        <link rel="stylesheet" href="public/styles/style.css"/>
    </head> 
    <body>
        <form method="post" action="index.php" id="regForm">
            <p id="errorMsg"><?= isset($errorMsg) ? $errorMsg : ''; ?></p>
            <input type="hidden" name="action" value="register">
            <div class="regInputContainer">
                <input type="text" name="name" id="name" required="">
                <label for="name">Name</label>
            </div>
            <div class="regInputContainer">		
                <input type="email" name="email" id="email" required="">
                <label for="email">Email</label>
            </div>
            <div class="regInputContainer">		
                <input type="text" name="info" id="info">
                <label for="info">Description</label>
            </div>
            <input type="submit" name="register" id="register" value="Register">
        </form>	
    </body>
</html>

