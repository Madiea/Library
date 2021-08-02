<?php

include 'inc/init.php'; // connexion à la BDD + des outils

//-----------------------------------------------------------
//-----------------------------------------------------------
// SUPPRESSION de l'abonné
//-----------------------------------------------------------
//-----------------------------------------------------------
if( isset($_GET['action']) && $_GET['action'] == 'supprimer' && !empty($_GET['id_abonne']) )  {
    $suppression = $pdo->prepare("DELETE FROM abonne WHERE id_abonne = :id_abonne");
    $suppression->bindParam(":id_abonne", $_GET['id_abonne'], PDO::PARAM_STR);
    $suppression->execute();
}


//-----------------------------------------------------------
//-----------------------------------------------------------
// MODIFICATION de l'abonné
//-----------------------------------------------------------
//-----------------------------------------------------------
$id_abonne ="";
$prenom = "" ;
$nom = "" ;
$mail = "" ;
$telephone = "";

if(isset($_GET['action']) && $_GET['action'] == 'modifier' && !empty($_GET['id_abonne'])) {
  $recup_abonne = $pdo->prepare("SELECT id_abonne, prenom, nom, mail, telephone FROM abonne WHERE id_abonne= :id_abonne");
  $recup_abonne-> bindParam(":id_abonne", $_GET['id_abonne'], PDO::PARAM_STR);
  $recup_abonne->execute();

if($recup_abonne->rowCount() > 0){
  $info_abonne = $recup_abonne->fetch(PDO::FETCH_ASSOC);

  $id_abonne = $info_abonne['id_abonne'];
  $prenom = $info_abonne['prenom'];
  $nom = $info_abonne['nom'];
  $mail = $info_abonne['mail'];
  $telephone = $info_abonne['telephone'];
  
}

}

//-----------------------------------------------------------
//-----------------------------------------------------------
// Enregistrement de l'abonné
//-----------------------------------------------------------
//-----------------------------------------------------------
if(isset($_POST['id_abonne']) && isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['mail']) && isset($_POST['telephone']) ){

$id_abonne = trim($_POST['id_abonne']);
$prenom = trim($_POST['prenom']);
$nom = trim($_POST['nom']);
$mail = trim($_POST['mail']);
$telephone = trim($_POST['telephone']);


if(empty($id_abonne)){

$enregistrement = $pdo->prepare("INSERT INTO abonne (id_abonne, prenom , nom, mail, telephone) VALUES ( NULL, :prenom, :nom, :mail, :telephone)");
        
        $enregistrement->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $enregistrement->bindParam(':nom', $nom, PDO::PARAM_STR);
        $enregistrement->bindParam(':mail', $mail, PDO::PARAM_STR);
        $enregistrement->bindParam(':telephone', $telephone, PDO::PARAM_STR);
        $enregistrement->execute();



  } else{

  $modification = $pdo->prepare("UPDATE abonne SET prenom = :prenom, nom = :nom , mail= :mail , telephone = :telephone WHERE id_abonne = :id_abonne");
        $modification->bindParam(':id_abonne', $id_abonne, PDO::PARAM_STR);
        $modification->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $modification->bindParam(':nom', $nom, PDO::PARAM_STR);
        $modification->bindParam(':mail', $mail, PDO::PARAM_STR);
        $modification->bindParam(':telephone', $telephone, PDO::PARAM_STR);
        $modification->execute();      
  }
}

//-----------------------------------------------------------
//-----------------------------------------------------------
// récupération de la liste des catégories en BDD pour les afficher dans le select option du formulaire
//-----------------------------------------------------------
//-----------------------------------------------------------
$liste_abonne= $pdo->prepare("SELECT id_abonne, prenom, nom, mail, telephone FROM abonne");
$liste_abonne->execute();

// Début des affichages !
include 'inc/header.inc.php';
include 'inc/nav.inc.php';

?>

<main>

<div class="row">
  <div class="col-12">    
      <table class="table table-bordered mt-5">
        <tr>
          <th>ID abonné</th>
          <th>Prénom</th>
          <th>Nom</th>
          <th>Mail</th>
          <th>Téléphone</th>                              
          <th>Modification</th>
          <th>Suppression</th>
        </tr>

<?php 

while($ligne = $liste_abonne->fetch(PDO::FETCH_ASSOC)) {
    echo '<tr>';
    echo '<td>' . $ligne['id_abonne'] . '</td>';
    echo '<td>' . $ligne['prenom'] . '</td>';
    echo '<td>' . $ligne['nom'] . '</td>';
    echo '<td>' . substr($ligne['mail'], 0, 7) . '...</td>';                                  
    echo '<td>' . $ligne['telephone'] . '</td>';
                                    
    // bouton modifier
    echo '<td><a href="?action=modifier&id_abonne=' . $ligne['id_abonne'] . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a> </td>';
    // bouton supprimer
    echo '<td><a href="?action=supprimer&id_abonne=' . $ligne['id_abonne'] . '" onclick="return(confirm(\'Etes vous sûr ?\'))" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a></td>';                  
    echo '</tr>';
}

?>

</table>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-12 mt-5">
      <form method="post" action="" class="p-3 border">
        <input type="text" name="id_abonne" id="id_abonne" value="<?php echo $id_abonne;?>">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="prenom">Prénom</label>
                  <input type="text" name="prenom" id="prenom" class="form-control">
                </div> 
                <div class="form-group">
                  <label for="nom">Nom</label>
                  <input type="text" name="nom" id="nom" class="form-control">
                </div>
                <div class="form-group">
                  <label for="mail">Mail</label>
                  <input type="text" name="mail" id="mail" class="form-control">
                </div>
                <div class="form-group">
                  <label for="telephone">Téléphone</label>
                  <input type="text" name="telephone" id="telephone" class="form-control">
                </div>
                <div class="form-group">
                  <label>&nbsp;</label>
                  <button type="submit" id="ajouter" class="btn btn-primary w-100"> Ajouter <i class="fas fa-sign-in-alt"></i></button>
                </div>
    </div>
</div>

</main>

<?php 
include 'inc/footer.inc.php';


?>



