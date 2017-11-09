<?php

require_once "browserCheck.php";

$browser = new browser();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Browser Check</title>
        <link rel="stylesheet" type="text/css" media="all" href="browser.css"/>
    </head>
    <body>
        <h1>Browser Compatability Check</h1>
        <div>You are running:</div>
        <div><?echo $browser->agentString;?></div>
        <div><?echo $browser->drawPage();?></div>
    </body>
</html>
