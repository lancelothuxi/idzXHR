<?
/* simple json proxy wrapper for idzXHR plugin
** by Gueron Jonathan (http://www.iadvize.com)
** licensed under the MIT license
*/

if (!isset($_GET['data']) || $_GET['data'] == '' || !isset($_GET['callback'])) {
	exit(1);
}

// define our bosh url here:
$BOSH_URL = 'http://www.iadvize.com:5280/http-bind';

$body = stripslashes($_GET['data']);


$ch = curl_init($BOSH_URL);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$header = array('Accept-Encoding: gzip, deflate','Content-Type: text/xml; charset=utf-8');
curl_setopt($ch, CURLOPT_HTTPHEADER, $header );
curl_setopt($ch, CURLOPT_VERBOSE, 0);
curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 60 );
curl_setopt( $ch, CURLOPT_TIMEOUT, 60 );
		
$output = '';
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
// TODO: check for curl error and return error to strophe
if ($output == '') { 
	print $_GET['callback'] . '({"reply":"<body type=\'terminate\' xmlns=\'http:\/\/jabber.org\/protocol\/httpbind\'\/>"});';
} else if ($output == false) { 
	print $_GET['callback'] . '({"reply":' . json_encode('<parsererror/>') . '});';
} else { 
	print $_GET['callback'] . '({"reply":' . json_encode($output) . '});';
}

curl_close($ch);
?>
