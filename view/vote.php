<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Vote</title>
        <link rel="stylesheet" href="../styles/style.css"/>
    </head> 
    <body>
        <div id="buttons">
            <form method="POST" action="index.php">
                <input type="hidden" name="action" value="vote"/>
                <input type="hidden" name="userId" value=<?= $_COOKIE['userId']?> />
                <input type="submit" name="a" value="A" id="aBtn"/>
                <input type="submit" name="b" value="B" id="bBtn"/>
            </form>
        </div>
    </body>
</html>