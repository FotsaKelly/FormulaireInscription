<?php 
session_start();
$bdd = new PDO('mysql:host=localhost; dbname=formu-connect-inscrip; ','root','');

// isset pour tester l'existence d'une variable
if(isset($_POST['envoi'])){
    
    // verrifier que les camps ne sont pas vide
    if(!empty($_POST['email']) AND !empty($_POST['password'])){
        $email = htmlspecialchars($_POST['email']);
        $password = sha1($_POST['password']);
       
        $requete = $bdd->prepare('SELECT * FROM users WHERE email=? AND password=?');
        $requete->execute(array($email, $password));
        $cpt= $requete->rowCount();
        if($cpt==1){
            $_SESSION['email'] = $email; // Stocke l'email dans la session
            $message = "Connexion réussie";
        }else{
            $message = "Aucun compte trouvé";
        }

    }else{
        $message = "Veuillez remplir tous les champs";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Connexion</h1>
        <p class="text-center">Se connecter à WWW</p>
        
        <form action="" method="POST" class="border p-4 rounded">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" name="email" class="form-control" placeholder="Adresse e-mail" required style="width: 300px;">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" name="password" class="form-control" placeholder="Mot de passe" required style="width: 300px;">
                </div>
            </div>
            <button type="submit" name="envoi" class="btn btn-primary btn-block">Se connecter</button>
            <div class="mt-3">
                <i style="color: red;">
                    <?php
                    if (isset($message)) {
                        echo $message."<br/>";
                    }
                    ?>
                </i>
            </div>
            <p class="mt-3" >Vous n'avez pas de compte ? <a href="inscription.php">Inscription</a></p>
        </form>
    </div>

    <!-- Lien vers Bootstrap JS et jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>