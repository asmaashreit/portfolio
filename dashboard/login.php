<?php
    require 'includes/connection.php';
    require 'includes/helperFunction.php';

    $errorMessage = [];
    $errorFlag = 0;
    $message = ""; 

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $email    = cleanInputs($_POST['email']);
        $password = $_POST['password']; 

        if(empty($email)  || empty($password) ){
            $errorFlag = 1;
            $errorMessage['Empty'] = "Can Not Empty Fields";
        }

        elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $errorFlag = 1;
            $errorMessage['Email'] = "Invalid Email";
        }

        elseif(strlen($password) < 6){
            $errorFlag = 1;
            $errorMessage['Password'] = "Password Length must be > 6 chars";
        }

        else{
            $sql = "select * from users where email='$email' and password='$password'";
            $op = mysqli_query($con,$sql);
            $count = mysqli_num_rows($op);
            if($count == 1){
                $_SESSION['userData'] =  mysqli_fetch_assoc($op);
                
                header("Location: index.php");
            }else{
                $message = "error in login";
               header("Location: login.php");
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Page Title - SB Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <?php
                                        if($errorFlag == 0){
                                            echo $message;
                                        }
                                        if($errorFlag == 1){

                                            foreach($errorMessage as $key => $val){
                                                echo '<label class="small mb-1" for="inputEmailAddress"> * '. $val .'</label>';
                                            }
                                        }
                                    ?>
                                    
                                    <div class="card-body">
                                        <form href = "<?php htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                <input name="email" class="form-control py-4" id="inputEmailAddress" type="email" placeholder="Enter email address" />
                                                
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Password</label>
                                                <input name="password" class="form-control py-4" id="inputPassword" type="password" placeholder="Enter password" />
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" />
                                                    <label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="password.html">Forgot Password?</a>
                                                <input type="submit" class="btn btn-primary" value="Login">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="register.html">Need an account? Sign up!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2020</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
