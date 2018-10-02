<?php
header("Content-Type:text/html; charset=utf-8");
error_reporting(0);
$post_string="xmlData=".mb_convert_encoding("<COLLECTION><ROW><InputData>".$_COOKIE["logphone"]."</InputData><PwCode>123456789</PwCode></ROW></COLLECTION>", 'BIG5', 'UTF-8');
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
{
	$post_string="xmlData=".mb_convert_encoding("<COLLECTION><ROW><InputData>".$_COOKIE["logmail"]."</InputData><PwCode>123456789</PwCode></ROW></COLLECTION>", 'BIG5', 'UTF-8');
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
	{
		header("Location: index.html"); 
		return;
	}
}
$op =(array)$op['ROW'];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<title>1010 Apothecary</title>
<link rel="icon" href="ico.jpg">
<link rel="stylesheet" href="all.css">
<script defer src="https://use.fontawesome.com/releases/v5.1.1/js/all.js" integrity="sha384-BtvRZcyfv4r0x/phJt9Y9HhnN5ur1Z+kZbKVgzVBAlQZX4jvAuImlIz+bG7TS00a" crossorigin="anonymous"></script>
<script>
function couponuse()
{
	var oXHR=new XMLHttpRequest(); 
	var logemail = "<?php echo $op['EMAIL'] ?>";
	var logphone = "<?php echo $op['MTEL'] ?>";
	
	para="logemail="+logemail+"&logphone="+logphone;
	oXHR.open("POST","couponuse.php",true);
	oXHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	oXHR.onreadystatechange=function()
	{
		if(oXHR.readyState==4&&(oXHR.status==200||oXHR.status==304))
		{
			if(oXHR.responseText==1)
			{
				document.getElementById("btnuse").style.backgroundColor = "gray";
				document.getElementById("btnuse").style.borderColor = "gray";
				document.getElementById("btnuse").innerHTML = "已兌換";
			}
		}
	}
	oXHR.send(para);
}
function official_website()
{
	window.location.assign("https://www.1010apothecary.com.tw/");
}
</script>
</head>
<body>
	<div class="container">
		<img src="original.jpg" width="150">
		<form id="register">
			<div class="row">
				<h4 style="font-size: 25px;">哈囉！<?php echo $op['NAME'] ?></h4>
			</div>
			<?php
				if($op['ADDR1Zip']=="")
					echo "<h4 style=\"color: red;text-align: center;\">目前尚無優惠券可使用</h4>";
				else
				{
					$itemnum=0;
					$handle = @fopen("item", "r");
					if($handle) 
					{
						while (($buffer = fgets($handle, 4096)) !== false) 
						{
							if($itemnum==$op['ADDR1Zip']*2)
							{
								$a=$buffer;
								$b=fgets($handle, 4096);
							}
							++$itemnum;
						}
						fclose($handle);
					}
					echo "
			<div class=\"row\">
				<h4>".$a."</h4>
				<img src=\"".$b."\" width=\"100%\">
			</div>
			<br>
			<div class=\"row\">
				<input type=\"radio\" checked=\"true\"/>
				<label style=\"width: 100%\" onClick=\"couponuse()\" id=\"btnuse\">立即兌換</label>
			</div>
			<br>
			<div class=\"row\">
				<input type=\"radio\" checked=\"true\"/>
				<label style=\"width: 100%\" onClick=\"official_website()\">回到官網</label>
			</div>";
				}
			?>
		</form>
	</div>
</body>
</html>