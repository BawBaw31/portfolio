<?php
    include '../inc/connexion.php';

    if (isset($_GET['q'])) {
        if ($_GET['q'] == 'deco') {
            session_destroy();
            header('Location: ./login.php');
            die();
        }
    }

    if (isset($_POST['envoiForm'])) {
        try {
            $sql = "SELECT passWord, userName FROM accounts WHERE userName = :userName";
            $params = array(
                ':userName' => $_POST['userName']
            );
            $requete = $db->prepare($sql);
            $requete->execute($params);
            $user = $requete->fetch();
            
        } catch(PDOException $ex) {
            die("Erreur " . $ex->getMessage());
        }

        if (password_verify($_POST['password'], $user['passWord'])) {
            $_SESSION['user'] = $user;
            header('Location: ./index.php');
            die();
        }

        header('Location: ./login.php?q=erreur');
    }
    
    include 'inc/header.php'; 
    ?>

<div id="content">
    <h1>Se connecter</h1>

    <form method="post" action="" enctype="multipart/form-data">
        <label for="userName">Nom d'utilisateur</label>
        <input type="text" name="userName" id="userName" placeholder="ex: JeanPierre">

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password">

        <button type="submit" name="envoiForm">Connexion</button>
    </form>

    <?php
        if (isset($_GET['q'])) {
            if (isset($_GET['q']) == 'erreur') {
                print_r('Le mot de passe ou le nom d\'utilisateur est/sont incorrect(s)');
            }
        }
    ?>

</div>

<?php
    include 'inc/footer.php';
?>