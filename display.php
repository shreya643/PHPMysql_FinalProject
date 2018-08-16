<?php
require ('connect.php');

if(isset($_GET['logout'])) {

    session_destroy();
    unset($_SESSION['name']);
    header('location:index.php');
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

</head>
<body class="display">
<div class="row">

    <div class="col-lg-12">
        <div class="navbar navbar-top">
         <?php  if (isset($_SESSION['name'])) : ?>
    	<p>Welcome <strong><?php echo $_SESSION['name']; ?></strong></p>
    	<p> <a href="index.php">logout</a> </p>
        <?php endif ?>
    </div>
        <h1 class="text-center" ><b>Create new post</b></h1>
        <?php
        require ('connect.php');

        $sql = "SELECT * FROM myArticle";

        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) { ?>
        <div id="box">
            <div class="card-header">
                <a class="card-link" data-toggle="collapse" href="#<?php echo $row['Article_no'];?>"><?php echo $row['Article_title'];?></a>
            </div>
            <div class="collapse" data-parent="#accordion" id="<?php echo $row['Article_no'];?>">
                <h5 class="date"><?php echo $row['Published_date'] ?></h5>
                <p class="author"><b>By:<?php echo $row['Author'] ?></b></p>
                <p class="article"> <?php echo $row['Article']."</p>";


                echo "</div>";
                echo "</div>";
                }
        ?>



</div>
        </div>
</body>
</html>

