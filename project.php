<?php
    include 'inc/connexion.php';
    if (isset($_GET['id'])){
        $id = $_GET['id'];
        try {
            $sql= 'SELECT name, gitLink, descript, descriptBis, descriptTer, img, imgBis, imgTer 
                FROM projects
                WHERE id = :id';
            $params = array(
                ':id' => $id
            );
            $requete = $db->prepare($sql);
            $requete->execute($params);
            $project = $requete->fetch();
        } catch(PDOException $ex)
        {
            die("Erreur " . $ex->getMessage());
        }


        $pageTitle = $project['name'];

        include 'inc/header.php';
?>
<!-- Section 1 ------------------------------------------------ -->
<section>
			<div class="sectionBig">
				<div class="bigCard">
					<div class="cardText">
						<div class="cardRead">
							<h2><?php echo $project['name']; ?></h2>
							<p><?php echo $project['descript']; ?></p>
						</div>
						<div class="cardBtns">
							<a href="https://<?php echo $project['gitLink']; ?>" target="blank" class="btns">
								Lien GitHub <i class="fa fa-code-fork" aria-hidden="true"></i>
							</a>
						</div>
					</div>

					<div class="cardImg">
                        <img src="images/<?php echo $project['img']; ?>" alt="<?php echo $project['name']; ?>">
					</div>
				</div>
			</div>
		</section>
<!-- Section 2 ----------------------------------------- -->
		<section>
			<div class="sectionBig">
				<div class="bigCard">
					<div class="cardImgLeft">
                        <img src="images/<?php echo $project['imgBis']; ?>" alt="<?php echo $project['name']; ?>">
					</div>
					<div class="cardText">
						<div class="cardRead">
							<h2>Connaissances acquises</h2>
							<p><?php echo $project['descriptBis']; ?></p>
						</div>
					</div>
				</div>
			</div>
		</section>
<!-- Section 3 ----------------------------------------- -->
		<section>
			<div class="sectionBig">
				<div class="bigCard">
					<div class="cardText">
						<div class="cardRead">
							<h2>Projection</h2>
							<p><?php echo $project['descriptTer']; ?></p>
						</div>
					</div>
					<div class="cardImg">
                        <img src="images/<?php echo $project['imgTer']; ?>" alt="<?php echo $project['name']; ?>">
					</div>
				</div>
			</div>
		</section>

<?php
    include 'inc/footer.php';

    } else {
        header("Location: ./index.php");
        die();
    }

?>
