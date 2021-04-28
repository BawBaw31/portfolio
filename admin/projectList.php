<?php
    include '../inc/connexion.php';
    if (empty($_SESSION['user'])) {
        header('Location: ./login.php');
    }

    // get db infos
    try
    {
    $sql = "SELECT id, date, name, shortDescript, descript, descriptBis, descriptTer, imgMini, img, imgBis, imgTer
    FROM projects";
    $requete = $db->prepare($sql);
    $requete->execute();
    $projects = $requete->fetchAll();
    }
    catch(PDOException $ex)
    {
    die("Erreur " . $ex->getMessage());
    }

    include('inc/header.php');
?>
<div id='content'>
    <h1>Table des projets</h1>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Date</th>
                <th>Description Courte</th>
                <th>Description</th>
                <th>Description 2</th>
                <th>Description 3</th>
                <th>Image mini</th>
                <th>Image 1</th>
                <th>Image 2</th>
                <th>Image 3</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- get from db -->
            <?php 
                foreach ($projects as $project){
                    echo '<tr>
                        <td>' . $project['name'] . '</td>
                        <td>' . $project['date'] . '</td>
                        <td>' . $project['shortDescript'] . '</td>
                        <td>' . $project['descript'] . '</td>
                        <td>' . $project['descriptBis'] . '</td>
                        <td>' . $project['descriptTer'] . '</td>
                        <td>' . $project['imgMini'] . '</td>
                        <td>' . $project['img'] . '</td>
                        <td>' . $project['imgBis'] . '</td>
                        <td>' . $project['imgTer'] . '</td>';
                    echo '<td>
                            <a href="modifProject.php?id=' . $project['id'] . '">Modifier</a><br>
                            <button onclick="confirmer(`delProject.php?del=' . $project['id'] . '`, `Êtes-vous sûr de vouloir supprimer?`)">Supprimer</button>
                        </td>
                        </tr>';
                }
            ?>
        </tbody>
    </table>
</div>

<?php
    include('inc/footer.php');
?>

<!-- confirmation JS -->
<script>
    function confirmer(url, msg){
        let res = confirm(msg);

        // call artiste-del.php and delete an artist
        if(res){
            fetch(url)
            .then(result =>{
                location.reload(true);
            })
        } else{
            location.reload(true);
        }
    }
</script>
