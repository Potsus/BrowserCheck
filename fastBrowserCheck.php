<?php

function getBrowser($uAgent){ 
    $bName = '';
    $version= 0;

    
    if(strpos($uAgent, 'rv:11.0') !== false && strpos($uAgent, 'Trident/7.0') !== false){
        $bName = "MSIE"; 
        $version = 11;  
    }
    if(preg_match('/MSIE/i',$uAgent) && preg_match('/Trident/i',$uAgent))   $bName = "MSIE";
    elseif(preg_match('/Firefox/i',$uAgent))                                $bName = "Firefox";
    elseif(preg_match('/Chrome/i',$uAgent))                                 $bName = "Chrome";
    elseif(preg_match('/Safari/i',$uAgent))                                 $bName = "Safari";
    elseif(preg_match('/Opera/i',$uAgent))                                  $bName = "Opera"; 
    elseif(preg_match('/Coast/i',$uAgent))                                  $bName = "Coast"; 
    elseif(preg_match('/CriOS/i',$uAgent))                                  $bName = "CriOS";
    
    
    if($bName == 'Safari')preg_match('/Version/i',$uAgent);
    if($bName !== '' && $version === 0)$version = getVersion($uAgent, $bName);
    
    return array(
        'name'      => $bName,
        'version'   => $version,
    );
} 

function getVersion($string, $word){
    $len = strlen($word)+1;
    $offset  = strpos($string, $word)+$len;
    $i=0;
    while($i<strlen($string)-$offset){
        $char = $string[$i+$offset];
        if(!preg_match('/[0-9]/',$char))break;
        $i++;
    }
    return substr($string,$offset,$offset+$i);
}

function checkBrowser($uAgent = ''){
    if($uAgent === '') $uAgent = $_SERVER['HTTP_USER_AGENT']; 

    $specs = getBrowser($uAgent);
    //error_log($specs['name'].' ver: '.$specs['version']);
    //$shortVer = substr($specs['version'],0,strpos($specs['version'],'.'));
    $browsers = array(
        'CriOS'     => 22,
        'Chrome'    => 22,
        'Firefox'   => 8,
        'Opera'     => 12,
        'Coast'     => 1,
        'Safari'    => 5,
        'MSIE'      => 9,
    );
    
    if(array_key_exists($specs['name'], $browsers) && $browsers[$specs['name']] < intval($specs['version'])) return true;
    else return false;
}
?>
