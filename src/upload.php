
<?php
    if(isset($_FILES))
    {
        $temp_file = $_FILES["file"]["tmp_name"];
        $uploads_folder = "/var/www/html/upload/uploads/".$_FILES["file"]["name"];
        $upload_state = move_uploaded_file($temp_file, $uploads_folder);
        
        if ($upload_state == true){
            echo($_FILES["file"]["name"]);
        }
    }
    
     
/*
    $target_dir = "/var/www/html/upload/uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if(isset($_POST["submit"])) 
    {
        if($_FILES["file"]["error"] > 0)
        {
            //echo("<div class='error'> ERROR: Code ". $_FILES["file"]["error"]. "</div>");
        }
        else if(file_exists($target_file))
        {
            //echo("<div class='error'> ERROR: Bereits hochgeladen </div>");
        }
        else if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file))
        {
            //echo("<div class='notify'> Erfolgreicher upload </div>");
            echo($_FILES["file"]["name"]);
        }
        else
        {
            //echo("<div class='error'> ERROR: Unbekannter Fehler beim Upload </div>");
        }
    }
*/
?>
