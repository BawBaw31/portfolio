<?php
    include '../inc/connexion.php';
    if (empty($_SESSION['user'])) {
        header('Location: ./login.php');
    }

    if (isset($_POST['envoiForm'])) {
        if ($_POST['password'] == $_POST['passwordConfirmer']) {
            $passHashed = $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            try {
                $sql = "INSERT INTO accounts
                    SET userName = :userName, passWord = :passWord";
                $params = array(
                    ':userName' => $_POST['userName'],
                    ':passWord' => $passHashed
                );
                $requete = $db->prepare($sql);
                $requete->execute($params);
                
            } catch(PDOException $ex) {
                die("Erreur " . $ex->getMessage());
            }
            unset($_POST['password']);
            unset($passHashed);
            header('Location: ./index.php?');
        } else {
            header('Location: ./addAdmin.php?q=erreur');
        }
    }
    
    include 'inc/header.php'; 
    ?>

<div id="content">
    <h1>Créer un compte administrateur</h1>

    <form method="post" action="" enctype="multipart/form-data">
        <label for="userName">Nom d'utilisateur</label>
        <input type="text" name="userName" id="userName" placeholder="ex: JeanPierre">

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password">

        <label for="passwordConfirmer">Confirmer mot de passe</label>
        <input type="password" name="passwordConfirmer" id="passwordConfirmer">

        <button type="submit" name="envoiForm">Créer l'utilisateur</button>
    </form>

    <?php
        if (isset($_GET['q'])) {
            print_r('La confirmation ne correspond pas au mot de passe, veuillez recommencer.');
        }
    ?>
    
</div>

<?php
    include 'inc/footer.php';
?>