<?php
/*********Diese Datei**********/
//Diese Datei zigt das Profil an

//PHP Session starten
session_start();
//Ist man eingellogt
if(!isset($_SESSION['userid']))
{
            //Weiterleitung
            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            header("Location: http://$host$uri/index.php");
            exit;
}
?>
<html>
<head>
    <link href="style.css" rel="Stylesheet" type="text/css" media="screen"></link>
</head>
<body>
    <div id="root">
        <div id="logo"></div>
        <div id="sub-navi"><form action="serach.php" method="get"><input type="search" value="Suche" name="s" style="right:10px; float:left; width:162px;" onfocus="if(this.value == 'Suche') this.value = ''" onBlur="if(this.value == '') this.value = 'Suche'">	  	<?php echo $friendship_request; ?><a href="home.php">Home</a><a>  </a><a href="logout.php">Logout </a></form></div>
        <div id="content" style="background-image:none;">
            <div id="main-content" style="width:990px;">
            <form action="p-bild.php" method="post" enctype="multipart/form-data">
<input type="file" name="datei">
<input type="submit" value="Hochladen" style="padding-left:20px;">
</form>
            </form>
			<?php
$dateityp = GetImageSize($_FILES['datei']['tmp_name']);
if($dateityp[2] != 0)
   {

      move_uploaded_file($_File['datei']['tmp_name'], $_File['datei'][ "bilder/".$_SESSION['userid'].".".$_File['datei']['type']]);
     
    }

else
    {
    echo "Bitte nur Bilder im Gif bzw. jpg Format hochladen";
    }
?>
        </div>
    </div>
</body>    
</html>