<?php
session_start();
include('cadre.php');
$conn = mysqli_connect("localhost", "root", "");
mysqli_select_db($conn, "gestion");
?>

<html>
<div class="corp">
<img src="titre_img/affich_prof.png" class="position_titre">
<pre>
<?php
$data = mysqli_query($conn, "select * from prof");
?>
<center>
  <table id="rounded-corner">
    <thead>
      <tr><?php echo Edition();?>
        <th scope="col" class="<?php echo rond(); ?>">Nom</th>
        <th scope="col" class="rounded-q2">Prenom</th>
        <th scope="col" class="rounded-q2">Adresse</th>
        <th scope="col" class="rounded-q2">Telephone</th>
        <th scope="col" class="rounded-q2">Matières enseignées</th>
        <th scope="col" class="rounded-q4">Classes coordonnées</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td colspan="<?php echo colspan(5,7); ?>" class="rounded-foot-left"><em>&nbsp;</em></td>
        <td class="rounded-foot-right">&nbsp;</td>
      </tr>
    </tfoot>
    <tbody>
      <?php while($a = mysqli_fetch_array($data)): ?>
        <tr>
          <?php if(isset($_SESSION['admin']) || isset($_SESSION['etudiant']) || isset($_SESSION['prof'])): ?>
            <td><a href="modif_prof.php?modif_prof=<?php echo $a['numprof']; ?>">modifier</a></td>
            <td><a href="modif_prof.php?supp_prof=<?php echo $a['numprof']; ?>" onclick="return(confirm('Etes-vous sûr de vouloir supprimer cette entrée ?'));">supprimer</a></td>
          <?php endif; ?>
          <td><?php echo $a['nom']; ?></td>
          <td><?php echo $a['prenom']; ?></td>
          <td><?php echo $a['adresse']; ?></td>
          <td><?php echo $a['telephone']; ?></td>
          <td><a href="option_prof.php?matiere=<?php echo $a['numprof']; ?>">Voir</a></td>
          <td><a href="option_prof.php?classe=<?php echo $a['numprof']; ?>">Voir</a></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</center>
<?php
echo '<br/><br/><a href="index.php">Revenir à la page précédente !</a>';
?>
</pre>
</div>
</html>
