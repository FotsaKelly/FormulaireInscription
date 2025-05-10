<?php
session_start();
$bdd = new PDO('mysql:host=localhost; dbname=formu-connect-inscrip;','root','');
if(isset($_POST['valider'])){
    
if(!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['email']) AND !empty($_POST['password'])){
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $password = sha1($_POST['password']);
    // operation de controle
        if(strlen($_POST['password'])<7){
            $message = "Votre mot de passe est court";
        }elseif(strlen($nom)>25 || strlen($prenom)>25){
            $message = "Votre nom ou prenom est trop long";
        }else{

            // verifier que ses informations(email et password) sont dans la bd
            $testInfo = $bdd->prepare('SELECT * FROM users WHERE email=? AND password=?');
            $testInfo->execute(array($email, $password));
            if($testInfo->rowCount()==0){
                
                $inscrire = $bdd->prepare('INSERT INTO users(nom,prenom,email,password) VALUES(?,?,?,?)');
                $inscrire->execute(array($nom, $prenom, $email, $password));
                $message = "Inscription réussi";
           
                
            }else{
                $message = "Cette adresse email a déjà un compte ";
            }


       
            

        }
   
          


}else{
    $message = "Veuillez completer tous les champs";
}

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container mt-8">
        <h1 class="text-center">Inscription</h1>
        <p class="text-center">Simple et Rapide</p>
        
        <form action="" method="POST" class="border p-4 rounded">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" name="nom" class="form-control" placeholder="Nom" required style="width: 100px;">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                    </div>
                    <input type="text" name="prenom" class="form-control" placeholder="Prénom" required style="width: 100px;">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" name="email" class="form-control" placeholder="E-mail" required style="width: 100px;">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" name="password" class="form-control" placeholder="Mot de passe" required style="width: 100px;">
                </div>
            </div>
            <button type="submit" name="valider" class="btn btn-primary btn-block">S'inscrire</button>
            <div class="mt-3">
                <i style="color: red;">
                    <?php
                        if (isset($message)) {
                            echo $message."<br/>";
                        }
                    ?>
                </i>
            </div>
            <p class="mt-3" >En cliquant sur S'inscrire, vous acceptez nos <a href="#">Conditions générales</a>, notre <a href="#">Politique de confidentialité</a> et notre <a href="#">Politique d'utilisation</a> des cookies.</p>
            <div>
                <p>Avez-vous déjà un compte ? <a href="connexion.php">Connexion</a></p>
            </div>
        </form>
    </div>

    <!-- Lien vers Bootstrap JS et jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>