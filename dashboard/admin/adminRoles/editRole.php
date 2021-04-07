<?php
    require '../../includes/connection.php';
    include '../../includes/helperFunction.php';

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        //$role = filter_var($_GET['role'], FILTER_SANITIZE_NUMBER_INT);
        $sql = "SELECT * FROM roles WHERE id=".$id;
        $op = mysqli_query($con,$sql);

        //Check Data Founded Or Not
        if(mysqli_num_rows($op) == 0){

            $_SESSION['message'] = 'No Founded Role';
            header('location: displayRoles.php');

        }
        else{
            $data = mysqli_fetch_assoc($op);
        }

    }

    $errorFlag = 0;
    $errorMessage = '';
    $message = '';

    // Check Request To Add New Role
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $title = cleanInputs($_POST['title']);
        $id = cleanInputs($_POST['id']);

        //Check Empty Input
        if(empty($title)){
            $errorFlag = 1;
            $errorMessage = 'field can not be Empty';
        }

        //check validate input string
        elseif(filter_var($title, FILTER_VALIDATE_EMAIL) || filter_var($title, FILTER_VALIDATE_INT) || filter_var($title, FILTER_VALIDATE_URL)){
            $errorFlag = 1;
            $errorMessage = 'field must be String';
        }else{
            //Chech data if found or not in databaise
            // $sq = "SELECT id FROM roles WHERE role = '$title'";
            // $count = mysqli_num_rows(mysqli_query($con,$sq));
            
            // if($count == 1){
            //     $errorFlag = 1;
            //     $errorMessage = 'Role Found Before';
            // }
        
            // else{
                //Update Data 
                $sql = "UPDATE roles SET role = '$title' WHERE id =".$id;
                $op = mysqli_query($con,$sql);

                if($op){
                    $message = "Data Updated";
                    header('location: displayRoles.php');
                }else{
                    $errorFlag = 1;
                    //$errorMessage = mysqli_error($con);

                                      

                header('location: editRole.php?id='.$id);
                }
            //}
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
                                <input type="hidden" name="id" value="<?php if(isset($data['id'])){ echo $data['id']; }?>">
                                
                                <div class="form-group">
                                    <label class="small mb-1" for="inputTitleRole"><h4>Edit Title role</h4></label>
                                    <input class="form-control py-4" value="<?php echo $_SESSION['role']; ?>" name="title" id="inputTitleRole" type="text" placeholder="Enter New Role title"  required />
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
