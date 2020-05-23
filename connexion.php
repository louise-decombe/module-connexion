<?php
 
session_start();
?>



<!DOCTYPE HTML>
<html>

<head>
    <link href="moduleconnexion.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">

    <title>Connexion</title>
</head>

<body>
    <h2> Tu ne sais pas ce que tu fais ici ? <a href="index.php">Je veux retourner à l'accueil</a></h2>

    <h1>Se connecter</h1>
    <br>
    <?php
        
        if(isset($_SESSION['login'])){
            echo "<p>Tu es connecté, tu peux accéder à ton profil en <a href='profil.php'>cliquant ici</a>.</p>";
        } else {

            if(isset($_POST['envoyer'])){

                if(!isset($_POST['login'],$_POST['password'])){
                    echo "Un des champs n'est pas reconnu.";
                } else {
                    $mysqli=mysqli_connect('localhost','root','','moduleconnexion');
                    if(!$mysqli) {
						
                        echo "Erreur connexion BDD";
                    } else {
                        $login=htmlentities($_POST['login']);
                        $password=md5($_POST['password']);
                        
                        
                        $req=mysqli_query($mysqli,"SELECT * FROM utilisateurs WHERE login='$login' AND mdp='$password'");
                      
                        if($req){
                            echo "Login ou password incorrect.";
                        } else {
                            $_SESSION['login']=$login;
                            echo "<p>Tu es connecté $login! Tu peux accéder à ton profil en <a href='profil.php'>cliquant ici</a>.</p>";
                            $TraitementFini=true;
                        }
                    }
                }
            }
            if(!isset($TraitementFini)){
                ?>
    <br>
    <p>Complètes donc le formulaire ci-dessous pour te connecter:</p>
    <form method="post" action="connexion.php">
        <p> Ton login</p> <input type="text" name="login" placeholder="Ton pseudo..." required>
        <p>Ton mot de passe</p> <input type="password" name="password" placeholder="Ton mot de passe..." required>
        <br /> <input type="submit" name="envoyer" value="En avant !" class="submit">
    </form>
    <?php
            }
            
            elseif($_POST["login"] === "admin" AND $_POST["password"] === "admin" ){
        session_start();
        
        $_SESSION["connected"]=1;
        $_SESSION["login"]= $_POST["login"];
        header("location:admin.php");
    }

        }
	
        ?>
</body>

</html>

