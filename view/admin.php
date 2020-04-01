<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>admin</title>
        <link rel="stylesheet" href="public/styles/style.css"/>
        
    </head> 
    <body>
        <div id="adminMainWrapper">
            <?php include("results.php"); ?>
            <form id='resetForm' action= 'index.php' method='post'>
                <input type="hidden" name="action" value="newQuestion"/>
                <input type="submit" id="resetButton" value='reset'/>
            </form>   
        </div>
    </body>
    <script src="public/js/admin.js"></script>
    <script src="public/js/results.js"></script>
</html>