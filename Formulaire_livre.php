<?php

include 'inc/init.php'; 


if( isset($_GET['action']) && $_GET['action'] == 'supprimer' && !empty($_GET['id_livre']) )  {
    $suppression = $pdo->prepare("DELETE FROM livre WHERE id_livre = :id_livre");
    $suppression->bindParam(":id_livre", $_GET['id_livre'], PDO::PARAM_STR);
    $suppression->execute();
}





$id_livre ="";
$prenom = "" ;
$nom = "" ;
$mail = "" ;
$telephone = "";

if(isset($_GET['action']) && $_GET['action'] == 'modifier' && !empty($_GET['id_livre'])) {
  $recup_livre = $pdo->prepare("SELECT id_livre, auteur, titre FROM livre WHERE id_livre= :id_livre");
  $recup_livre-> bindParam(":id_livre", $_GET['id_livre'], PDO::PARAM_STR);
  $recup_livre->execute();

if($recup_livre->rowCount() > 0){
  $info_livre = $recup_livre->fetch(PDO::FETCH_ASSOC);

  $id_livre = $info_livre['id_livre'];
  $auteur = $info_livre['auteur'];
  $titre = $info_livre['titre'];
  }
}



if(isset($_POST['id_livre']) && isset($_POST['auteur']) && isset($_POST['titre']) ){

$id_livre = trim($_POST['id_livre']);
$auteur = trim($_POST['auteur']);
$titre = trim($_POST['titre']);



if(empty($id_livre)){

$enregistrement = $pdo->prepare("INSERT INTO livre (id_livre, auteur , titre) VALUES ( NULL, :auteur, :titre)");
        
        $enregistrement->bindParam(':auteur', $auteur, PDO::PARAM_STR);
        $enregistrement->bindParam(':titre', $titre, PDO::PARAM_STR);
        $enregistrement->execute();



} else{
  $modification = $pdo->prepare("UPDATE livre SET  auteur = :auteur, titre = :titre WHERE id_livre = :id_livre");
        $modification->bindParam(':id_livre', $id_livre, PDO::PARAM_STR);
        $modification->bindParam(':auteur', $auteur, PDO::PARAM_STR);
        $modification->bindParam(':titre', $titre, PDO::PARAM_STR); 
        $modification->execute();

       
}


}


$liste_livre= $pdo->prepare("SELECT id_livre, auteur, titre FROM livre");
$liste_livre->execute();

include 'inc/header.inc.php';
include 'inc/nav.inc.php';
?>


<main>

<div class="row">
  <div class="col-12">
    
      <table class="table table-bordered mt-5">
                            <tr>
                                <th>id_livre</th>
                                <th>Auteur</th>
                                <th>titre</th>
                                
                                <th>Modification</th>
                                <th>Suprimer</th>

                            </tr>
<?php 

while($line = $liste_livre->fetch(PDO::FETCH_ASSOC)) {
  // var_dump($article);
     echo '<tr>';
  /*
 foreach($article AS $valeur) {
  echo '<td>' . $valeur . '</td>';
                                    }
*/
                                  echo '<td>' . $line['id_livre'] . '</td>';
                                  echo '<td>' . $line['auteur'] . '</td>';
                                  echo '<td>' . $line['titre'] . '</td>';
                                  
                                    // boutons pour les actions :
                                   
                                    // bouton modifier
                                    echo '<td><a href="?action=modifier&id_livre=' . $line['id_livre'] . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a> </td>';
                                    // bouton supprimer
                                    echo '<td><a href="?action=supprimer&id_livre=' . $line['id_livre'] . '" onclick="return(confirm(\'Etes vous sûr ?\'))" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a></td>';
                                   

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
                         <input type="text" name="id_livre" id="id_livre" value="<?php echo $id_livre;?>">

                            <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="auteur">auteur</label>
                                        <input type="text" name="auteur" id="auteur" class="form-control">
                                     </div>   

                                       <div class="form-group">
                                        <label for="titre">titre</label>
                                        <input type="text" name="titre" id="titre" class="form-control">
                                     </div>   

                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="submit" id="ajouter" class="btn btn-primary w-100"> Ajouter <i class="fas fa-sign-in-alt"></i></button>
                                    </div>
                                 
                                 </div>
                              </div>
                        </form>
                      
                              
</main>
<?php 
include 'inc/footer.inc.php';


?>