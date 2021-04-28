<?php
    include 'inc/connexion.php';

    try {
        $sql= 'SELECT id, name, date, shortDescript, imgMini FROM projects';
        $requete = $db->prepare($sql);
		$requete->execute();
		$projects = $requete->fetchAll(); // résultats de la requête
	} catch(PDOException $ex)
	{
		die("Erreur " . $ex->getMessage());
	}

    try {
		$sql = "SELECT presentation FROM infos WHERE id = 1";
		$requete = $db->prepare($sql);
		$requete->execute();
		$info = $requete->fetch();
	} catch(PDOException $ex) {
    	die("Erreur " . $ex->getMessage());
    }

    $reverseProjects = array_reverse($projects);
    $pageTitle = 'Accueil';
    $i = 0;

    include 'inc/header.php';

    foreach ($reverseProjects as $project){
        echo '<section>';
        if ($i%2 == 0) {
            echo '<div class="sectionLeft">';
        } else {
            echo '<div class="sectionRight">';
        }
        echo '      <a href="project.php?id=' . $project['id'] . '" class="projectBtn">
                        <div class="card">
                            <div class="cardText">
                                <h2>' . $project['name'] . '</h2>
                                <p>' . $project['date'] . '</br>' . $project['shortDescript'] . '</p>
                            </div>
                            <div class="cardImg">
                                <img src="images/' . $project['imgMini'] . '" alt="' . $project['name'] . '">
                            </div>
                        </div>
                    </a>
                </div>
            </section>';
        $i += 1;
    }
?>
<!-- Presentation ------------------------------------------------ -->
    <section>
        <div class="sectionMid">
            <h2>Présentation</h2>
            <p>
                <?php echo $info['presentation']; ?>
            </p>
        </div>
    </section>

<!-- Footer --------------------------------------------------- -->
<?php
    include 'inc/footer.php';
?>