<?php
    include '../inc/connexion.php';
    if (empty($_SESSION['user'])) {
        header('Location: ./login.php');
    }

    // update db data
    if (isset($_POST['envoiForm'])) {
        $cv = $_FILES['cv'];
        $photo = $_FILES['photo'];

        # Changing cv
        if ($cv['error'] != UPLOAD_ERR_NO_FILE){
            if ($cv['size'] > 104857600) {
                $wrongSize = 'Erreur : les fichiers ne peuvent dépasser 100mo !';
            }
            if ($cv['type'] != 'application/pdf') {
                $wrongType = 'Erreur : les extensions acceptées sont : pdf';
            }
            if ($cv['error']) {
                $otherError = $error;
            }
            
            if(isset($wrongSize)) {
                print_r($Wrongsize);
            } else if(isset($wrongType)){
                print_r($wrongType);
            } else if(isset($otherError)) {
                print_r($wotherError);
            } else {
                if (move_uploaded_file($cv['tmp_name'], '../documents/' . basename($cv['name']))) {
                    print "Uploaded successfully!";
                } else {
                    print "Upload failed!";
                }
                unlink('../documents/'.$_POST['preCV']);
                try {
                    $reqUpdate = "UPDATE infos
                    SET cv = :cv
                    WHERE id = 1";
                $paramsUpdate = array(
                    ':cv'            => $_FILES['cv']['name']
                );
                $sqlUpdate = $db->prepare($reqUpdate);
                $sqlUpdate->execute($paramsUpdate);
                } catch(PDOException $ex) {
                    die("Erreur " . $ex->getMessage());
                }
            }
        }

        # Changing photo
        if ($photo['error'] != UPLOAD_ERR_NO_FILE){
            if ($photo['size'] > 104857600) {
                $wrongSize = 'Erreur : les fichiers ne peuvent dépasser 100mo !';
            }
            if ($photo['type'] != 'image/jpg' && $photo['type'] != 'image/png') {
                $wrongType = 'Erreur : les extensions acceptées sont : pdf';
            }
            if ($photo['error']) {
                $otherError = $error;
            }

            if(isset($wrongSize)) {
                print_r($Wrongsize);
            } else if(isset($wrongType)){
                print_r($wrongType);
            } else if(isset($otherError)) {
                print_r($wotherError);
            } else {
                if (move_uploaded_file($photo['tmp_name'], '../images/' . basename($photo['name']))) {
                    print "Uploaded successfully!";
                } else {
                    print "Upload failed!";
                }
                unlink('../images/'.$_POST['prePhoto']);
                try {
                    $reqUpdate = "UPDATE infos
                    SET photo = :photo
                    WHERE id = 1";
                $paramsUpdate = array(
                    ':photo'            => $_FILES['photo']['name']
                );
                $sqlUpdate = $db->prepare($reqUpdate);
                $sqlUpdate->execute($paramsUpdate);
                } catch(PDOException $ex) {
                    die("Erreur " . $ex->getMessage());
                }
            }
        }

        try {
        $reqUpdate = "UPDATE infos
            SET phone = :phone, mail = :mail, linkedIn = :linkedIn, presentation = :presentation
            WHERE id = 1";
        $paramsUpdate = array(
            ':phone'               => $_POST['phone'],
            ':mail'             => $_POST['mail'],
            ':linkedIn'             => $_POST['linkedIn'],
            ':presentation'    => $_POST['presentation']
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
    $sql = "SELECT phone, mail, linkedIn, cv, photo, presentation
        FROM infos 
        WHERE id = 1";
    $requete = $db->prepare($sql);
    $requete->execute();
    $infos = $requete->fetch();
    }
    catch(PDOException $ex)
    {
    die("Erreur " . $ex->getMessage());
    }

    include('inc/header.php');
?>

<div id="content">
    <h1>Modifier mes informations</h1>
    <form method="post" action="" enctype="multipart/form-data">
        <label for="phone">Numéro de téléphone</label>
        <input type="text" name="phone" id="phone" value="<?php echo $infos['phone']; ?>">

        <label for="mail">Adresse email</label>
        <input type="text" name="mail" id="mail" value="<?php echo $infos['mail']; ?>">

        <label for="linkedIn">Lien LinkedIn</label>
        <input type="text" name="linkedIn" id="linkedIn" value="<?php echo $infos['linkedIn']; ?>">

        <label for="cv">C.V.</label><br>
        <label for="cv"><a href="../documents/<?php echo $infos['cv']; ?>" download="cvActuel.pdf">Voir C.V. actuel</a></label>
        <input type="file" name="cv" id="cv">

        <label for="presentation">Description courte</label>
        <textarea name="presentation" id="presentation" cols="30" rows="10"
        ><?php echo $infos['presentation']; ?>
        </textarea>

        <label for="photo">Photo</label>
        <input type="file" name="photo" id="photo">
        <img src="../images/<?php echo $infos['photo']; ?>" alt="Photo actuelle">
        
        <input type="hidden" name="preCv" value="<?php echo $infos['cv']; ?>">
        <input type="hidden" name="prePhoto" value="<?php echo $infos['photo']; ?>">

        <button type="submit" name="envoiForm">Modifier</button>
    </form>
</div>

<?php
        include('inc/footer.php');
?>