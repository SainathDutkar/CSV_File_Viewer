<?php

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["tmp_name"]);
$FileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if file is a csv file
if(isset($_POST["submit"])) {
   $fileName=$_FILES["fileToUpload"]["name"];
   move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], 'uploads/' . $_FILES["fileToUpload"]["name"]);
header("Location: http://web.njit.edu/~sgd23/IS601101Project1/index.php?page=htmlTable&filename=".$_FILES["fileToUpload"]["name"]);
  
}
?>

