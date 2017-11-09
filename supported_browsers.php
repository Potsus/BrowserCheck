<?php

// A template for each browsers options
/*
$template = array(
    'recommend' => true, //weither to reccomend the browser
    'minVer'    => 0,    //The minimum reccomended version
    'name'      => '',
    'fullName'  => '',
    'style'     => '',   // a custom class to add to the info box
    'upgrade'   => '',   // text to display when a user should upgrade their browser version
    'download'  => array(   //download links for each platform
        'Windows'       => '',
        'OS X'          => '',
        'Linux'         => '',
        'iOS'           => '',
        'Android'       => '',
        )
);
*/

//An array of browsers I have all the info for
$browsers = array(
    'CriOS'     => array(
        'recommend' => false,
        'minVer'    => 22,
        'name'      => 'chrome',
        'fullName'  => 'Google Chrome',
        'upgrade'   => '<a href="https://support.google.com/chrome/answer/95414?hl=en">Learn how to update Google Chrome</a>',
        'download'  => array(
            'iOS'           => 'https://itunes.apple.com/us/app/chrome-browser-by-google/id535886823?mt=8',
            )
        ),
    'Chrome'    => array(
        'recommend' => true,
        'minVer'    => 22,
        'name'      => 'chrome',
        'fullName'  => 'Google Chrome',
        'upgrade'   => '<a href="https://support.google.com/chrome/answer/95414?hl=en">Learn how to update Google Chrome</a>',
        'download'  => array(
            'Windows'       => 'https://www.google.com/intl/en/chrome/browser/?platform=win',
            'OS X'          => 'https://www.google.com/intl/en/chrome/browser/?platform=mac',
            'Linux'         => 'https://www.google.com/intl/en/chrome/browser/?platform=linux',
            'Android'       => 'https://play.google.com/store/apps/details?id=com.android.chrome',
            )
        ),
    'Firefox'   => array(
        'recommend' => true,
        'minVer'    => 8,
        'name'      => 'firefox',
        'fullName'  => 'Mozilla Firefox',
        'upgrade'   => '<a href="https://support.mozilla.org/en-US/kb/update-firefox-latest-version">Learn how to update Firefox</a>',
        'download'  => array(
            'Windows'       => 'http://www.mozilla.org/en-US/firefox/all/',
            'OS X'          => 'http://www.mozilla.org/en-US/firefox/all/',
            'Linux'         => 'http://www.mozilla.org/en-US/firefox/all/',
            'Android'       => 'https://play.google.com/store/apps/details?id=org.mozilla.firefox',
            ),
        ),
    'Opera'     => array(
        'recommend' => true,
        'minVer'    => 12,
        'name'      =>'opera',
        'fullName'  =>'Opera',
        'upgrade'   => '<a href="http://help.opera.com/Mac/10.50/en/autoupdate.html">Learn how to update Opera</a>',
        'download'  => array(
            'Windows'       => 'http://www.opera.com/computer/windows',
            'OS X'          => 'http://www.opera.com/computer/mac',
            'Linux'         => 'http://www.opera.com/computer/linux',
            'iOS'           => 'https://itunes.apple.com/us/app/opera-mini-web-browser/id363729560?mt=8',
            'Android'       => 'https://play.google.com/store/apps/details?id=com.opera.browser',
            )
        ),
    'Coast'     => array(
        'recommend' => true,
        'minVer'    => 1,
        'name'      =>'coast',
        'fullName'  =>'Coast',
        'upgrade'   => '',
        'download'  => array(
            'iOS'           => 'https://itunes.apple.com/us/app/chrome-browser-by-google/id535886823?mt=8',
            )
        ),
    'Safari'    => array(
        'recommend' => true,
        'minVer'    => 5,
        'name'      => 'safari',
        'fullName'  => 'Apple Safari',
        'upgrade'   => 'http://support.apple.com/kb/HT1338',
        'download'  => array(
            'Windows'       => 'http://support.apple.com/downloads/#safari',
            'OS X'          => 'http://support.apple.com/downloads/#safari',
            )
        ),
    'MSIE'      => array(
        'recommend' => true,
        'minVer'    => 9,
        'name'      => 'ie',
        'fullName'  => 'Internet Explorer',
        'style'     => '',
        'upgrade'   => 'http://windows.microsoft.com/en-us/internet-explorer/download-ie',
        'download'  => array(
            'Windows'       => 'http://windows.microsoft.com/en-us/internet-explorer/ie-10-worldwide-languages',
            )
        )
);

$config = parse_ini_file('config.ini');
foreach($config[browsers] as $browser => $version){
    if($browsers[$browser]){
        $browsers[$browser][minVer] = $version;
    }
    else{
        //Fill in the missing browser or throw an error?
        // throw an exception to stop a user from going live with a bad browser config
        throw new Exception("Unknown Browser: ".$browser." in config. Please add it to supported_browsers.php");
        

        /*
        $browsers[$browser] = array(
        'recommend' => false,
        'minVer'    => $version,
        'name'      => $browser,
        'fullName'  => $browser,
        'style'     => '',
        'upgrade'   => '',
        'download'  => array(
            'Windows'       => '',
            'OS X'          => '',
            'Linux'         => '',
            'iOS'           => '',
            'Android'       => '',
            )
        );
        */

    }
}

//TODO: determine which browsers get returned based on config?
return $browsers;
?>