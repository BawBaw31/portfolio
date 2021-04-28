<!-- Insert into db -->
<?php
    include '../inc/connexion.php';
    if (empty($_SESSION['user'])) {
        header('Location: ./login.php');
    }

    if (isset($_POST['envoiForm'])) {
        $imgSizes = [];
        $imgTypes = [];
        $imgError = [];
        foreach($_FILES as $img){
            array_push($imgSizes, $img['size']);
            array_push($imgTypes, $img['type']);
            array_push($imgError, $img['error']);
        }
        foreach($imgSizes as $size){
            if ($size > 104857600) {
                $wrongSize = 'Erreur : les fichiers ne peuvent dépasser 100mo !';
            }
        }
        foreach($imgTypes as $type){
            if ($type != 'image/jpg' && $type != 'image/png') {
                $wrongType = 'Erreur : les extensions acceptées sont jpg et png !';
            }
        }
        foreach($imgError as $error){
            if ($error) {
                $otherError = $error;
            }
        }
        
        if(isset($wrongSize)) {
            print_r($Wrongsize);
        } else if(isset($wrongType)){
            print_r($wrongType);
        } else if(isset($otherError)) {
            print_r($wotherError);
        } else {
            foreach($_FILES as $file) {
                if (move_uploaded_file($file['tmp_name'], '../images/' . basename($file['name']))) {
                    print "Uploaded successfully!";
                } else {
                    print "Upload failed!";
                }
            }
            try
            {
            $sqlInsert = "INSERT INTO projects SET 
                    name = :name, gitLink = :gitLink, date = :date, shortDescript = :shortDescript, 
                    descript = :descript, descriptBis = :descriptBis, descriptTer = :descriptTer, 
                    imgMini = :imgMini, img = :img, imgBis = :imgBis, imgTer = :imgTer";
                $paramsInsert = array(
                    ':name'             => $_POST['name'],
                    ':gitLink'          => $_POST['gitLink'],
                    ':date'             => $_POST['date'],
                    ':shortDescript'    => $_POST['shortDescript'],
                    ':descript'         => $_POST['descript'],
                    ':descriptBis'      => $_POST['descriptBis'],
                    ':descriptTer'      => $_POST['descriptTer'],
                    ':imgMini'          => $_FILES['imgMini']['name'],
                    ':img'              => $_FILES['img']['name'],
                    ':imgBis'           => $_FILES['imgBis']['name'],
                    ':imgTer'           => $_FILES['imgTer']['name']
                );
                $requeteInsert = $db->prepare($sqlInsert);
                $requeteInsert->execute($paramsInsert);
            }
            catch(PDOException $ex)
            {
                die("Erreur " . $ex->getMessage());
            }
            header("Location: ./projectList.php");
        }
    }

    include('inc/header.php');
?>

<div id="content">
    <h1>Ajouter un projet</h1>
    <form method="post" action="" enctype="multipart/form-data">
        <label for="name">Nom</label>
        <input type="text" name="name" id="name" value="Nom du projet">

        <label for="gitLink">Lien GitHub</label>
        <input type="text" name="gitLink" id="gitLink" value="Lien github du projet">

        <label for="date">Date</label>
        <input type="text" name="date" id="date" value="Date de réalisation du projet">

        <label for="shortDescript">Description courte</label>
        <textarea name="shortDescript" id="shortDescript" cols="30" rows="10"
        >Courte description du projet
        </textarea><br>

        <label for="descript">Description</label>
        <textarea name="descript" id="descript" cols="30" rows="10"
        >Description plus complète du projet
        </textarea><br>

        <label for="descriptBis">Description 2</label>
        <textarea name="descriptBis" id="descriptBis" cols="30" rows="10"
        >Les acquis grâce au projet
        </textarea><br>

        <label for="descriptTer">Description 3</label>
        <textarea name="descriptTer" id="descriptTer" cols="30" rows="10"
        >Les projections futures liées au projet
        </textarea><br>

        <label for="imgMini">Image Mini (JPEG/PNG maximum 100mo)</label>
        <input type="file" name="imgMini" id="imgMini">

        <label for="img">Image (JPEG/PNG maximum 100mo)</label>
        <input type="file" name="img" id="img">

        <label for="imgBis">Image 2 (JPEG/PNG maximum 100mo)</label>
        <input type="file" name="imgBis" id="imgBis">

        <label for="imgTer">Image 3 (JPEG/PNG maximum 100mo)</label>
        <input type="file" name="imgTer" id="imgTer">

        <button type="submit" name="envoiForm">Ajouter</button>
    </form>
</div>

<?php
    include('inc/footer.php');
?>
