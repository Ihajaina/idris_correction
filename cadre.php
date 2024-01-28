<?php
include("config.php");
//session_start();
/*****Verification du mot de passe ****/
if(isset($_POST['mdp'])){
if($_POST['mdp']!="" and $_POST['pseudo']!=""){
	$mdp=$_POST['mdp'];
	$pseudo=$_POST['pseudo'];
	$result = mysqli_query($conn, "SELECT count(*) as nb, type, Num FROM login WHERE pseudo='$pseudo' AND passe='$mdp'");
        // Récupération des données
        $nb = mysqli_fetch_array($result);
	if($nb['nb']==1){
		if($nb['type']=="etudiant")
			$_SESSION['etudiant']=$nb['Num'];
		else if($nb['type']=="prof")
			$_SESSION['prof']=$nb['Num'];
		else if($nb['type']=="admin")
			$_SESSION['admin']=$nb['Num'];
	}
	else{
	?>	<SCRIPT LANGUAGE="Javascript">alert("Login ou mot de passe incorrect");</SCRIPT> 	<?php
	}
	}
	else{
	?> 	<SCRIPT LANGUAGE="Javascript">alert("Vous devez remplir tous les champs!");	</SCRIPT> 	<?php
	}
}
else if(isset($_GET['sortir'])){
session_destroy();
header("location:index.php");
}
Function colspan($min,$max){
if(isset($_SESSION['admin']))
	return $max;
else
	return $min;
}
Function rond(){
if(isset($_SESSION['admin']))
	return 'rounded-q1';	
else
	return 'rounded-company';
}
Function Edition(){
 if(isset($_SESSION['admin']))
 return '<th colspan="2" class="rounded-company">EDITION</th>';
 else
 return '';
}
Function Edition2(){//si on veut affcher edtition pour le prof aussi
 if(isset($_SESSION['admin']) or isset($_SESSION['prof']))
 return '<th colspan="2" class="rounded-company">EDITION</th>';
 else
 return '';
}
Function rond2(){//si on veut affcher edtition pour le prof aussi
if(isset($_SESSION['admin']) or isset($_SESSION['prof']))
	return 'rounded-q1';	
else
	return 'rounded-company';
}
Function colspan2($min,$max){//si on veut affcher edtition pour le prof aussi
if(isset($_SESSION['admin']) or isset($_SESSION['prof']))
	return $max;
else
	return $min;
}
Function choixpardefault2($var1,$var2)//pour selection l'element � modifier par defautl
{
if($var1==$var2)
return 'selected="selected"';
else
return "";
}
$data=mysqli_query($conn,"select distinct nom from classe");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<link rel="stylesheet" media="screen" type="text/css" title="Essai" href="style.css" />
<link rel="stylesheet" media="screen" type="text/css" title="Essai" href="table.css" />

<body>
<div class="ombre"></div>
<div class="entete"><center></center></div>

<div class="menu">
&nbsp;&nbsp;&nbsp;<font color="white">Menu</font><br/><br/>
<div id="monmenu" >
		<ul class="niveau1">
			
				
			<?php if(isset($_SESSION['admin']) or isset($_SESSION['prof'])){ echo '<li><a href="#">Conseil</a>
					<ul class="niveau2" >';
					echo '<li><a href="affiche_conseil.php">Voir les conseils</a></li>'; 
					if(isset($_SESSION['admin'])){ echo '<li><a href="ajout_conseil.php">Ajouter un conseil</a></li>'; } 
				echo '</ul>
				</li>'; } ?>




			


		
			<li><a href="#">Enseignement </a>
				<ul class="niveau2" >
					<li><a href="afficher_enseign.php">Voir les enseignement</a></li>
					<?php if(isset($_SESSION['admin'])){/*!(isset($_SESSION['prof'])) and !(isset($_SESSION['public'])) and !(isset($_SESSION['etudiant']))*/
					echo '<li><a href="ajout_enseignement.php">Ajouter un enseignement</a></li>';
					} ?>
				</ul>
			</li>		
		</ul>
	</div>
		<?php //} ?>
		</div>
<div class="connexion2">
&nbsp;&nbsp;&nbsp;<font color="white">Connexion</font><br/><br/>
<?php if(!(isset($_SESSION['admin'])) and !isset($_SESSION['prof']) and !isset($_SESSION['etudiant'])){
?>
<form action="index.php" method="post">
<FIELDSET>
<LEGEND align=top>Authentification<LEGEND>  <pre>
Pseudo :<br/><input type="text" name="pseudo" size="15">
Mot de passe :<br/><input type="password" name="mdp" size="15"><br/><br/><input type="submit" value="envoyer"><br/>
</pre></fieldset>
</form>
<?php
}
else
echo '<br/><br/><br/><li><a href="index.php?sortir=1">Deconexion</a></li>';
?>
</div>
<div class="pied"><br/><center>&reg; 2010 Ecole sup�rieure de technologie de Berrechid. Gestion de scolarit�</center></div>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>GESTION DES ETUDIANTS </title>
    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png">
    <link rel="stylesheet" href="./vendor/owl-carousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="./vendor/owl-carousel/css/owl.theme.default.min.css">
    <link href="./vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">



</head>

<body>
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <div id="main-wrapper">

        <div class="nav-header">
            <a href="index.html" class="brand-logo">
                <img class="logo-abbr" src="./images/logo.png" alt="">
                <img class="logo-compact" src="./images/logo-text.png" alt="">
                <img class="brand-title" src="./images/logo-text.png" alt="">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>

        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="search_bar dropdown">
                                <span class="search_icon p-3 c-pointer" data-toggle="dropdown">
                                    <i class="mdi mdi-magnify"></i>
                                </span>
                                <div class="dropdown-menu p-0 m-0">
                                    <form>
                                        <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                                    </form>
                                </div>
                            </div>
                        </div>

                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <i class="mdi mdi-bell"></i>
                                    <div class="pulse-css"></div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="list-unstyled">
                                        <li class="media dropdown-item">
                                            <span class="success"><i class="ti-user"></i></span>
                                            <div class="media-body">
                                                <a href="#">
                                                    <p><strong>Martin</strong> has added a <strong>customer</strong> Successfully
                                                    </p>
                                                </a>
                                            </div>
                                            <span class="notify-time">3:20 am</span>
                                        </li>
                                        <li class="media dropdown-item">
                                            <span class="primary"><i class="ti-shopping-cart"></i></span>
                                            <div class="media-body">
                                                <a href="#">
                                                    <p><strong>Jennifer</strong> purchased Light Dashboard 2.0.</p>
                                                </a>
                                            </div>
                                            <span class="notify-time">3:20 am</span>
                                        </li>
                                        <li class="media dropdown-item">
                                            <span class="danger"><i class="ti-bookmark"></i></span>
                                            <div class="media-body">
                                                <a href="#">
                                                    <p><strong>Robin</strong> marked a <strong>ticket</strong> as unsolved.
                                                    </p>
                                                </a>
                                            </div>
                                            <span class="notify-time">3:20 am</span>
                                        </li>
                                        <li class="media dropdown-item">
                                            <span class="primary"><i class="ti-heart"></i></span>
                                            <div class="media-body">
                                                <a href="#">
                                                    <p><strong>David</strong> purchased Light Dashboard 1.0.</p>
                                                </a>
                                            </div>
                                            <span class="notify-time">3:20 am</span>
                                        </li>
                                        <li class="media dropdown-item">
                                            <span class="success"><i class="ti-image"></i></span>
                                            <div class="media-body">
                                                <a href="#">
                                                    <p><strong> James.</strong> has added a<strong>customer</strong> Successfully
                                                    </p>
                                                </a>
                                            </div>
                                            <span class="notify-time">3:20 am</span>
                                        </li>
                                    </ul>
                                    <a class="all-notification" href="#">See all notifications <i
                                            class="ti-arrow-right"></i></a>
                                </div>
                            </li>
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <i class="mdi mdi-account"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="./app-profile.html" class="dropdown-item">
                                        <i class="icon-user"></i>
                                        <span class="ml-2">Profile </span>
                                    </a>
                                    <a href="./email-inbox.html" class="dropdown-item">
                                        <i class="icon-envelope-open"></i>
                                        <span class="ml-2">Inbox </span>
                                    </a>
                                    <a href="./page-login.html" class="dropdown-item">
                                        <i class="icon-key"></i>
                                        <span class="ml-2">Logout </span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>

        <div class="quixnav">
            <div class="quixnav-scroll">
                <ul class="metismenu" id="menu">				

                    <li class="nav-label first">Menu</li>
                    <li>
											<a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon icon-app-store"></i><span class="nav-text">Etudiants</span></a>
                        <ul aria-expanded="false">
												<li>
													<a class="has-arrow" href="javascript:void()" aria-expanded="false">Consulter la liste</a>
                                <ul aria-expanded="false">
																<?php $retour=mysqli_query($conn,"select distinct nom from classe");
							while($a=mysqli_fetch_array($retour)){
							echo '<li><a href="listeEtudiant.php?nomcl='.$a['nom'].'">'.$a['nom'].'</a></li>';				
							}
							?>
                                </ul>
                            </li>
                            <li><a class="has-arrow" href="chercher_eleve.php?cherche_eleve=true" aria-expanded="false">Chercher un etudiant</a>
                          
                            </li>
                        </ul>
                    </li>


				
			</li>



                    <li>
											<a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon icon-app-store"></i><span class="nav-text">Enseignants</span></a>
                        <ul aria-expanded="false">
												<li><a href="afficher_prof.php">Liste des enseignants</a></li>
					<?php if((isset($_SESSION['admin'])) or (isset($_SESSION['prof']))){
					if(!isset($_SESSION['prof'])){echo '<li><a href="ajout_prof.php">Ajouter un enseignant</a></li>';}
					}
					?>	
					<li><a href="chercher_prof.php?cherche_prof=true">Chercher un enseignant</a></li>
                        </ul>
                    </li>

										


                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon icon-app-store"></i><span class="nav-text">Classes</span></a>
                        <ul aria-expanded="false">
												<?php
			$data=mysqli_query($conn,"select distinct nom from classe");
			echo '
					<ul class="niveau2" >
						<li><a href="affiche_classe.php">Voir les classes</a></li>';
						if(!isset($_SESSION['admin']))
						echo '</ul>';
						 else{
						echo '<li><a href="ajout_classe.php">Ajouter une classe</a></li>
					</ul>
				</li>';	}?>
                        </ul>
                    </li>


                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon icon-world-2"></i><span class="nav-text">Stages</span></a>
                        <ul aria-expanded="false">
					<ul class="niveau2" >
						<li><a href="afficher_stage.php">Voir les stages</a></li>
					<?php if(isset($_SESSION['admin'])){ echo '<li><a href="ajout_stage.php">Ajouter un stage</a></li>'; } ?>
						<li><a href="chercher_stage.php?cherche_stage=true">Chercher un stage</a></li>
					</ul>
			</li>	

                        </ul>
                    </li>

										<li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon icon-world-2"></i><span class="nav-text">Conseils</span></a>
                        <ul aria-expanded="false">
					<ul class="niveau2" >
					<?php if(isset($_SESSION['admin']) or isset($_SESSION['prof'])){ echo '<li><a href="#">Conseil</a>
					<ul class="niveau2" >';
					echo '<li><a href="affiche_conseil.php">Voir les conseils</a></li>'; 
					if(isset($_SESSION['admin'])){ echo '<li><a href="ajout_conseil.php">Ajouter un conseil</a></li>'; } 
				echo '</ul>
				</li>'; } ?>
					</ul>
			</li>	

                        </ul>
                    </li>


										


                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon icon-plug"></i><span class="nav-text">Matieres</span></a>
																<ul aria-expanded="false">
    <li>
        <a href="#">Matière</a>
        <ul class="niveau2">
            <li>
                <a href="#">Voir les matières</a>
                <ul class="niveau3">
                    <?php
                    while($nomcl=mysqli_fetch_array($data)) {
                        echo '<li><a href="afficher_matiere.php?nomcl='.$nomcl['nom'].'">'.$nomcl['nom'].'</a></li>';
                    }
                    ?>
                </ul>
            </li>
            <?php
            if(isset($_SESSION['admin'])) {
                echo '<li><a href="ajout_matiere.php">Ajouter une matière</a></li>';
            }
            ?>
        </ul>
    </li>
</ul>
<li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon icon-world-2"></i><span class="nav-text">Bulletins</span></a>
                        <ul aria-expanded="false">
					<ul class="niveau2" ><?php
					if(isset($_SESSION['admin']) or isset($_SESSION['prof'])){ echo'<li><a href="#">Bulletins</a>
				<ul class="niveau2">';
					//if(isset($_SESSION['admin'])){ echo '<li><a href="ajout_bulettin.php">Ajouter une note final</a></li>'; }
				 echo '<li><a href="afficher_bulettin.php">note final d\'un etudiant</a></li>'; 
			echo'</ul>
			</li>';}?>
					</ul>
			</li>	
			

                        </ul>
												<li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon icon-world-2"></i><span class="nav-text">Diplomes</span></a>
                        <ul aria-expanded="false">
					<ul class="niveau2" ><?php
			
			echo '<li><a href="#">Dipl�mes</a>
				<ul class="niveau2">
					<li><a href="type_diplome.php">Types de diplomes</a></li>';
					 if(isset($_SESSION['admin']) or isset($_SESSION['prof']))
					echo '<li><a href="diplome_obt.php">Diplomes obtenus</a></li>	';
					if(isset($_SESSION['admin']))
					echo '<li><a href="ajout_diplome.php?ajout_type">Ajouter un nouveau type</a></li>
					<li><a href="ajout_diplome.php?ajout_diplome">Ajouter une obtention </a>	</li>'; ?>
				</ul>
			</li>
					</ul>
			</li>	

			
                    </li>
										
                    </li>
					</ul>
					<li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon icon-world-2"></i><span class="nav-text">Evaluation</span></a>
                        <ul aria-expanded="false">
					<ul class="niveau2" ><?php if(isset($_SESSION['admin']) or isset($_SESSION['prof']))
			echo '<li><a href="#">Evalutation</a>
						<ul class="niveau2">
							<li><a href="ajout_eval.php">Ajouter une evaluation</a></li>
							<li><a href="afficher_evaluation.php">Voir les evalutations</a></li>
						</ul>
					</li>	
			<li><a href="ajout_devoir.php">Devoirs</a>
				<ul class="niveau2">
				<li><a href="ajout_devoir.php">Ajouter un devoir</a></li>
				<li><a href="afficher_devoir.php">Voir les devoirs</a></li>
				</ul>
			</li>';
		?>	
				</ul>
			</li>
					</ul>
			</li>	

			<li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon icon-world-2"></i><span class="nav-text">Devoirs</span></a>
                        <ul aria-expanded="false">
					<ul class="niveau2" ><?php
			
			echo '<li><a href="#">Devoirs</a>
				<ul class="niveau2">
					';
					 if(isset($_SESSION['admin']) or isset($_SESSION['prof']))
					echo '<li><a href="diplome_obt.php">Diplomes obtenus</a></li>	';
					if(isset($_SESSION['admin']))
					echo '<li><a href="ajout_diplome.php?ajout_type">Ajouter un nouveau type</a></li>
					<li><a href="ajout_diplome.php?ajout_diplome">Ajouter une obtention </a>	</li>'; ?>
				</ul>
			</li>
					</ul>
			</li>	

			
                    </li>
										
                    </li>
					</ul>
					<li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon icon-world-2"></i><span class="nav-text">Enseignements</span></a>
                        <ul aria-expanded="false">
					<ul class="niveau2" ><?php
					 if(isset($_SESSION['admin']) or isset($_SESSION['prof']))
					echo '<li><a href="afficher_enseign.php">Voir les enseignemens</a></li>	';
					if(isset($_SESSION['admin']))
					echo '
					<li><a href="ajout_enseignement.php?ajout_diplome">Ajouter un enseigenemnt </a>	</li>'; ?>
				</ul>
			</li>
					</ul>
			</li>	

                    
          


   
        
                
                      

            </div>
        </div>
 
        
    


    </div>

    <script src="./vendor/global/global.min.js"></script>
    <script src="./js/quixnav-init.js"></script>
    <script src="./js/custom.min.js"></script>


    <script src="./vendor/raphael/raphael.min.js"></script>
    <script src="./vendor/morris/morris.min.js"></script>


    <script src="./vendor/circle-progress/circle-progress.min.js"></script>
    <script src="./vendor/chart.js/Chart.bundle.min.js"></script>

    <script src="./vendor/gaugeJS/dist/gauge.min.js"></script>

    <script src="./vendor/flot/jquery.flot.js"></script>
    <script src="./vendor/flot/jquery.flot.resize.js"></script>

    <script src="./vendor/owl-carousel/js/owl.carousel.min.js"></script>

    <script src="./vendor/jqvmap/js/jquery.vmap.min.js"></script>
    <script src="./vendor/jqvmap/js/jquery.vmap.usa.js"></script>
    <script src="./vendor/jquery.counterup/jquery.counterup.min.js"></script>


    <script src="./js/dashboard/dashboard-1.js"></script>

</body>

</html>