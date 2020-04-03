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
                <input type="hidden" name="xml" value="1"/>
                <p id="newQsField">
                    <label for="newQs">New question:</label>
                    <input type="text" name="newQs" id="newQs">
                </p>
                <p id="newOptionsField">
                    <label for="newOptionA">Option A</label>
                    <input type="text" name="newOptionA" id="newOptionA">
                    <label for="newOptionB">Option B</label>
                    <input type="text" name="newOptionB" id="newOptionB">
                </p>
                <input type="submit" id="resetButton" value='reset'/>
            </form>   
        </div>
    </body>
    <script src="public/js/results.js"></script>
</html>