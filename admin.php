<?php

$bdd = new PDO('mysql:host=localhost;dbname=moduleconnexion','root', '');

$utilisateurs = $bdd->query('SELECT * FROM utilisateurs');


?>

<!DOCTYPE html>
<html>
<head>
	  <link href="moduleconnexion.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <meta charset='utf-8' />
    <title>Admin</title>
</head>
<body>
	<div class="admin">
            <h2> <img src="https://img.icons8.com/wired/64/000000/administrative-tools.png"/> Liste et informations de tout les utilisateurs du site</h2>

        <?php 
        while($user = $utilisateurs->fetch())
        {
            ?>
            <div class="tableau">

        
            <table>
                <td>
                    <tr> <?= $user['id'] ?>  </tr> 
                     <tr> <?= $user['login'] ?>  </tr> 
                      <tr> <?= $user['prenom'] ?> </tr> 
                      <tr> <?= $user['nom'] ?>  
                      </tr> <tr> <?= $user['password'] ?> 
                      </tr>
                    <?php
                    
                    }?>
                </td>
            </table>
            </div>
            
            <div class="modifadmin">
             Pour modifier tes informations d'admin<a href="profil.php?modifier">cliquez ici</a>
    
        Pour supprimer ton compte admin <a href="profil.php?supprimer">cliquez ici</a>

        Pour te déconnecter <a href="profil.php?deconnexion">cliquez ici</a>
        </div>
        <?php
        if(isset($_GET['deconnexion'])){
         
unset($_SESSION['login']);
header("Refresh: 2; url=index.php");//r
echo "Vous avez été correctement déconnecté du site.<br><br><i>Redirection vers la page d'accueil...</i>";
        }
        ?>
        </div>
</body>
</html>
