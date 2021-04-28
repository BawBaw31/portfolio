<?php
    include '../inc/connexion.php';
    if (empty($_SESSION['user'])) {
        header('Location: ./login.php');
    }
    
    // delete the artist on call
    if (isset($_GET['del'])) {        
        $id = $_GET['del'];

        try
        {
            $sql = "SELECT imgMini, img, imgBis, imgTer FROM projects WHERE id = :id";
            $params = array(
                ':id' => $id
            );
            $requete = $db->prepare($sql);
            $requete->execute($params);
            $project = $requete->fetch();
        }
        catch(PDOException $ex)
        {
            die("Erreur " . $ex->getMessage());
        }
        
        try
        {
            $sqlDelete = "DELETE FROM projects WHERE id = :id";
            $paramsDelete = array(
                ':id' => $id
            );
            $reqDelete = $db->prepare($sqlDelete);
            $reqDelete->execute($paramsDelete);
        }
        catch(PDOException $ex)
        {
            die("Erreur " . $ex->getMessage());
        }

        unlink('../images/'.$project['imgMini']);
        unlink('../images/'.$project['img']);
        unlink('../images/'.$project['imgBis']);
        unlink('../images/'.$project['imgTer']);
    } 
?>