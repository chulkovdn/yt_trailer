<?php

$yt_id = $_GET['query'];

function check_mobile_device() { 
    $mobile_agent_array = array('ipad', 'iphone', 'android', 'pocket', 'palm', 'windows ce', 'windowsce', 'cellphone', 'opera mobi', 'ipod', 'small', 'sharp', 'sonyericsson', 'symbian', 'opera mini', 'nokia', 'htc_', 'samsung', 'motorola', 'smartphone', 'blackberry', 'playstation portable', 'tablet browser');
    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);    
    foreach ($mobile_agent_array as $value) {    
        if (strpos($agent, $value) !== false) return true;   
    }       
    return false; 
}

if ($_GET['title'] != '') {
    header('Content-Type: text/plain; charset=utf-8');

    $context = stream_context_create(array(
        'http' => array(
        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:84.0) Gecko/20100101 Firefox/84.0',
    )));
    $html = file_get_contents("https://www.youtube.com/results?search_query=".urlencode($_GET['title']." трейлер"), False, $context);
    $tmp1 = stristr($html, 'videoId');
    $tmp2 = stristr($tmp1, '","', true);
    $res = str_replace('videoId":"', '', $tmp2);
    $newURL = 'yt_trailer.php?query='.$res;
    header('Location: '.$newURL);
}

if ($yt_id != '') {
	$is_mobile_device = check_mobile_device();
	if($is_mobile_device){
		$style = "body { margin: 0; padding: 0; overflow: hidden; }";	
	} else {
		$style = "body { background-image: url(background.jpg); background-repeat: no-repeat; background-position: center center; background-attachment: fixed; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; overflow: hidden; } .shadow { -webkit-box-shadow: 0px 0px 15px 10px rgba(253, 255, 133, 0.6); -moz-box-shadow: 0px 0px 15px 10px rgba(253, 255, 133, 0.6); box-shadow: 0px 0px 10px 5px rgba(253, 255, 133, 0.6); }";
}
	
echo "<!DOCTYPE html>
<html>
<head>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<meta charset='utf-8'>
<style>
body { cursor: default; }
img { cursor: hand; }
p { line-height: 100%; font-family:tahoma; font-size: 12px; color: silver; }
$style
</style>
</head>
<body bgcolor=black>
<center>
<br>
<br><b><p>Трейлер к фильму</b><p>&nbsp;</p>
<iframe class=shadow src='https://www.youtube.com/embed/$yt_id' frameborder='0' allowfullscreen style='width: 800px; height: 400px; border: 0px; position: relative; margin: auto; max-width: 100%; max-height: 100%;'></iframe>
<p>&nbsp;</p>
<p><b>:: <u>Disclaimer</u> ::</b><br>данный сайт не содержит запрещенных материалов<br>вся информация предоставлена в ознакомительных целях<br>и берется исключительно из открытых источников</p>
</body>
</html>";
} else {
    print 'no parameter' ;
}

?>
