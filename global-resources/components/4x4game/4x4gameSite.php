<?php
require '4x4connectGame.php';

$output = '
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport"
                  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>4 i rad</title>
    
            <link rel="stylesheet" href="../global-resources/components/4x4game/4x4style.css" type="text/css">
        </head>
        <body>
            <h1>4 i rad</h1>
            <button id="start4x4Game">Start game</button>
            <h2 id="winner"></h2>
            <div id="board"></div>
        </body>
        <script src="../global-resources/components/4x4game/4x4script.js"></script>
    </html>
';

echo $output;