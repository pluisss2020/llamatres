<?php
if($_SERVER['REQUEST_METHOD'] == "POST" && (isset($_FILES["fileToUpload"]["type"]) ||isset($_FILES["fileToUpload1"]["type"])) ){
$target_dir = "images/usuarios/";
$carpeta=$target_dir;
if (!file_exists($carpeta)) {
    mkdir($carpeta, 0777, true);
}
if(isset($_FILES["fileToUpload"]["type"]))
$target_file = $carpeta . basename($_FILES["fileToUpload"]["name"]);
if(isset($_FILES["fileToUpload1"]["type"]))
$target_file = $carpeta . basename($_FILES["fileToUpload1"]["name"]);

$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
   if(isset($_FILES["fileToUpload"]["type"])) 
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
   if(isset($_FILES["fileToUpload1"]["type"])) 
    $check = getimagesize($_FILES["fileToUpload1"]["tmp_name"]); 
    if($check !== false) {
        $errors[]= "El archivo es una imagen - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $errors[]= "El archivo no es una imagen.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    $errors[]="Lo sentimos, archivo ya existe.";
    $uploadOk = 0;
}
// Check file size
if(isset($_FILES["fileToUpload"]["type"])){
	if ($_FILES["fileToUpload"]["size"] > 524288 ) {
		$errors[]= "Lo sentimos, el archivo es demasiado grande.  Tamaño máximo admitido: 0.5 MB";
		$uploadOk = 0;
	}
}
if(isset($_FILES["fileToUpload1"]["type"])){
	if ($_FILES["fileToUpload1"]["size"] > 524288 ) {
		$errors[]= "Lo sentimos, el archivo es demasiado grande.  Tamaño máximo admitido: 0.5 MB";
		$uploadOk = 0;
	}
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $errors[]= "Lo sentimos, sólo archivos JPG, JPEG, PNG & GIF  son permitidos.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $errors[]= "Lo sentimos, tu archivo no fue subido.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file) || move_uploaded_file($_FILES["fileToUpload1"]["tmp_name"], $target_file)) {
       $messages[]= "El Archivo ha sido subido correctamente.";
	   
	   
    } else {
       $errors[]= "Lo sentimos, hubo un error subiendo el archivo.";
    }
}
 
if (isset($errors)){
	?>
	<div class="alert alert-danger alert-dismissible" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Error!</strong> 
	  <?php
	  foreach ($errors as $error){
		  echo"<p>$error</p>";
	  }
	  ?>
	</div>
	<?php
}
 
if (isset($messages)){
	?>
	<div class="alert alert-success alert-dismissible" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Aviso!</strong> 
	  <?php
	  foreach ($messages as $message){
		  echo"<p>$message</p>";
	  }
	  ?>
	</div>
	<?php
}
}
else echo "error";
?>