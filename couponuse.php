<?php
header("Content-Type:text/html; charset=utf-8");
$post_string="xmlData=".mb_convert_encoding("<COLLECTION><ROW><InputData>".$_POST['logphone']."</InputData><PwCode>123456789</PwCode></ROW></COLLECTION>", 'BIG5', 'UTF-8');
$weburl="http://59.124.9.25/Form/FSYS4/W2A_WS.asmx/GetVipInfo";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $weburl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS,$post_string);
curl_setopt($ch, CURLOPT_HEADER, false);
$output = curl_exec($ch);
curl_close($ch);
$op=htmlspecialchars_decode($output,ENT_QUOTES);
$op = simplexml_load_string($op);
$op =(array)$op;
$op =(array)$op['COLLECTION'];
if($op['RESULT']!="OK")
	return 0;
$op =(array)$op['ROW'];
$post_string="xmlData=".mb_convert_encoding("<Collection><MODE>Update</MODE><ROW><VIPNO>".$op['VIPNO']."</VIPNO><NAME>".$op['NAME']."</NAME><IDNO></IDNO><BIRTHDAY>".$op['BIRTHDAY']."</BIRTHDAY><SEX>".$op['SEX']."</SEX><CLA1NO></CLA1NO><CLA3NO></CLA3NO><HTEL></HTEL><MTEL>".$op['MTEL']."</MTEL><Tag1>1</Tag1><Tag2>0</Tag2><Tag3>0</Tag3><Tag4>0</Tag4><Tag5>0</Tag5><Tag6>0</Tag6><Tag7>0</Tag7><ADDR1Zip></ADDR1Zip><ADDR1></ADDR1><EMAIL>".$op['EMAIL']."</EMAIL><WEBPSW>123456789</WEBPSW><ESEND>1</ESEND><OKTIME>1</OKTIME><VIPSDATE></VIPSDATE><VIPEDATE></VIPEDATE><UD_DATE></UD_DATE><INDATE></INDATE></ROW></COLLECTION>", 'BIG5', 'UTF-8');
$weburl="http://59.124.9.25/Form/FSYS4/W2A_WS.asmx/UpdateVipInfo";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $weburl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS,$post_string);
curl_setopt($ch, CURLOPT_HEADER, false);
$output = curl_exec($ch);
curl_close($ch);
print 1;
?>