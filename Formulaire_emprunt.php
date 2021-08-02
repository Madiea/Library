<?php

include 'inc/init.php'; // connexion à la BDD + des outils

//-----------------------------------------------------------
//-----------------------------------------------------------
// SUPPRESSION de l'emprunt
//-----------------------------------------------------------
//-----------------------------------------------------------
if( isset($_GET['action']) && $_GET['action'] == 'supprimer' && !empty($_GET['id_emprunt']) )  {
  $suppression = $pdo->prepare("DELETE FROM emprunt WHERE id_emprunt = :id_emprunt");
  $suppression->bindParam(":id_emprunt", $_GET['id_emprunt'], PDO::PARAM_STR);
  $suppression->execute();
}


//-----------------------------------------------------------
//-----------------------------------------------------------
// MODIFICATION de l'emprunt
//-----------------------------------------------------------
//-----------------------------------------------------------
$id_emprunt ="";
$id_livre = "" ;
$id_abonne = "" ;
$date_sortie = "" ;
$date_rendu = "";

if(isset($_GET['action']) && $_GET['action'] == 'modifier' && !empty($_GET['id_emprunt'])) {
$recup_emprunt = $pdo->prepare("SELECT id_emprunt, id_livre, id_abonne, date_sortie, date_rendu FROM emprunt WHERE id_emprunt= :id_emprunt");
$recup_emprunt-> bindParam(":id_emprunt", $_GET['id_emprunt'], PDO::PARAM_STR);
$recup_emprunt->execute();

if($recup_emprunt->rowCount() > 0){
$info_emprunt = $recup_emprunt->fetch(PDO::FETCH_ASSOC);

$id_emprunt = $info_emprunt['id_emprunt'];
$id_livre = $info_emprunt['id_livre'];
$id_abonne = $info_emprunt['id_abonne'];
$date_sortie = $info_emprunt['date_sortie'];
$date_rendu = $info_emprunt['date_rendu'];
}

}

//-----------------------------------------------------------
//-----------------------------------------------------------
// Enregistrement de l'emprunt
//-----------------------------------------------------------
//-----------------------------------------------------------
if(isset($_POST['id_emprunt']) && isset($_POST['id_livre']) && isset($_POST['id_abonne']) && isset($_POST['date_sortie']) && isset($_POST['date_rendu']) ){

  $id_emprunt = trim($_POST['id_emprunt']);
  $id_livre = trim($_POST['id_livre']);
  $id_abonne = trim($_POST['id_abonne']);
  $date_sortie = trim($_POST['date_sortie']);
  $date_rendu = trim($_POST['date_rendu']);
  
  if(empty($date_rendu)) {
    $date_rendu = NULL;
  }
  
  
  if(empty($id_emprunt)){
  
  $enregistrement = $pdo->prepare("INSERT INTO emprunt (id_emprunt, id_livre , id_abonne, date_sortie, date_rendu) VALUES ( NULL, :id_livre, :id_abonne, :date_sortie, :date_rendu)");
          
          $enregistrement->bindParam(':id_livre', $id_livre, PDO::PARAM_STR);
          $enregistrement->bindParam(':id_abonne', $id_abonne, PDO::PARAM_STR);
          $enregistrement->bindParam(':date_sortie', $date_sortie, PDO::PARAM_STR);
          $enregistrement->bindParam(':date_rendu', $date_rendu, PDO::PARAM_STR);
          $enregistrement->execute();
  
  
  
    } else{
  
    $modification = $pdo->prepare("UPDATE emprunt SET id_livre = :id_livre, id_abonne = :id_abonne , date_sortie= :date_sortie , date_rendu = :date_rendu WHERE id_emprunt = :id_emprunt");
          $modification->bindParam(':id_emprunt', $id_emprunt, PDO::PARAM_STR);
          $modification->bindParam(':id_livre', $id_livre, PDO::PARAM_STR);
          $modification->bindParam(':id_abonne', $id_abonne, PDO::PARAM_STR);
          $modification->bindParam(':date_sortie', $date_sortie, PDO::PARAM_STR);
          $modification->bindParam(':date_rendu', $date_rendu, PDO::PARAM_STR);
          $modification->execute();      
    }
  }


//-----------------------------------------------------------
//-----------------------------------------------------------
// récupération de la liste des emprunts en BDD pour les afficher dans le select option du formulaire
//-----------------------------------------------------------
//-----------------------------------------------------------
$liste_emprunt= $pdo->prepare("SELECT id_emprunt, id_livre, id_abonne, date_sortie, date_rendu FROM emprunt");
$liste_emprunt->execute();

//-----------------------------------------------------------
//-----------------------------------------------------------
// récupération de la liste des abonnés en BDD pour les afficher dans le select option du formulaire
//-----------------------------------------------------------
//-----------------------------------------------------------
$liste_abonne= $pdo->prepare("SELECT id_abonne, prenom FROM abonne");
$liste_abonne->execute();

//-----------------------------------------------------------
//-----------------------------------------------------------
// récupération de la liste des livres en BDD pour les afficher dans le select option du formulaire
//-----------------------------------------------------------
//-----------------------------------------------------------
$liste_livre= $pdo->prepare("SELECT id_livre, auteur, titre FROM livre");
$liste_livre->execute();



// Début des affichages !
include 'inc/header.inc.php';
include 'inc/nav.inc.php';

?>

<main>

<div class="row">
  <div class="col-12">    
      <table class="table table-bordered mt-5">
        <tr>
          <th>ID emprunt</th>
          <th>ID livre</th>
          <th>ID abonné</th>
          <th>Date sortie</th>
          <th>Date rendu</th>                              
          <th>Modification</th>
          <th>Suprimer</th>
        </tr>
      

<?php 

while($ligne_emprunt = $liste_emprunt->fetch(PDO::FETCH_ASSOC)) {
    echo '<tr>';
    echo '<td>' . $ligne_emprunt['id_emprunt'] . '</td>';
    echo '<td>' . $ligne_emprunt['id_livre'] . '</td>';
    echo '<td>' . $ligne_emprunt['id_abonne'] . '</td>';
    echo '<td>' . $ligne_emprunt['date_sortie']. '</td>';                                  
    echo '<td>' . $ligne_emprunt['date_rendu'] . '</td>';                                    
    // bouton modifier
    echo '<td><a href="?action=modifier&id_emprunt=' . $ligne_emprunt['id_emprunt'] . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a> </td>';
    // bouton supprimer
    echo '<td><a href="?action=supprimer&id_emprunt=' . $ligne_emprunt['id_emprunt'] . '" onclick="return(confirm(\'Etes vous sûr ?\'))" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a></td>';                  
    echo '</tr>';
}

?>

      </table>
  </div>
</div>

<div class="container">
       <form method="post" action="" class="p-3 ">
       <input type="hidden" name="id_emprunt" value="<?php echo $id_emprunt; ?>">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="abonne">Abonné</label>  
                    <select name="id_abonne" id="abonne" class="form-control">
                      <?php                       
                        while($abonne = $liste_abonne->fetch(PDO::FETCH_ASSOC)) {
    
                          if($abonne['id_abonne'] == $id_abonne) {
                           echo '<option value="' . $abonne['id_abonne'] . '" selected >' . $abonne['id_abonne'] . ' - ' . $abonne['prenom'] . '</option>';
                           } else {
                           echo '<option value="' . $abonne['id_abonne'] . '">' . $abonne['id_abonne'] . ' - ' . $abonne['prenom'] . '</option>';
                              } 
                        }
                      ?>
                    </select>                  
                </div> 
                <div class="form-group">
                  <label for="livre">Livre</label>
                  <select name="id_livre" id="livre" class="form-control">
                      <?php                       
                        while($livre = $liste_livre->fetch(PDO::FETCH_ASSOC)) {
    
                          if($livre['id_livre'] == $id_livre) {
                           echo '<option value="' . $livre['id_livre'] . '" selected >' . $livre['id_livre'] . ' - ' . $livre['auteur'] . ' | ' . $livre['titre'] . '</option>';
                           } else {
                           echo '<option value="' . $livre['id_livre'] . '">' . $livre['id_livre'] . ' - ' . $livre['auteur'] . ' | ' . $livre['titre'] . '</option>';
                              } 
                        }
                      ?>
                    </select>  
                </div>
                <div class="form-group">
                  <label for="date_sortie">Date sortie</label>
                  <input type="text" name="date_sortie" id="date_sortie" class="form-control" value="<?php echo $date_sortie; ?>">
                </div>
                <div class="form-group">
                  <label for="date_rendu">Date rendu</label>
                  <input type="text" name="date_rendu" id="date_rendu" class="form-control" value="<?php echo $date_rendu; ?>">
                </div>
                <div class="form-group">
                  <label>&nbsp;</label>
                  <button type="submit" id="ajouter" class="btn btn-primary w-100"> Ajouter <i class="fas fa-sign-in-alt"></i></button>
                </div>
                
    </div>
</div>
</main>