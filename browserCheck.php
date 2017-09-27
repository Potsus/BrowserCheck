<?php

class browser {
    private $picFolder = 'https://d11ms3y3p0fbtv.cloudfront.net/pictures/browser/';
    private $supportedBrowsers = array(
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
    
    //core strings
    public  $agentString                = '';
    public  $mozLegacy                  = '';
    public  $systemVars                 = array();
    public  $os                         = '';
    public  $osVer                      = '';
    public  $layoutEngine               = '';
    public  $layoutEngineDescription    = '';
    public  $layoutEngineVersion        = '';
    private $userBrowsers               = array();
    
    //display info
    public  $name           = 'Unknown Browser';
    public  $version        = 'Unknown Version';
    public  $buildVer       = '';
    public  $firmwareVer    = '';
    public  $mobile         = false;
    public  $device         = '';
    public  $supported      = false;
    public  $supportText    = '';
    public  $suggestionText = '';


    
    
    
    //gets all the browser info from the user agent
    public function __construct($agent = ''){
        if($agent === ''){
            $this->agentString = $_SERVER['HTTP_USER_AGENT'];
            error_log($this->agentString);
        }
        else $this->agentString = $agent;
        
        $this->getInfo();
    }
    
    private function getInfo(){
        
        $len = strlen($this->agentString);
        $i = 0;

        //check for legacy sites compatability
        if(substr($this->agentString,0,8) == 'Mozilla/'){
            $i+=8;
            $ver = $this->nextSpace(substr($this->agentString,$i));
            $this->mozLegacy = substr($this->agentString,$i,$ver);
            $i += $ver+1;
        }
        else $this->mozLegacy = false;

        //get the system stuff
        if($this->agentString{$i} == '('){
            $p = $this->matchParen(substr($this->agentString,$i));
            $this->systemVars = explode('; ',substr($this->agentString,$i+1,$p-2));
            $i += $p;
            if($i < $len && $this->agentString{$i} == ' '){
                $i++;
                $p = $this->nextSpace(substr($this->agentString,$i));
                $layEngStr = $this->verSplit(substr($this->agentString,$i,$p));
                $this->layoutEngine = $layEngStr['name'];
                $this->layoutEngineVersion = $layEngStr['version'];
                $i += $p;

                if($i < $len && $this->agentString{$i} == ' '){
                    $i++;

                    if($i < $len && $this->agentString{$i} == '('){
                        $p = $this->matchParen(substr($this->agentString,$i));
                        $this->layoutEngineDescription = substr($this->agentString,$i+1,$p-2);
                        $i += $p;
                    }
                    if($i < $len && $this->agentString{$i} == ' ')$i++;

                    while($i < strlen($this->agentString) && count($this->userBrowsers)<20){
                        $p = $this->nextSpace(substr($this->agentString,$i));
                        array_push($this->userBrowsers, $this->verSplit(substr($this->agentString,$i,$p)));
                        $i += $p+1;
                    }

                }
            }
        }
        
        
        //clean up and ready the info for display
        
        if($this->layoutEngine != ''){
            if($this->layoutEngine == 'AppleWebKit')$this->layoutEngine = 'WebKit'; //remove the 'apple' from apple web kit
        }
        else $this->layoutEngine = 'Unspecified';
        
        //run through the browsers and collect more useful info
        $j=0;
        while($j<count($this->userBrowsers)){
            switch($this->userBrowsers[$j]['name']){
                case 'Version':
                    $this->version      = $this->userBrowsers[$j]['version'];
                    break;
                case 'Mobile':
                    $this->firmwareVer  = $this->userBrowsers[$j]['version'];
                    $this->mobile       = true;
                    break;
                default:
                    if($this->version == 'Unknown Version')$this->version = $this->userBrowsers[$j]['version'];
                    elseif($this->buildVer == '')$this->buildVer = $this->userBrowsers[$j]['version'];
                    if($this->name == 'Unknown Browser')$this->name = $this->userBrowsers[$j]['name'];
                    break;
            }
            $j++;
        }
        
        //get info about the system the browser is on
        foreach($this->systemVars as $sys){
            //error_log('sys vars:');
            //error_log($sys);    
            if(preg_match('/Linux/',$sys)){
                $this->os = 'Linux';
            }
            if(preg_match('/Android/',$sys)){
                preg_match('/Android (.*)/',$sys,$os);
                $this->os = 'Android';
                $this->osVer = str_replace('_','.',$os[1]);
                
                //device naming on android is still somewhat unregulated so this is just some basic guesswork
                $device = end($this->systemVars);
                if(strpos($device, 'Build') !== false){
                    $cut = strpos($device, 'Build');
                    $this->device = substr($device,0,$cut-1);
                }
            }
            if(preg_match('/Windows NT /',$sys)){
                $this->os = 'Windows';
                preg_match('/Windows NT (.*)/',$sys,$ver);
                switch($ver[1]){
                    case '6.3':
                        if (strpos($this->agentString, 'rv:11.0') !== false && strpos($this->agentString, 'Trident/7.0') !== false) {
                            $this->name = 'MSIE';
                            $this->version = '11.0';
                            $this->layoutEngine = "Trident";
                            $this->supported = true;
                            $this->supportText = "Your browser version and FastFig are fully compatible!   There is nothing to worry about.   Go do some math! <a href='..'>Go Back</a>";
                        }
                        $this->osVer = '8.1';
                        break;
                    case '6.2':
                        $this->osVer = '8';
                        break;
                    case '6.1':
                        $this->osVer = '7';
                        break;
                    case '6.0':
                        $this->osVer = 'Vista';
                        break;
                    case '5.2':
                        $this->osVer = 'XP';
                        break;
                    case '5.1':
                        $this->osVer = 'XP';
                        break;
                    case '5.0':
                        $this->osVer = '2000';
                        break;
                }

            }
            if(preg_match('/Windows Phone/',$sys)){
                $this->os = 'Windows Phone';
                $this->mobile = true;
                preg_match('/Windows Phone (.*)/',$sys,$os);
                if(substr($os[1],0,3) == 'OS ') $this->osVer = substr($os[1],3);
                else $this->osVer = $os[1];
            }
            if(preg_match('/Macintosh/',$sys)){
                $this->os = 'Macintosh';
            }
            if(preg_match('/OS X /',$sys)){
                $this->os = 'OS X';
                preg_match('/OS X (.*)/',$sys,$os);
                $this->osVer = str_replace('_','.',$os[1]);
            }
            if(preg_match('/iPhone/',$sys)){
                $this->os = 'iOS'; 
                $this->device = 'iPhone'; 
            }
            if(preg_match('/iPhone OS /',$sys)){
                $this->os = 'iOS';
                preg_match('/iPhone OS (.*)/',$sys,$os);
                $os = str_replace('_','.',$os[1]);
                $cut = $this->nextSpace($os);
                $this->osVer = substr($os,0,$cut);
            }
            if(preg_match('/iPad/',$sys)){
                $this->os = 'iOS';
                $this->device = 'iPad';
            }
            if(preg_match('/CPU OS /',$sys)){
                $this->os = 'iOS ';
                preg_match('/CPU OS (.*)/',$sys,$os);
                $os = str_replace('_','.',$os[1]);
                $cut = $this->nextSpace($os);
                $this->osVer = substr($os,0,$cut);
            }
            if(substr($sys,0,4) == 'MSIE'){
                $this->name    = 'MSIE';
                $this->version = substr($sys, 5);
            }
            if(preg_match('/Trident/',$sys)){
                $this->layoutEngine = 'Trident';
                preg_match('/Trident\/(.*)/',$sys,$os);
                $this->layoutEngineVersion = $os[1];
            }
        }
    }
    
    private function matchParen($string){
        if($string{0} != '(')return 0;
        $j = 1;
        $parenMatch = 1;
        while($parenMatch != 0 && $j < strlen($string)){
            if($string{$j} == '(')$parenMatch++;
            elseif($string{$j} == ')')$parenMatch--;
            $j++;
        }
        return $j;
    }

    private function nextSpace($string){
        $j = 1;
        while($j < strlen($string) && $string{$j} != ' ')$j++;
        return $j;
    }

    private function verSplit($string){
        if(strpos($string, '/') !== false){
            $obj = explode('/',$string);
            return array(
                'name'     => $obj[0],
                'version'  => $obj[1],
            );
        }
        else return array(
                'name'     => $string,
                'version'  => '',
            );
    }

    private function checkURL($url){
        $file_headers = @get_headers($url);
        //error_log($file_headers[0]);
        if($file_headers[0] == 'HTTP/1.1 403 Forbidden') return false;
        else return true;
    }
    
    public function isSupported(){
        if(!$this->supported && $this->supportText == ''){
            if(array_key_exists($this->name, $this->supportedBrowsers)){
                if(strpos($this->version, '.') !== false){
                    $shortVer = explode('.', $this->version);
                    $shortVer = $shortVer[0];
                }
                else $shortVer = $this->version;
                if($this->supportedBrowsers[$this->name]['minVer'] <= intval($shortVer)){
                    $this->supported   = true;
                    $this->supportText = "Your browser version and FastFig are fully compatible!   There is nothing to worry about.   Go do some math! <a href='..'>Go Back</a>";
                }
                else {
                    $this->supportText    = 'Fastfig does not support <b>this version</b> of '.$this->supportedBrowsers[$this->name]['fullName'].'.<br>';
                    $this->suggestionText = $this->supportedBrowsers[$this->name]['upgrade'].'<br><br> Or you can try upgrading to one of these fine browsers:';
                    
                }
            }
            else {
                $this->supportText    = 'Fastfig does not support '.$this->name.' so we cannot say how well the site will work in this browser.';
                $this->suggestionText = 'We suggest upgrading to one of these fine browsers:';
            }
        }
        return $this->supported;
    }
    
    public function drawBrowser(){
        $pad = '  ';
        if(array_key_exists($this->name, $this->supportedBrowsers)){
            $name = $this->supportedBrowsers[$this->name]['name'];
            $fullName = $this->supportedBrowsers[$this->name]['fullName'];
        }
        else {
            $name = strtolower ($this->name);
            $fullName = $this->name;
        }
        
        echo '<table class="logoBox '.$name.'Box">
    <tr>
        <td>
            <img src="'; if($this->checkURL($this->picFolder.$name.'Logo.png'))echo $this->picFolder.$name.'Logo.png'; else echo $this->picFolder.'noLogo.png';echo '" class="browserLogo">
        </td>
        <td class="right">
            <div class="browserText">
                <div class="browserName">'.$fullName; if($this->mobile) echo ' Mobile'; echo '</div>
                <div>
                    <b>Version:</b> '.$this->version.$pad; if($this->buildVer != '')echo ' <b>Build:</b> '.$this->buildVer; echo '
                    <br>
                    '; if($this->mobile && $this->device != '')echo '<b>Device:</b> '.$this->device.$pad;echo '<b>Operating System:</b> '.$this->os.' '.$this->osVer.$pad; if($this->firmwareVer != '')echo ' <b>Firmware:</b> '.$this->firmwareVer; echo '
                    <br>
                    <b>Layout Engine:</b> '.$this->layoutEngine.$pad.'<b>Build:</b> '.$this->layoutEngineVersion.$pad;if($this->layoutEngineDescription != '')echo' <b>Description:</b> '.$this->layoutEngineDescription; echo'
                </div>
            </div>
        </td>
    </tr>
</table>';
    }
    
    public function drawDownloads(){
        foreach($this->supportedBrowsers as $prefs){
            if($prefs['recommend']){
                if($this->os !== '' && array_key_exists($this->os, $prefs['download'])){
                    echo 
'<div class="download '.$prefs['name'].'Box">
    <a href="'.$prefs['download'][$this->os].'">
        <img src="'.$this->picFolder.$prefs['name'].'Logo.png"></img>
        <span>'.$prefs['fullName'].'</span>
    </a>
</div>';   
                }
            }   
        }
    }
    
    public function drawPage(){
        echo $this->drawBrowser();
        echo '<br>';
        if($this->isSupported()) echo $this->supportText;
        else{
            echo $this->supportText.'<br>'.$this->suggestionText.'<br>';
            echo $this->drawDownloads();
        }
    }

    public function quickDraw(){
        echo $this->drawBrowser();
        echo '<br>';
        if($this->isSupported()) echo $this->supportText;
        else{
            echo $this->supportText.'<br>';
        }
    }
}
?>