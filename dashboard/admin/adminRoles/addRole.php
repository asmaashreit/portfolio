<?php
    require '../../includes/connection.php';
    include '../../includes/helperFunction.php';

    $errorFlag = 0;
    $errorMessage = '';
    $message = '';

    // Check Request To Add New Role
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $title = cleanInputs($_POST['title']);
        
        //Check Empty Input
        if(empty($title)){
            $errorFlag = 1;
            $errorMessage = 'field can not be Empty';
        }

        //check validate input string
        elseif(filter_var($title, FILTER_VALIDATE_EMAIL) || filter_var($title, FILTER_VALIDATE_INT) || filter_var($title, FILTER_VALIDATE_URL)){
            $errorFlag = 1;
            $errorMessage = 'field must be String';
        }
        else{

            //Chech data if found or not in databaise
            $sql = "SELECT id FROM roles WHERE role = '$title'";
            $count = mysqli_num_rows(mysqli_query($con,$sql));
            
            if($count == 1){
                $errorFlag = 1;
                $errorMessage = 'Role Found Before';
            }
            else{
                //Insert Data 
                $sql = "INSERT INTO roles (role) VALUES ('$title')";
                $op = mysqli_query($con,$sql);

                if($op){
                    $message = "Data inserted";
                    header('location: displayRoles.php');
                }
            }
        }
    }
?>
<?php
    include '../../includes/layout/head.php'; 
?>

    <body class="sb-nav-fixed">
        <?php include '../../includes/layout/nav.php'; ?>
        <div id="layoutSidenav">
        <?php include '../../includes/layout/sideNav.php'; ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Add Role</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="../../index.php">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="displayRoles.php">Admin Roles</a></li>
                            <li class="breadcrumb-item active">Add Roles</li>
                        </ol>

                        <div class="card-body">
                            <form  action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputTitleRole"><h4>Title role</h4></label>
                                    <input class="form-control py-4"  name="title" id="inputTitleRole" type="text" placeholder="Enter New Role title"  required />
                                    <?php
                                        if($errorFlag == 1){
                                            echo '<label class="small mb-1"><h6>* '.$errorMessage.'</h6></label>';
                                        }
                                    ?>
                                </div>

                                <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                    <input type="submit" class="btn btn-primary" value="Save"> 
                                </div>
                            </form>
                        </div>
                        
                    </div>
                </main>
                <?php include '../../includes/layout/footer.php'; ?>
