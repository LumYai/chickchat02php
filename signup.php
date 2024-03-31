<?php
    session_start();
    if(!isset($_SESSION['username'])){


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>chikchat App-Sign Up</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/logo.png">

</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="w-400 p-5 shadow rounded ">
        <form method="post" action="app/http/signup.php" enctype="multipart/form-data">
            <div class="d-flex justify-content-center align-items-center flex-column">
                <img src="img/logo.png" alt="No image" class="w-25">
                <h3 class="display-4 fs-1 text-center">
                    Sign Up
                </h3>
                <!-- ซ่อน Alert แสดงเมื่อมีข้อมูลไม่ได้ใส่ -->
                <?php if(isset($_GET['error'])){ ?>
                        
                    <div class="alert alert-warning" role="alert">
                        <?php echo htmlspecialchars($_GET['error']);?>
                    </div>
                <?php } 
                    if(isset($_GET['name'])) {
                        $name = $_GET['name'];
                    }else $name = '';

                    if(isset($_GET['username'])) {
                        $username = $_GET['username'];
                    }else $username = '';
                ?>

            </div>
            <div class="form-group">
                <label >Name</label>
                <input type="text" name="name" value="<?=$name?>" class="form-control"  placeholder="Enter Name">
            </div>
            <div class="form-group">
                <label >User name</label>
                <input type="text" name="username" value="<?=$username?>" class="form-control"  placeholder="Enter Username">
            </div>

            <div class="form-group">
                <label >Password</label>
                <input type="password" name="password" class="form-control"  placeholder="Enter password">
            </div>
            <div class="form-group">
                <label >Profile Picture</label>
                <input type="file" name="pp" class="form-control"  placeholder="Enter email">
            </div>
            <br>
            <button button type="submit" class="btn btn-primary">Sing Up</button>
            <a href="index.php">Login</a>
        </form>
    </div>
</body>
</html>
<?php
    }else{
        header("Location: home.php");
        exit;
    }
?>