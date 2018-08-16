<?php
    require ('connect.php');
    session_start();
    if (!isset($_SESSION['name'])) {
        echo "<script type='text/javascript'>alert('You must login first');</script>";
  	    header('location: index.php');
  }

    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

// Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
// Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
// Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
// Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        }

    if(isset($_POST['article_post']))
    {

        $article =mysqli_real_escape_string($conn, $_POST['article']);
        $author = $_POST['author'];
        $title= $_POST['a_title'];


        $sql = "INSERT INTO table myArticle(Article, Author,Article_title) VALUES('$article','$author','$title')";


        mysqli_query($conn,$sql);

        echo "<script type='text/javascript'>alert('Article has been posted!');</script>";

    }

    if(isset($_GET['logout']))
    {
        session_destroy();
        unset($_SESSION['name']);
        header('location:index.php');
    }

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
	<title>Home</title>
</head>
<body>
<div class="row">
    <div class="col-lg-12">
        <div class="navbar navbar-top">
         <a href="./display.php">Main Page</a>
        <?php  if (isset($_SESSION['name'])) : ?>
            <p>Welcome <strong><?php echo $_SESSION['name']; ?></strong></p>
            <p> <a href="index.php";>logout</a> </p>
        <?php endif ?>
         </div>
          <div class="article_fill">
            <h2>Create new post</h2>
            <form method="Post" action="home.php" class="form-horizontal">
                <div class="form-group">
                    <label> Title:</label>
                    <input type="text" name="a_title" class="form-control" >
                </div>

                <div class="form-group">
                    <label>Author's Name:</label>
                    <input type="text" name="author" class="form-control" >

                </div>
                <div class="form-group">
                    <label>Image:</label>
                    <form>
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <input type="submit" value="Upload Image" name="submit">
                    </form>
                </div>
                <div class="form-group">
                    <label> Article:</label>
                </div>
                <div class="form-group">
                    <textarea name="article" rows="30" cols="122" maxlength="1000"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" name="article_post" class="btn btn-default">Post</button>
                </div>
            </form>
          </div>
        </div>

</body>
</html>
