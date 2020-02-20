<?php
if(isset($_GET['meowlat']))
{
        $lat = $_GET['meowlat'];
}
if(isset($_GET['meowlon']))
{
        $lon = $_GET['meowlon'];
}
if(isset($lon))
{
$cmd = "python /var/www/html/fi-scan.py ".$lat." ".$lon;
$output = shell_exec($cmd);
#print_r($output);
}
?>

<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

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
<body bgcolor="d6cbd3">

<button class="button" id="button">Refresh GPS</button><br/>
<p id = "status"></p>
<p class="geolink">
<a id="map-link" class="geolink" target="_blank"></a>
</p>
<script>
function geoFindMe() {

  const status = document.querySelector('#status');
  const mapLink = document.querySelector('#map-link');

  mapLink.href = '';
  mapLink.textContent = '';

  function success(position) {
    const latitude  = position.coords.latitude;
    const longitude = position.coords.longitude;

    status.textContent = '';
    mapLink.href = `/index.php?meowlat=${latitude}&meowlon=${longitude}`;
    mapLink.textContent = `${latitude}${longitude}`;
  }

  function error() {
    status.textContent = 'Unable to retrieve your location';
  }

  if (!navigator.geolocation) {
    status.textContent = 'Geolocation is not supported by your browser';
  } else {
    status.textContent = 'LocatingÃ¢â‚¬Â¦';
    navigator.geolocation.getCurrentPosition(success, error);
  }

}

document.querySelector('#button').addEventListener('click', geoFindMe);

</script>
</body>
</html>

<?php 

echo "<br><br><br>";
print_r($output);

?>
