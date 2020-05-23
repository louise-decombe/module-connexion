<!DOCTYPE HTML>
<html>
    <head>
        <title>Inscription</title>
                <link href="moduleconnexion.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">

    </head>
    <body>
		        <h2> Tu viens de te rappeler que tu as déjà un compte ? <a href="index.php">Retour à l'accueil</a></h2>

		
        <h1>Inscription</h1>
        
       <?php
        if(isset($_POST['envoyer'])){
			
            if(!isset($_POST['login'],$_POST['prenom'], $_POST['nom'], $_POST['password'], $_POST['password'],  $_POST['password2']))
            {
                echo "<p>Il manque tes informations</p>";
            } 
     
                
                else 
                {
                    if(strlen($_POST['password'])<5 or strlen($_POST['password'])>20){
                        echo "Le password doit être compris entre 5 et 20 caractères";
                    } 
                     else {
                                $mysqli=mysqli_connect('localhost','root','','moduleconnexion');
                                if(!$mysqli) {
                                    echo "<p>Erreur de connexion, que se passe-t-il ?!</p>";
                                } 
                                else {
                                    $login=htmlentities($_POST['login'],ENT_QUOTES,"UTF-8");
                                    $prenom=htmlentities($_POST['prenom'],ENT_QUOTES,"UTF-8");
                                    $nom=htmlentities($_POST['nom'],ENT_QUOTES,"UTF-8");
                                    $password=md5($_POST['password']);
                                    $password2=md5($_POST['password']);

                                    if(mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM utilisateurs WHERE login='$login'"))!=0)
                                    
                                    {
                                        echo "<p>Login déjà pris ! Choisis en un autre</p>";
                                    } 
                                    
                                    else {
                                        if(mysqli_query($mysqli,"INSERT INTO `utilisateurs`( `login`, `prenom`, `nom`, `password`) VALUES ('$login','$prenom','$nom','$password')")){
                                            echo "<p>ça a marché ! Tu peux te connecter: <a href='connexion.php'>Clique ici</a>.</p>";
                                            $resultat=true;
                                        } else {
                                            echo "<p>Une erreur est survenue :(</p>";
                                        }
                                    }
                                }
                            }
                        }
                    }
                    
        if(!isset($resultat)){
            ?>
            <br>
            <h1>Remplis le formulaire ci-dessous pour t'inscrire chez nous</h1>
            <form method="post" action="inscription.php">
              <p>Login</p>  <input type="text" name="login" placeholder="Ton login..." required> <br/>
                <p>Prénom</p><input type="text" name="prenom" placeholder="Ton prénom..." required> <br/>
             <p>Nom</p>   <input type="text" name="nom" placeholder="Ton nom..." required> <br/>
               <p>Mot de passe</p> <input type="password" name="password" placeholder="Ton password..." required> </br>
                <p>Confirmation de mot de passe</p><input type="password" name="password2" placeholder="Confirme ton password..." required> </br>
                <input type="submit" name="envoyer" value="Clique ici pour t'inscrire" class="submit">
            </form>
            <?php
        }
        ?>
    </body>
</html>
