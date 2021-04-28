<?php
    include 'inc/connexion.php';

	try {
		$sql = "SELECT phone, mail, linkedIn, cv, photo FROM infos WHERE id = 1";
		$requete = $db->prepare($sql);
		$requete->execute();
		$infos = $requete->fetch();
	} catch(PDOException $ex) {
    	die("Erreur " . $ex->getMessage());
    }


    $pageTitle = 'A propos';

    include 'inc/header.php';
?>

<!-- Section 1 ------------------------------------------------ -->
<section>
			<div class="sectionBig">
				<div class="bigCard">
					<div class="cardText contact">
						<div class="cardRead">
							<h2>Contact </h2>
							<h3><i class="fa fa-mobile fa-3x" aria-hidden="true"></i><?php echo $infos['phone']; ?></h3>
							<h3><i class="fa fa-envelope fa-2x" aria-hidden="true"></i><?php echo $infos['mail']; ?></h3>
						</div>
						<div class="cardBtns">
							<a href="https://<?php echo $infos['linkedIn']; ?>" target="blank" class="btns">
								Linked <i class="fa fa-linkedin fa" aria-hidden="true"></i>
							</a>
							<a href="documents/<?php echo $infos['cv']; ?>" download="cvArthurIsnard.pdf" class="btns">
								Télécharger CV <i class="fa fa-download" aria-hidden="true"></i>
							</a>
						</div>
					</div>

					<div class="photo">
						<img src="images/<?php echo $infos['photo']; ?>" alt="Arthur ISNARD">
					</div>
				</div>
			</div>
		</section>

<!-- Section 2 ------------------------------------- -->
		<section>
			<div class="sectionBig">
				<div class="bigCard" id="mentionCard">
					<h2>Mentions Legales</h2>
					<div class="mentionBloc">
						<div class="cardText mentionText">
							<h3>Informations éditeur</h3>
							<p>Nom: Isnard</p>
							<p>Prénom: Arthur</p>
							<p>Adresse: 12 allée Pierre Edouard Dujard, 77600</p>
							<p>Téléphone: 06 66 66 69 00</p>
							<p>Email: artisnard@gmail.com</p>
						</div>

						<div class="cardText mentionText">
							<h3>Développeur</h3>
							<p>Développeur du site : Arthur Isnard</p>
							<p>Adresse : 12 allée Pierre Edouard Dujard, 77600</p>
							<p>Site du développeur : /</p>
						</div>

						<div class="cardText mentionText">
							<h3>Informations site et hébergement</h3>
							<p>Site : /</p>
							<p>Hébergeur : /</p>
							<p>Adresse : /</p>
							<p>Site de l'hébergeur : /</p>
						</div>
					</div>
				</div>
			</div>
		</section>

<?php
    include 'inc/footer.php';
?>