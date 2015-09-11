<meta charset="UTF-8">
<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
$url = "https://instagram.com/accounts/login/";
$login = "deadmerc";
$pass = "Ugudud66";
if(empty($_GET['t'])){
    die('Пустое сообщение');
}
$page = file_get_contents($url);

//print_r($page);

$content = preg_match('/"viewer":null,"csrf_token":"(.*?)"}}/i', $page, $found);
//print_r($found);
$page = file_get_contents($url);
$key = $found[1];
//print_r($key);
// get status ok
$urlE = 'https://instagram.com/ajax/bz';
$ch = curl_init();

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

curl_setopt($ch, CURLOPT_URL, $urlE);
//curl_setopt($ch, CURLOPT_REFERER, $urlE);
//curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"q":[{"page_id":"vbhvhu","posts":[["slipstream:pageview",{"event_name":"pageview","url":"https://instagram.com/accounts/login/ajax/?targetOrigin=https%3A%2F%2Finstagram.com","hostname":"instagram.com","path":"/accounts/login/ajax/","user_time":1422695776298,"description":"Ajax Login","referer":"https://instagram.com/accounts/login/"},1422695776298,0]],"trigger":"slipstream:pageview"}],"ts":1422695776798}');
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (Windows; U; Windows NT 5.0; En; rv:1.8.0.2) Gecko/20070306 Firefox/1.0.0.4");
//curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Requested-With: XMLHttpRequest", "Content-Type: application/json; charset=utf-8"));
$header = array(
    'Accept:*/*',
    'Accept-Encoding:gzip, deflate',
    'Accept-Language:ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
    'Connection:keep-alive',
    'Content-Type:application/x-www-form-urlencoded; charset=UTF-8',
    'Host:instagram.com',
    'Origin:https://instagram.com',
    'Referer:https://instagram.com/accounts/login/ajax/?targetOrigin=https%3A%2F%2Finstagram.com',
    'Mozilla/4.0 (Windows; U; Windows NT 5.0; En; rv:1.8.0.2) Gecko/20070306 Firefox/1.0.0.4',
    'X-Requested-With:XMLHttpRequest',
    'X-Instagram-AJAX:1',
    'Pragma:no-cache',
    'Cookie:csrftoken=' . $key . ';mid=VMylEAAEAAFEvcSnCYLRFh_ZAKxx; ccode=RU;'
);
//curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, 'coo.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, 'coo.txt');
$result = curl_exec($ch);
echo $result;
curl_close($ch);


//AUTH /////////////////////////////////////////////
$urlAuth = 'https://instagram.com/accounts/login/ajax/';
$ch = curl_init();

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

curl_setopt($ch, CURLOPT_URL, $urlAuth);
curl_setopt($ch, CURLOPT_REFERER, 'https://instagram.com');
//curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "username=" . $login . "&password=" . $pass . '&intent=');
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (Windows; U; Windows NT 5.0; En; rv:1.8.0.2) Gecko/20070306 Firefox/1.0.0.4");
//curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Requested-With: XMLHttpRequest", "Content-Type: application/json; charset=utf-8"));
$header = array(
    'Host: instagram.com',
    'User-Agent: Mozilla/5.0 (Windows NT 6.2; WOW64; rv:36.0) Gecko/20100101 Firefox/36.0',
    'Accept: */*',
    'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
    'Accept-Encoding: gzip, deflate',
    'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
    'X-Instagram-AJAX: 1',
    'X-CSRFToken: ' . $key . '',
    'X-Requested-With: XMLHttpRequest',
    'Referer: https://instagram.com/accounts/login/ajax/?targetOrigin=https%3A%2F%2Finstagram.com',
    'Content-Length: 41',
    'Cookie: csrftoken=' . $key . '; mid=VMy1QAAEAAH24nY5G2SFdshdB6Rb; ccode=RU',
    'Connection: keep-alive',
    'Pragma: no-cache',
    'Cache-Control: no-cache'
);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);


curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, 'coo.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, 'coo.txt');
$result = curl_exec($ch);
//echo $result;
curl_close($ch);
// add COMMENT


$urlDocoment = 'http://instagram.com/web/comments/351413639717370901/add/';

$ch = curl_init();

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

curl_setopt($ch, CURLOPT_URL, $urlDocoment);
curl_setopt($ch, CURLOPT_REFERER, 'https://instagram.com');
//curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'comment_text='.$_GET['t'].'');
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (Windows; U; Windows NT 5.0; En; rv:1.8.0.2) Gecko/20070306 Firefox/1.0.0.4");
//curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Requested-With: XMLHttpRequest", "Content-Type: application/json; charset=utf-8"));
$header = array(
    
'Host: instagram.com',
'User-Agent: Mozilla/5.0 (Windows NT 6.2; WOW64; rv:36.0) Gecko/20100101 Firefox/36.0',
'Accept: */*',
'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
'Accept-Encoding: gzip, deflate',
'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
'X-Instagram-AJAX: 1',
'X-CSRFToken: '.$key.'',
'X-Requested-With: XMLHttpRequest',
'Referer: http://instagram.com/p/TgeNfslLwV/?modal=true',
//'Content-Length: 21',
'Cookie: csrftoken='.$key.'; mid=VMy1QAAEAAH24nY5G2SFdshdB6Rb; sessionid=IGSC5d45338ae6ae6dbc0dd3139d7b688d48295b56a1c2982c347dcdcdbce920c883%3ACYuCgEf9VLIfrKr3FMxYTvfV7HwsDnxP%3A%7B%22_auth_user_id%22%3A223491326%2C%22_token%22%3A%22223491326%3A3XiOjT3FcklhuPlcHVQd1GUuEjMAq5HX%3A60552bb692d5ec5f16f2c3d0c4ef09137dc893fb32e29b8373fab32688df12c0%22%2C%22_auth_user_backend%22%3A%22accounts.backends.CaseInsensitiveModelBackend%22%2C%22last_refreshed%22%3A1422702368.764295%2C%22_tl%22%3A1%2C%22_platform%22%3A4%7D; ds_user_id=223491326; ccode=RU; __utma=1.1959928071.1422699132.1422699132.1422699132.1; __utmb=1.2.10.1422699132; __utmc=1; __utmz=1.1422699132.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); __utmt=1; fbm_124024574287414=base_domain=.instagram.com; fbsr_124024574287414=TzIfOIm8HeonjYOWt2bRAaTwZO2MWf8BkkvWkJJpoqg.eyJhbGdvcml0aG0iOiJITUFDLVNIQTI1NiIsImNvZGUiOiJBUUFxcE9ZMzZCbVVNbzRKOWc0czBPZVB1ZDZiWV9DMWYzSDZhN0c4aGhHNlp2N0x4bGFSeU56TEJMa19aMGFtQjZxMlVRc24yS3U0UklfcnFSNm01UFYzRDgxNThQNXZrbUs4OTNRb1VVbmlFbDN2eWRsVE90VXZRT3g5c2pCMVBpNlMyN0ZpNnVTOWxOWmctNkI0bGxGTGlQN3ZGbkJ3RGVJcWdvNUhMT1BadnY3aXNzREZNTWdTSXpZTktidkdQbUw0cXZ0dXEzNkxmZGNxb0VsbFBSaTFXczdBWl9XN2Vfcmg0elpzcW0zMXJ2VE9LMnE1ZUNGVFBZTXhmNzhERHhoQmtGb0JEVWFjdEt0R0tFWVJvVDRnQ2FQaU5fWTFiUWtxNXRwSFh0SjdPOWJjWFhPbE1Uc3BiZ0YxcEgzMDVWRjVvV0pHSjRzSWFOaHRDN1Y5QzRnSSIsImlzc3VlZF9hdCI6MTQyMjcwMzE1OCwidXNlcl9pZCI6IjEwMDAwNDMxODcyNDE4NSJ9',
'Connection: keep-alive',
'Pragma: no-cache',
'Cache-Control: no-cache'


);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);


curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, 'coo.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, 'coo.txt');
$result = curl_exec($ch);
//$ans = json_encode($result);
//$ans = iconv("utf-8","windows-1251//IGNORE", $result);
//echo $ans;
curl_close($ch);

$time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
echo '<p>Debug info:'.round($time, 5).'</p>';



