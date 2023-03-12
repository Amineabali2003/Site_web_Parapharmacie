<?php
 $db_username = 'root';
 $db_password = '';
 $db_name     = 'projet_java';
 $db_host     = 'localhost';
 $db = mysqli_connect($db_host,$db_username,$db_password,$db_name)
        or die('could not connect to database');
$tableName="produit";
$columns= ['code', 'nom','marque','nombre_en_stock','description_produit', 'id_categorie','prix'];
$fetchData = fetch_data($db, $tableName, $columns);
function fetch_data($db, $tableName, $columns){
 if(empty($db)){
  $msg= "Database connection error";
 }elseif (empty($columns) || !is_array($columns)) {
  $msg="columns Name must be defined in an indexed array";
 }elseif(empty($tableName)){
   $msg= "Table Name is empty";
}else{
$columnName = implode(", ", $columns);
$query = "SELECT ".$columnName." FROM $tableName"." ORDER BY id_categorie ASC";
$result = $db->query($query);
if($result== true){ 
 if ($result->num_rows > 0) {
    $row= mysqli_fetch_all($result, MYSQLI_ASSOC);
    $msg= $row;
 } else {
    $msg= "No Data Found"; 
 }
}else{
  $msg= mysqli_error($db);
}
}
return $msg;
}
if(isset($_GET['del']))
        {
          $sup = intval ($_GET['del']);

          $sql = "DELETE FROM produit WHERE code=$sup";
          $query = $db->prepare($sql);
          $query->execute();
          header("location:./page_produit.php");
        }
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="./css/style2.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
</head>
<body class="text-center">
  <h1> Page Produit </h1>
  <!-- Button trigger modal -->
<button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#exampleModal">
  Ajouter
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajouter Produit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="./insertion_produit.php" >
          Code:
          <input type="text" class="form-control" placeholder="Votre code" name="code_produit" aria-label="ID" aria-describedby="basic-addon1">
          Nom:
          <input type="text" class="form-control" placeholder="Votre nom" name="nom_produit" aria-label="Username" aria-describedby="basic-addon1">
          Marque:
          <input type="text" class="form-control" placeholder="Marque" name="marque_produit" aria-label="Username" aria-describedby="basic-addon1">
          Nombre en stock:
          <input type="text" class="form-control" placeholder="Nombre en stock" name="nombre_en_stock" aria-label="Username" aria-describedby="basic-addon1">
          Description du produit:
          <input type="textarea" class="form-control" placeholder="Description du produit" name="descprition_produit" aria-label="Username" aria-describedby="basic-addon1">
          ID de catégorie:
          <input type="text" class="form-control" placeholder="Votre id" name="id_categorie" aria-label="Username" aria-describedby="basic-addon1">
          Prix:
          <input type="text" class="form-control" placeholder="Username" name="prix_produit" aria-label="Username" aria-describedby="basic-addon1">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <input type="submit" value="Ajouter" name="ajouter" class="btn btn-primary"/>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="container">
 <div class="row">
   <div class="col-sm-8">
    <?php echo $deleteMsg??''; ?>
    <div class="table-responsive">
      <table class="table table-bordered">
       <thead>
         <th>Code du produit</th>
         <th>Nom du produit</th>
         <th>Marque du produit</th>
         <th>Nombre en stock</th>
         <th>Description du produit</th>
         <th>ID</th>
         <th>Prix</th>
         <th>Action</th>
    </thead>
    <tbody>
  <?php
      if(is_array($fetchData)){      
      $sn=1;
      foreach($fetchData as $data){
    ?>
      <tr>
      <td><?php echo $data['code']??''; ?></td>
      <td><?php echo $data['nom']??''; ?></td>
      <td><?php echo $data['marque']??''; ?></td>
      <td><?php echo $data['nombre_en_stock']??''; ?></td>
      <td><?php echo $data['description_produit']??''; ?></td>
      <td><?php echo $data['id_categorie']??''; ?></td>
      <td><?php echo $data['prix']??''; ?></td>  
      <td>
                                    
      <a class="btn btn-primary" target="_self"href="./updateProduit.php?id=<?php echo $data['code'];?>">
          <i class="fas fa-edit"></i></a>
          <a class="btn btn-danger" OnClick="return confirm ('Voulez vous vraiment suprimer') " name ="del" href="./page_produit.php?del=<?php echo $data['code'];?>">
          <i class="fas fa-trash"></i></a>    
        </td>
     </tr>
     <?php
      $sn++;}}else{ ?>
      <tr>
        <td colspan="8">
    <?php echo $fetchData; ?>
  </td>
    <tr>
    <?php
    }?>
    </tbody>
     </table>
   </div>
</div>
</div>
</div>
<script>
                $(document).ready(function() {
                    $('#example').DataTable( {
                        "scrollY":        "500px",
                        "scrollCollapse": true,
                        "paging":         false
                        } );
                    } );
            </script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
</body>
</html>
