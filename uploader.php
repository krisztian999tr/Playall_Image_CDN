<?php
//check IP
?>
<!DOCTYPE html>
<html>
<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<title>Playall képfeltöltő rendszer/title>
</head>
<body>
<h1> Playall képfeltöltő rendszer</h1>
</div>

<hr /><center>
<?php
if(isset($_POST['submit'])) { //ha megnyomtuk a feltöltés gombot
$target= "uploads/"; //A feltöltött kép az uploads mappába kerül
$file_name = $_FILES['file']['name']; // A fájl átnevezése titkosítás miatt
$tmp_dir = $_FILES['file']['tmp_name']; //az ideiglenes mappa helyét a $tmp_dir változóban tároljuk
 
if(!preg_match('/(gif|jpe?g|png)$/i', $file_name)) //ha a fájlnak ($file_name-nek) a kiterjesztése nem képfájl akkor a hibaüzenet megjelenik
{
echo "Rossz fajltipus!"; 
}
else
{
move_uploaded_file($tmp_dir, $target . $file_name); //az ideiglenes mappából átteszi a fájlt a végleges mappába (a $target . $file_name összeilleszti a két stringet, így uploads/fajlnev-et kapunk)
$feltoltve = true; //a feltoltve változó true értéket kap
}
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Playall képfeltöltő rendszer</title>
</head>
<body>
<form enctype="multipart/form-data" action="" method="post" />
<input type="hidden" name="MAX_FILE_SIZE" value="300000000" /> <!--a feltöltött file maximális mérete 3Gb-->
<img src="http://www.img.v1.server.playall.hu/ks2q1e/uploadfile_hz8BqhaIU3DQpKREYgucy.png"/>
<br>
<hr />
<label for="file"> Válassz egy fájlt!</label><input id="file" type="file" name="file" />
<input type="submit" name="submit" value="Feltöltés!" />
 <hr />
</body>
</html>
<?php
if($feltoltve) {
$utvonal = $target . $file_name;
//Random generál egy kódsorozatot 0-tól 5-ig. Ez fele a titkosításért
$randomString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);
$randomString2 = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 20);
//Generál egy mappát a megadott $randomString értéken
$structure = './'.$randomString;
if (!mkdir($structure, 0777, true)) {
    die('Sikertelen, valami hiba történt...');
}

//Az generált mappán belül generál egy index.html-t, ahová beilleszti az adott képet.
$what_is_my_ip =  "IP cim:" .  $_SERVER['REMOTE_ADDR']. "      ";
$what_is_my_date = "Feltoltes datuma: " . date("Y/m/d") ;
$renamefile = ("./".$randomString."/index.html");
$myfile = fopen($renamefile, "w");
$showPic = ('./'.$randomString.'/uploadfile_'.$randomString2.'.png'); //Átnevezi a képet és konvertál png típusra
//#################################################################
$file = $renamefile;
$current = file_get_contents($file);
//Beilleszti a képet az url-be
$current = '<html><head><title>PLAYALL</title><link rel="shortcut icon" href="http://docs.v1.server.playall.hu//UkoI93o/icon_btm.ico"></head><body><center><h1>ERROR - 403</h1><p></p><h4>You can not access on this server</h4>';
//Az adatokat biztonsági okokból elmenti
$content = $what_is_my_ip . $what_is_my_date ;
$fp = fopen("./".$randomString."/data.txt","wb");
fwrite($fp,$content);
fclose($fp);
// Felfedjük a képet
file_put_contents($file, $current);
echo '<p></p>';
rename($utvonal, $showPic);
echo '<img src="'.$showPic.'" height="400" width="500" />';
echo '<p></p>';
echo ('<h4>A képhez vezető link: <a href="http://www.img.v1.server.playall.hu/'.$randomString.'/uploadfile_'.$randomString2.'.png"">http://www.img.v1.server.playall.hu/'.$randomString.'/uploadfile_'.$randomString2.'.png<a/></h4>');
}
// És ennyi lenne ...
?>