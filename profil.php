<?php

session_start();
if(!isset($_SESSION['login'])){
    header("Refresh: 3; url=connexion.php");
    echo "<p>Tu dois te connecter pour accéder à ton profil.</p><br><p>Redirection en cours, retour à la page d'accueil...</p>";
    exit(0);
}
$login=$_SESSION['login'];
$mysqli=mysqli_connect('localhost','root','','moduleconnexion');
if(!$mysqli) {
    echo "Erreur connexion";
    exit(0);
}


$req=mysqli_query($mysqli,"SELECT * FROM utilisateurs WHERE login='$login'");
$info=mysqli_fetch_assoc($req);
?>


<!DOCTYPE HTML>
<html>
    <head>
		<link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
                <link href="moduleconnexion.css" rel="stylesheet">

        <title>Profil</title>
    </head>
    <body>
        <h1>Profil</h1>
      <p>  Pour modifier tes informations <a href="profil.php?modifier">cliquez ici</a></p>
        <br>
      <p>  Pour supprimer ton compte <a href="profil.php?supprimer">cliquez ici</a></p>
        <br>
      <p>  Pour te déconnecter <a href="profil.php?deconnexion">cliquez ici</a> </p>
       
        <?php
        if(isset($_GET['deconnexion'])){
         
unset($_SESSION['login']);
header("Refresh: 3; url=index.php");

echo "<p>Tu es correctement déconnecté du site.</p><br><p>Redirection vers la page d'accueil...</p>";
        }
        
   
        
          if(isset($_GET['supprimer'])){
            if($_GET['supprimer']!="ok"){
                echo "<p>Tu es sûr de vouloir supprimer ce compte définitivement?</p>
                <br>
                <h2></p><a href='profil.php?supprimer=ok' style='color:red'>OUI</a> <a href='profil.php' style='color:green'>NON</a></h2>";
            } else {
                if(mysqli_query($mysqli,"DELETE FROM utilisateurs WHERE pseudo='$login'")){
                    echo "Ton compte vient d'être supprimé pour toujours.";
                    unset($_SESSION['login']);
                } else {
                    echo "Il y a une erreur quelque part ...";
                }
            }
        }
        
        
        
        if(isset($_GET['modifier'])){
            ?>
            <h1>Modification du profil</h1>
            <p>
       
                <a href="profil.php?modifier=password">Modifier ton mot de passe</a>
                <a href="profil.php?modifier=login">Modifier ton login</a>
                <a href="profil.php?modifier=prenom">Modifier ton prenom</a>
                <a href="profil.php?modifier=nom">Modifier ton nom</a>

            </p>
            
            
            <?php
            if($_GET['modifier']=="login"){
      
                if(isset($_POST['valider'])){
			
               if(mysqli_query($mysqli,"UPDATE utilisateurs SET login='".htmlentities($_POST['login'],ENT_QUOTES,"UTF-8")."' WHERE login='$login'")){
                                echo "<h2Login {$_POST['login']} modifié avec succès!<h2>";
                                $resultat=true;
                            } else {
                                echo "Il y a une erreur, mince !";
                            }
                        }
                    
                
                if(!isset($resultat)){
                    ?>
                    <br>
                    <form method="post" action="profil.php?modifier=login">
                     <p>Login</p>   <input type="text" name="login" value="<?php echo $info['login']; ?>" required>
                        <input type="submit" name="valider" value="Valider la modification" class="submit">
                    </form>
                    <?php
                }
			}
			
			
                
            elseif($_GET['modifier']=="prenom"){
                if(isset($_POST['valider'])){
                    if(!isset($_POST['prenom'])){
                        echo "Le champ prenom n'est pas reconnu.";
                    } else {
                        if($_POST['prenom']){
                           
                            if(mysqli_query($mysqli,"UPDATE utilisateurs SET prenom='".htmlentities($_POST['prenom'])."' WHERE login='$login'")){
                                echo "<h1>Login {$_POST['prenom']} modifiée avec succès!</h1>";
                                $resultat=true;
                            } else {
                                echo "Il y a une erreur, mince !";
                            }
                        }
                    }
                }
                if(!isset($resultat)){
                    ?>
                    <br>
                    <form method="post" action="profil.php?modifier=prenom">
                     <p>Prénom</p>   <input type="text" name="prenom" value="<?php echo $info['prenom']; ?>" required>
                        <input type="submit" name="valider" value="Valider la modification" class="submit">
                    </form>
                    <?php
                }
			}
            
            elseif($_GET['modifier']=="nom"){
                if(isset($_POST['valider'])){
                    if(!isset($_POST['nom'])){
                        echo "Le champ nom n'est pas reconnu.";
                    } else {
                        if($_POST['nom']){
                            
                            echo "Le nom semble incorrecte.";
                            
                        } else {
                            if(mysqli_query($mysqli,"UPDATE utilisateurs SET nom='".htmlentities($_POST['nom'],ENT_QUOTES,"UTF-8")."' WHERE login='$login'")){
                                echo "{$_POST['prenom']} modifiée avec succès!";
                                $resultat=true;
                            } else {
                                echo "Il y a une erreur, mince !";
                            }
                        }
                    }
                }
                if(!isset($resultat)){
                    ?>
                    <br>
                    <form method="post" action="profil.php?modifier=nom">
                    <p>Nom</p>    <input type="text" name="nom" value="<?php echo $info['nom']; ?>" required>
                        <input type="submit" name="valider" value="Valider la modification" class="submit">
                    </form>
                    <?php
                }
			}
           
            elseif($_GET['modifier']=="password"){
                echo "<p>Remplis les champs </p>";
                if(isset($_POST['valider'])){
                    if(!isset($_POST['nouveaupassword'],$_POST['confirmerpassword'],$_POST['password'])){
                        echo "Un des champs n'est pas reconnu.";
                    } else {
                        if($_POST['nouveaupassword']!=$_POST['confirmerpassword']){
                            echo "Les mots de passe ne correspondent pas.";
                        } else {
                            $password=md5($_POST['password']);
                            $newpassword=md5($_POST['nouveaupassword']);
                            $req=mysqli_query($mysqli,"SELECT * FROM utilisateurs WHERE login='$login' AND password='$password'");
                            
                                if(mysqli_query($mysqli,"UPDATE utilisateurs SET password='$newpassword' WHERE login='$login'")){
                                    echo "<h1>Mot de passe modifié avec succès!	</h1>";
                                    $resultat=true;
                                } else {
                                    echo "Une erreur est survenue, on essaye de corriger ça!";
                                }
                            
                        }
                    }
                }
                if(!isset($resultat)){
                    ?>
                    <br>
                    <form method="post" action="profil.php?modifier=password">
                     <p>Ici ton nouveau mot de passe</p>   <input type="password" name="nouveaupassword" placeholder="Nouveau mot de passe..." required>
                      <p>Répète le encore une fois STP</p>  <input type="password" name="confirmerpassword" placeholder="Confirmer nouveau passe..." required>
                     <p>Tu te souviens du mot de passe actuel ?</p>   <input type="password" name="password" placeholder="Ton mot de passe actuel..." required>
                      <br/>  <input type="submit" name="valider" value="Valider la modification" class="submit">
                    </form>
                    <?php
                }
            }
        
	}
        ?>
    </body>
</html>
