<?php
header("Content-Type:text/html; charset=utf-8");
$logmail = $_POST['logmail'];
$logphone = $_POST['logphone'];
if($logmail == "" && $logphone == "")
{
	print "0";
	return;
}
$post_string="xmlData=".mb_convert_encoding("<COLLECTION><ROW><InputData>".$logphone."</InputData><PwCode>123456789</PwCode></ROW></COLLECTION>", 'BIG5', 'UTF-8');
$weburl="http://59.124.9.25/Form/FSYS4/W2A_WS.asmx/GetVipInfo";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $weburl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS,$post_string);
curl_setopt($ch, CURLOPT_HEADER, false);
$output = curl_exec($ch);
curl_close($ch);
$op=htmlspecialchars_decode($output,ENT_QUOTES);
$root = simplexml_load_string($op);
$root =(array)$root;
$op=(array)$root['COLLECTION'];


$post_string2="xmlData=".mb_convert_encoding("<COLLECTION><ROW><InputData>".$logmail."</InputData><PwCode>123456789</PwCode></ROW></COLLECTION>", 'BIG5', 'UTF-8');
$weburl="http://59.124.9.25/Form/FSYS4/W2A_WS.asmx/GetVipInfo";
$ch2 = curl_init();
curl_setopt($ch2, CURLOPT_URL, $weburl);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_POSTFIELDS,$post_string2);
curl_setopt($ch2, CURLOPT_HEADER, false);
$output2 = curl_exec($ch2);
curl_close($ch2);
$op2=htmlspecialchars_decode($output2,ENT_QUOTES);
$root2 = simplexml_load_string($op2);
$root2 =(array)$root2;
$op2=(array)$root2['COLLECTION'];


if($op['RESULT']!="OK" && $op2['RESULT']!="OK")
	print "0";
else
{
	setcookie("logmail", $logmail, time()+100);
	setcookie("logphone", $logphone, time()+100);
	print "1";
}	
?>