<?php 
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=test', 'admin', '');
?>


<!DOCTYPE html> 
<html> 
<head>
  <div style="text-align: center;">
  </div>
  </div>
  <title>Verifizieren</title>    
  <h6><font color="#FFFFFF">Verification-System v1.0 by </font><a href="https://youtube.com/c/TimeCodeMC">TimeCode</a></h6>
  <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="icon" type="image/png" href="C:\xampp\htdocs\Favicon.ico"/>
        <body background="hintergrund.png">
</head> 
<body>
 
 
<?php
$showFormular = true;
 
if(isset($_GET['register'])) {
    $error = false;
    $email = $_POST['email'];
    $mcname = $_POST['mcname'];
  
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<font color="#FF0000"><span style="font-weight:bold;"><center>Bitte gib eine Email-Adresse an!</center><br></span></font>';
        $error = true;
    }     
    if(strlen($mcname) == 0) {
        echo '<font color="#FF0000"><span style="font-weight:bold;"><center>Bitte gib einen Minecraft-Namen an!</center><br></span></font>';
        $error = true;
    }
    
    if(!$error) { 
        $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $result = $statement->execute(array('email' => $email));
        $user = $statement->fetch();
        
        if($user !== false) {
            echo '<font color="#FF0000"><span style="font-weight:bold;"><center>Du hast einen Account mit dieser Email schon einmal verifiziert!</center><br></span></font>';
            $error = true;
        }    
    }
    
    if(!$error) {          
        $statement = $pdo->prepare("INSERT INTO users (email, mcname) VALUES (:email, :mcname)");
        $result = $statement->execute(array('email' => $email, 'mcname' => $mcname));
        
        if($result) {        
            echo '<font color="#FFFFFF"><span style="font-weight:bold;"><center>Du wurdest erfolgreich verifiziert. In wenigen Minuten solltest du auch auf dem MC-Server verifiziert sein! Viel Spaß! <a href="verify.php">Nochmal verifizieren</a></center></span></font>';
            $showFormular = false;
        } else {
            echo '<font color="#FF0000"><span style="font-weight:bold;"><center>Error 404<br></center></span></font>';
        }
    } 
}
 
if($showFormular) {
?>
 
<form action="?register=1" method="post">
<center></center><br>
<center></center><br>
<center></center><br>
<center></center><br>
<center></center><br>
<center></center><br>
<font color="#00FFFF"><center><h1><b>Verifizieren</center></h1></b></font>
<center></center><br>
<center></center><br>
<center></center><br>
<center></center><br>
<center></center><br>
<center></center><br>




<font color="#FFFFFF"><center>Dein Minecraft-Name:<br></center></font>
<center><input type="name" size="40" maxlength="250" name="mcname"><br><br></center>
 
<font color="#FFFFFF"><center>Deine Kontakt-Email:<br></center></font>
<center><input type="email" size="40"  maxlength="250" name="email"></center><br>
<font color="#D8D8D8"><h6><center>(Die Email ist dafür da, dass wir dich kontaktieren können!)<br></center></h6></font>
 
<center><input type="submit" value="Verifizieren"></center>
</form>
 
<?php
} //Ende von if($showFormular)
?>
 
</body>
</html>