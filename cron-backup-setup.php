<?php
###############################################################
# Cron Backup Script
###############################################################
# Developed by Jereme Hancock for Cloud Sites
###############################################################

// grab the latest version of zipit from github
shell_exec('wget https://github.com/jeremehancock/cron-backup-script/archive/master.zip --no-check-certificate -O cron-backup.zip; unzip cron-backup.zip; rm cron-backup-script-master/README.md; mv cron-backup-script-master/* ../../; rm -r cron-backup-script-master; rm cron-backup.zip');

// determine datacenter for storage
    $string = $_SERVER["PHP_DOCUMENT_ROOT"];

    $pos = strpos($string, "dfw");
    if ($pos == false) {
        $datacenter = "ORD";
    } else {
        $datacenter = "DFW";
    }

// define url -- will check for test link and remove extra characters if installing from test link
    $server = $_SERVER['SERVER_NAME'];

    if (strpos($server,'websitetestlink') !== false) {
        $split = explode(".php",$server,2);
        $url = $split[0];
    } else {
        $url = $_SERVER['SERVER_NAME'];
    }

// define backup path
    $path = getcwd();

if (isset($_POST["Submit"])) {

$string = '<?php 
###############################################################
# Cron Backup Script
###############################################################
# Developed by Jereme Hancock for Cloud Sites
###############################################################

//Set information specific to your site
$db_host = "'. $_POST["db_host"]. '";
$db_user = "'. $_POST["db_user"]. '";
$db_password = "'. $_POST["db_password"]. '";
$db_name = "'. $_POST["db_name"]. '";
$url = "'. $_POST["url"]. '";
$path = "'. $_POST["path"]. '";
$datacenter = "'. $_POST["datacenter"]. '";

//Set your Cloud Files API credentials
$username = "'. $_POST["username"]. '";
$key = "'. $_POST["key"]. '"; 

?>';

$fp = fopen("../../cron-backup-config.php", "w");

fwrite($fp, $string);

fclose($fp);

// remove zipit install file
shell_exec("rm ./cron-backup-setup.php");

   echo '<script type="text/javascript">';
   echo 'alert("Cron Backup Script installed successfully.\n\nYou can now setup a cronjob in your Cloud Sites Control panel for cron-backup.php running as PHP.")';
   echo '</script>'; 

echo "<script>location.href='../'</script>";

}
?>

<html>
<head>
  <title>Cron Backup Setup Script</title>
  <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
  <META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">

  <style>
body {
height:100%;
background: #ddd;
margin-bottom: 1px;
font-family: Arial;
}

    input { 

            border: 1px solid #818185; 
            -moz-border-radius: 15px;
            border-radius: 15px;
            height:30px;
            width:200px;
            padding-left:8px;
            padding-right:8px;
}
            
.wrapper{

        width:350px;
	position:absolute;
	left:50%;
	top:30%;
	margin:-225px 0 0 -195px;
        background-color:#eee;
        -moz-border-radius: 15px;
        border-radius: 15px;
        padding:20px;
       -moz-box-shadow: 5px 5px 7px #888;
       -webkit-box-shadow: 5px 5px 7px #888;
}

a {
color:#55688A;
}

h2 {
color:#55688A;
}


.head {
text-align:center;
font-family: Arial;
font-size:28px;
margin-bottom:10px;
}

  </style>

<script language="javascript" type="text/javascript">
function removeSpaces(string) {
 return string.split(' ').join('');
}
</script>

<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>
<body>

<div class="wrapper">
<div class="head">Cron Backup Setup</div>
  <div style="text-align:center">
<br />
<form action="" method="post" name="install" id="install">
<em>Enter your database credentials</em>
<p>
     Database Username:<br />
    <input name="db_user" type="text" id="db_user" value="" onblur="this.value=removeSpaces(this.value);"> 
</p>

<p>
    Database Name:<br />
    <input name="db_name" type="text" id="db_name" onblur="this.value=removeSpaces(this.value);"> 
</p>

<p>
    Database Password:<br />
    <input name="db_password" type="password" id="db_password" onblur="this.value=removeSpaces(this.value);"> 
</p>

<p>
    Database Host:<br />
    <input name="db_host" type="text" id="db_host" onblur="this.value=removeSpaces(this.value);"> 
</p>
<br />
<em>Enter your Cloud Files username/API Key</em>
<p>
    Cloud Files Username:<br />
    <input name="username" type="text" id="username" onblur="this.value=removeSpaces(this.value);" required="required">
</p>

<p>
    Cloud Files API Key:<br />
    <input name="key" type="text" id="key" onblur="this.value=removeSpaces(this.value);" required="required">
</p>

<p>
    <input name="datacenter" type="hidden" id="datacenter" value="<?php echo $datacenter ?>" onblur="this.value=removeSpaces(this.value);" required="required">
</p>

<p>
    <input name="url" type="hidden" id="url" value="<?php echo $url ?>" onblur="this.value=removeSpaces(this.value);" required="required">
</p>

<p>
    <input name="path" type="hidden" id="path" value="<?php echo $path ?>" onblur="this.value=removeSpaces(this.value);" required="required">
</p>

<p>
<font color="red"><em>By using the Cron Backup Setup script you are agreeing to the terms of the GPL License! See: <a href="http://www.gnu.org/licenses/gpl-3.0.en.html" target="_blank">GPL v3</a></em></font><br /><br />
    <input type="submit" name="Submit" value="Install" style="background-color:#ccc; -moz-border-radius: 15px; border-radius: 15px; text-align:center; width:250px; color:#000; padding:3px;">
</p>

</form>

</div></div>
</body>
</html>
