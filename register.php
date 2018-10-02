<?php
header("Content-Type:text/html; charset=utf-8");
$name = $_POST['name'];
if($name == "")
{
	print "0";
	return;
}
$mail = $_POST['mail'];
if($mail == "")
{
	print "1";
	return;
}
$phone = $_POST['phone'];
if($phone == "")
{
	print "1";
	return;
}
$gender = $_POST['gender'];
if($gender == "")
{
	print "2";
	return;
}
$policy = $_POST['policy'];
if($policy == "")
{
	print "3";
	return;
}
$post_string="xmlData=".mb_convert_encoding("<Collection><MODE>Insert</MODE><ROW><VIPNO></VIPNO><NAME>".$name."</NAME><IDNO></IDNO><BIRTHDAY>".$_POST['year']."/".$_POST['month']."/".$_POST['day']."</BIRTHDAY><SEX>".$gender."</SEX><CLA1NO></CLA1NO><CLA3NO></CLA3NO><HTEL></HTEL><MTEL>".$phone."</MTEL><Tag1>1</Tag1><Tag2>0</Tag2><Tag3>0</Tag3><Tag4>0</Tag4><Tag5>0</Tag5><Tag6>0</Tag6><Tag7>0</Tag7><ADDR1Zip>".rand(0,5)."</ADDR1Zip><ADDR1></ADDR1><EMAIL>".$mail."</EMAIL><WEBPSW>123456789</WEBPSW><ESEND>1</ESEND><OKTIME>1</OKTIME><VIPSDATE></VIPSDATE><VIPEDATE></VIPEDATE><UD_DATE></UD_DATE><INDATE></INDATE></ROW></COLLECTION>", 'BIG5', 'UTF-8');
$weburl="http://59.124.9.25/Form/FSYS4/W2A_WS.asmx/UpdateVipInfo";
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
if($op['RESULT']!="OK")
	print "1";
else
	print "4";
?>