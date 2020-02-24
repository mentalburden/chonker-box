<?php
$pillagebool = FALSE;
$fitebool = FALSE;
$geotagbool = FALSE;
//$fitesel = "DE:AD:BE:EE:EE:EF";
if(isset($_GET['meowlat']))
{
	$lat = $_GET['meowlat'];
}
if(isset($_GET['meowlon']))
{
	$lon = $_GET['meowlon'];
	$geotagbool = TRUE;
}
if(isset($_GET['meowpil']))
{
	$pillagebool = TRUE;
}
if(isset($_GET['meowfite']))
{
	$fitesel = $_GET['fitesel'];
	$fitebool = TRUE;
}
if(isset($lon))
{
	$cmd = "python /var/www/html/fi-scan.py ".$lat." ".$lon;
	$fiscanoutput = shell_exec($cmd);
}
function random_string($length)
{
	$key = '';
	$keys = array_merge(range(0, 9), range('a', 'z'));
	for ($i = 0; $i < $length; $i++)
	{
		$key .= $keys[array_rand($keys)];
	}
	return $key;
}
function my_exec($cmd, $input='')
{
	$proc=proc_open($cmd, array(0=>array('pipe', 'r'), 1=>array('pipe', 'w'), 2=>array('pipe', 'w')), $pipes);
	fwrite($pipes[0], $input);fclose($pipes[0]);
	$stdout=stream_get_contents($pipes[1]);fclose($pipes[1]);
	$stderr=stream_get_contents($pipes[2]);fclose($pipes[2]);
	$rtn=proc_close($proc);
	return array('stdout'=>$stdout, 'stderr'=>$stderr, 'return'=>$rtn);
}
?>

<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3pro.css">
<style type="text/css">
.geolink {
	text-align: center;
	margin: auto;
	width: 90%;
	font-size: 24px;
	background-color: #bdcebe;
	border: 3px solid green;
	padding: 6px;
}

.button {
	display: block;
	width: 100%;
	border: none;
	background-color: #eca1a6;
	padding: 14px 28px;
	font-size: 32px;
	cursor: pointer;
	text-align: center;
}
</style>
<title>smolbear-refresh</title>
</head>

<body bgcolor='d6cbd3'>

<div class="w3-sidebar w3-bar-block w3-light-grey w3-card" style="width:130px">
<h5 class="w3-bar-item">Menu</h5>
<button class="w3-bar-item w3-button tablink" onclick="openCity(event, 'London')">Geotag APs</button>
<button class="w3-bar-item w3-button tablink" onclick="openCity(event, 'Paris')">Wifite Individual</button>
<button class="w3-bar-item w3-button tablink" onclick="openCity(event, 'Tokyo')">Wifite Pillage</button>
</div>


<!-- SUBMENUS START HERE -->
<div style="margin-left:130px">
<div class="w3-padding">

<!-- ------------------- -->

<div id="London" class="w3-container city" style="display:none">
<h2>Geotag local APs</h2>
<!-- GeoTagAP STARTS HERE -->
<button class="button" id="button">Refresh GPS</button><br/>
<p id = "status"></p>
<p class="geolink">
<a id="map-link" class="geolink" target="_blank"></a>
</p>
<script>
function geoFindMe()
{
	const status = document.querySelector('#status');
	const mapLink = document.querySelector('#map-link');
	mapLink.href = '';
	mapLink.textContent = '';

	function success(position)
	{
		const latitude  = position.coords.latitude;
		const longitude = position.coords.longitude;

		status.textContent = '';
		mapLink.href = `/index.php?meowlat=${latitude}&meowlon=${longitude}`;
		mapLink.textContent = `${latitude}${longitude}`;
	}

	function error()
	{
		status.textContent = 'Unable to retrieve your location';
	}

	if (!navigator.geolocation)
	{
		status.textContent = 'Geolocation is not supported by your browser';
	}
	else
	{
		status.textContent = 'Locating   ^`   ';
		navigator.geolocation.getCurrentPosition(success, error);
	}

}
document.querySelector('#button').addEventListener('click', geoFindMe);
</script>

<BR><BR><BR>

<?php
$fp = file_get_contents("lastjsontemp.json");
$jsonchonklet = json_decode($fp);
$namesjson = $jsonchonklet->data->essids;
$macsjson = $jsonchonklet->data->macaddresses;
$secsjson = $jsonchonklet->data->sectypes;
$chansjson = $jsonchonklet->data->channels;
for($i = 0, $j = count($macsjson); $i < $j ; $i++)
{
echo '';
echo $namesjson[$i]->name;
echo '<br>';
echo $secsjson[$i]->sectype;
echo '<br>';
echo $chansjson[$i]->channel;
echo '<br>';
echo $macsjson[$i]->mac;
echo '<br><BR><BR>';
}

echo 'done --';
?>

<!-- AP LIST ENDS HERE -->
</div>


<!-- ------------------- -->


<div id="Paris" class="w3-container city" style="display:none">
<h2>Wifite Individual</h2>
<!-- wifite individual run STARTS HERE -->
<h1>DONT REFRESH IF THE SCRIPT IS RUNNING!!!</h1>
<a href="/index.php?meowfite=<?php echo random_string(50); ?>&fitesel=AA:BB:CC:DD:EE:FF">meow</a>
<h1>NOT WORKING RIGHT NOW, FINISH THIS TOMORROW </h1>
<?php
if($fitebool)
{
	$thiscmd = '/bin/bash /var/www/html/wifite-individual.sh '.$fitesel;
        var_export(my_exec($thiscmd,$fitesel));
}
for($i = 0, $j = count($macsjson); $i < $j ; $i++)
{
echo '';
echo $namesjson[$i]->name;
echo '<br>';
echo $secsjson[$i]->sectype;
echo '<br>';
echo $chansjson[$i]->channel;
echo '<br>';
echo $macsjson[$i]->mac;
echo '<br>';
echo '<a href=index.php?meowfite='.random_string(50).'&fitesel='.$macsjson[$i]->mac.'>Wifite This Target</a>';
echo '<br><BR><BR>';
}

echo 'done --';
?>
?>
<!-- wifite individual ENDS HERE -->
</div>



<!-- ------------------- -->



<div id="Tokyo" class="w3-container city" style="display:none">
<h2>Wifite Pillage</h2>
<h1>DONT REFRESH IF THE SCRIPT IS RUNNING!!!</h1>
<!-- wifite pillage STARTS HERE -->
<a href="/index.php?meowpil=<?php echo random_string(50); ?>">meow</a>
<?php
if($pillagebool)
{

	//var_export(my_exec('sudo wifite --clients-only --pmkid-timeout 13 -i wlan1mon --pmkid --skip-crack --pow 50 -p 13', ''));
	var_export(my_exec('/bin/bash /var/www/html/wifite-pillage.sh', ''));
}
?>

</div>

<!-- FINAL DIV ---------------------------------------->
</div>

<!-- ------------------- -->

<script>
function openCity(evt, cityName)
{
	var i, x, tablinks;
	x = document.getElementsByClassName("city");
	for (i = 0; i < x.length; i++) 
	{
		x[i].style.display = "none";
	}
	tablinks = document.getElementsByClassName("tablink");
	for (i = 0; i < x.length; i++) 
	{
		tablinks[i].className = tablinks[i].className.replace(" w3-red", "");
	}
	document.getElementById(cityName).style.display = "block";
	evt.currentTarget.className += " w3-red";
}
</script>
</body>
</html>

<!-- ------------------- -->

<!-- handle tool selection after script start here -->
<?php
if($pillagebool)
{
echo "<script type=\"text/javascript\">openCity(event, 'Tokyo');</script>";
;
}
else
{
echo "<!-- nope -->";
}
?>

<!-- ------------------- -->

<?php
if($fitebool)
{
echo "<script type=\"text/javascript\">openCity(event, 'Paris');</script>";
}
else
{
echo "<!-- nope -->";
}
?>


<!-- ------------------- -->

<?php
if($geotagbool)
{
echo "<script type=\"text/javascript\">openCity(event, 'London');</script>";
}
else
{
echo "<!-- nope -->";
}
?>
