<?php
    include '../inc/connexion.php';
    if (empty($_SESSION['user'])) {
        header('Location: ./login.php');
    }

    
    // access to db data
    if (isset($_GET['id'])) {
        
        $id = $_GET['id'];
        
        // update db data
        if (isset($_POST['envoiForm'])) {
            foreach($_FILES as $key => $img){
                if ($img['error'] != UPLOAD_ERR_NO_FILE){
                    if ($img['size'] > 104857600) {
                        $wrongSize = 'Erreur : les fichiers ne peuvent dépasser 100mo !';
                    }
                    if ($img['type'] != 'image/jpg' && $img['type'] != 'image/png') {
                        $wrongType = 'Erreur : les extensions acceptées sont jpg et png !';
                    }
                    if ($img['error']) {
                        $otherError = $error;
                    }
    
                    if(isset($wrongSize)) {
                        print_r($Wrongsize);
                    } else if(isset($wrongType)){
                        print_r($wrongType);
                    } else if(isset($otherError)) {
                        print_r($wotherError);
                    } else {
                        if (move_uploaded_file($img['tmp_name'], '../images/' . basename($img['name']))) {
                            print "Uploaded successfully!";
                        } else {
                            print "Upload failed!";
                        }
                        unlink('../images/'.$_POST['pre'.ucfirst($key)]);
                        if ($key == 'imgMini') {
                            try {
                            $reqUpdate = "UPDATE projects
                                SET imgMini = :imgMini
                                WHERE id = :id";
                            $paramsUpdate = array(
                                ':id'                   => $id,
                                ':imgMini'            => $_FILES['imgMini']['name']
                            );
                            $sqlUpdate = $db->prepare($reqUpdate);
                            $sqlUpdate->execute($paramsUpdate);
                            } catch(PDOException $ex) {
                                die("Erreur " . $ex->getMessage());
                            }
                        } else if ($key == 'img') {
                            try {
                            $reqUpdate = "UPDATE projects
                                SET img = :img
                                WHERE id = :id";
                            $paramsUpdate = array(
                                ':id'                   => $id,
                                ':img'            => $_FILES['img']['name']
                            );
                            $sqlUpdate = $db->prepare($reqUpdate);
                            $sqlUpdate->execute($paramsUpdate);
                            } catch(PDOException $ex) {
                                die("Erreur " . $ex->getMessage());
                            }
                        } else if ($key == 'imgBis') {
                            try {
                            $reqUpdate = "UPDATE projects
                                SET imgBis = :imgBis
                                WHERE id = :id";
                            $paramsUpdate = array(
                                ':id'                   => $id,
                                ':imgBis'            => $_FILES['imgBis']['name']
                            );
                            $sqlUpdate = $db->prepare($reqUpdate);
                            $sqlUpdate->execute($paramsUpdate);
                            } catch(PDOException $ex) {
                                die("Erreur " . $ex->getMessage());
                            }
                        } else if ($key == 'imgTer') {
                            try {
                            $reqUpdate = "UPDATE projects
                                SET imgTer = :imgTer
                                WHERE id = :id";
                            $paramsUpdate = array(
                                ':id'                   => $id,
                                ':imgTer'            => $_FILES['imgTer']['name']
                            );
                            $sqlUpdate = $db->prepare($reqUpdate);
                            $sqlUpdate->execute($paramsUpdate);
                            } catch(PDOException $ex) {
                                die("Erreur " . $ex->getMessage());
                            }
                        }
                    }
                }
            }
            try {
            $reqUpdate = "UPDATE projects
                SET name = :name, gitLink = :gitLink, date = :date, shortDescript = :shortDescript, descript = :descript, 
                descriptBis = :descriptBis, descriptTer = :descriptTer
                WHERE id = :id";
            $paramsUpdate = array(
                ':id'               => $id,
                ':name'             => $_POST['name'],
                ':gitLink'          => $_POST['gitLink'],
                ':date'             => $_POST['date'],
                ':shortDescript'    => $_POST['shortDescript'],
                ':descript'         => $_POST['descript'],
                ':descriptBis'      => $_POST['descriptBis'],
                ':descriptTer'      => $_POST['descriptTer']
            );
            $sqlUpdate = $db->prepare($reqUpdate);
            $sqlUpdate->execute($paramsUpdate);
            } catch(PDOException $ex) {
                die("Erreur " . $ex->getMessage());
            }
            header ('Location: ./projectList.php');
        }

        try
        {
        $sql = "SELECT name, gitLink, date, shortDescript, descript, descriptBis, descriptTer, imgMini, img, imgBis, imgTer 
            FROM projects 
            WHERE id = :id";
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

        include('inc/header.php');
?>

<div id="content">
    <h1>Modifier <?php echo $project['name']; ?></h1>
    <form method="post" action="" enctype="multipart/form-data">
        <label for="name">Nom</label>
        <input type="text" name="name" id="name" value="<?php echo $project['name']; ?>">

        <label for="gitLink">Lien GitHub</label>
        <input type="text" name="gitLink" id="gitLink" value="<?php echo $project['gitLink']; ?>">

        <label for="date">Date</label>
        <input type="text" name="date" id="date" value="<?php echo $project['date']; ?>">

        <label for="shortDescript">Description courte</label>
        <textarea name="shortDescript" id="shortDescript" cols="30" rows="10"
        ><?php echo $project['shortDescript']; ?>
        </textarea><br>

        <label for="descript">Description</label>
        <textarea name="descript" id="descript" cols="30" rows="10"
        ><?php echo $project['descript']; ?>
        </textarea><br>

        <label for="descriptBis">Description 2</label>
        <textarea name="descriptBis" id="descriptBis" cols="30" rows="10"
        ><?php echo $project['descriptBis']; ?>
        </textarea><br>

        <label for="descriptTer">Description 3</label>
        <textarea name="descriptTer" id="descriptTer" cols="30" rows="10"
        ><?php echo $project['descriptTer']; ?>
        </textarea><br>

        <label for="imgMini">Image Mini</label>
        <input type="file" name="imgMini" id="imgMini">
        <img src="../images/<?php echo $project['imgMini']; ?>" alt="<?php echo $project['imgMini']; ?>">

        <label for="img">Image</label>
        <input type="file" name="img" id="img">
        <img src="../images/<?php echo $project['img']; ?>" alt="<?php echo $project['img']; ?>">

        <label for="imgBis">Image 2</label>
        <input type="file" name="imgBis" id="imgBis">
        <img src="../images/<?php echo $project['imgBis']; ?>" alt="<?php echo $project['imgBis']; ?>">

        <label for="imgTer">Image 3</label>
        <input type="file" name="imgTer" id="imgTer">
        <img src="../images/<?php echo $project['imgTer']; ?>" alt="<?php echo $project['imgTer']; ?>">
        
        <input type="hidden" name="preImgMini" value="<?php echo $artiste['imgMini']; ?>">
        <input type="hidden" name="preImg" value="<?php echo $artiste['img']; ?>">
        <input type="hidden" name="preImgBis" value="<?php echo $artiste['imgBis']; ?>">
        <input type="hidden" name="preImgTer" value="<?php echo $artiste['imgTer']; ?>">

        <button type="submit" name="envoiForm">Modifier</button>
    </form>
</div>

<?php
        include('inc/footer.php');
    } else {
        header("Location: ./projectList.php");
        die();
    }
?>