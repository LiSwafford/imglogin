<?php
session_start();
include_once "dbh.php";
$id = $_SESSION['id'];

if(isset($_POST['submit'])){
    $file = $_FILES['file'];
    // print_r($file);

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    if(in_array($fileActualExt, $allowed)){
        if($fileError === 0){
            if($fileSize < 1000000){
                $fileNameNew ="profile".$id.".".$fileActualExt;
                $fileDestination = 'uploads/'.$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                $sql = "UPDATE PROFILEIMG SET STATUS=0 WHERE USERID='$id';";
                $result = mysqli_query($conn, $sql);
                header("Location: index.php?uploadsucess");
            }else{
                echo "Your file is too big";
            }

        }else{
            echo "There was an error uploading";
        }
    }else{
        echo "You cannot upload files of the type";
    }

   
}