<?php
    require '../../includes/connection.php';
    include '../../includes/helperFunction.php';

    if($_SERVER['REQUEST_METHOD'] == "GET"){

        $id  =  filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
        $sql = "SELECT * FROM users WHERE id = ".$id;
        $op = mysqli_query($con,$sql);

        if(mysqli_num_rows($op) == 0){
    
            $_SESSION['message'] = "no user founded with this id";
        
            header('Location: displayAccounts.php'); 
        
            }else{
                $data = mysqli_fetch_assoc($op);
                $sql = "select * from roles";
                $roles  = mysqli_query($con,$sql); 
                $table_roles = mysqli_fetch_assoc($roles);
    
         }
    
    
       }


    $errorFlag = 0;
    $errorMessage = '';
    $message = '';

    // Check Request To Add New Account
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name = cleanInputs($_POST['name']);
        $email = cleanInputs($_POST['email']);
        $password = htmlspecialchars(trim($_POST['password']));
        $gender = cleanInputs($_POST['gender']);
        $role = cleanInputs($_POST['role']);

        $email = filter_var($email,FILTER_SANITIZE_EMAIL);

        // Check Upload File Image
        $fileTmpName = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];

        $fileExt = explode('.',$fileName);    
        
        $count =   count($fileExt);
  
        // $fileExt;
        $extension = strtolower($fileExt[$count-1]);

        $imgName = time().$fileExt[0].'.'.$extension;
    
        $allow_ex = array('jpg','jpeg','png');

        if(in_array($extension,$allow_ex)){
            $uploadFolder = '../../uploads/'; 
            $destPath = $uploadFolder.$imgName;
            
            if(move_uploaded_file($fileTmpName,$destPath)){
                $message = 'File Uploaded';
            }else{
            
                $errorFlag = 1;
                $errorMessage = "Error in Upload Image";
            }
            
        }else{
            $errorFlag = 1;
            $errorMessage = "Error in Image extension ";       
        
        }

        //Check Empty Input
        if(empty($name) || empty($email) || empty($password) || empty($gender) || empty($role)){
            $errorFlag = 1;
            $errorMessage = 'field can not be Empty';
        }elseif(!isset($_FILES['image'])){
            $errorFlag = 1;
            $errorMessage = "Can Not Empty image ";
        }

        //check validate input name
        elseif(filter_var($name, FILTER_VALIDATE_EMAIL) || filter_var($name, FILTER_VALIDATE_INT) || filter_var($name, FILTER_VALIDATE_URL)){
            $errorFlag = 1;
            $errorMessage = 'field must be String';
        }
        //check validate input email
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errorFlag = 1;
            $errorMessage = 'field must be Email';
        }
        //check validate input password
        elseif( strlen($password) < 6  ){
            $errorFlag = 1;
            $errorMessage = "Length must be > 6";
        }
        else{

            $sql    = "update users  set  name ='$name', email = '$email', gender='$gender' ,image = '$oldImage' , id_role = '$role' where id=".$id;
            $op = mysqli_query($con,$sql);
            if($op){
                $message = 'Data Inserted';
                header("Location: displayAccounts.php");

            }else{
        $message = mysqli_error($con);
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
                    
                        <h1 class="mt-4">Add Account</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="../../index.php">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="displayAccounts.php">Admin Accounts</a></li>
                            <li class="breadcrumb-item active">Add Account</li>
                        </ol>
<?php 

if($errorFlag == 1){
    echo $errorMessage;}

?>
                        <div class="card-body">
                            <form  action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $_GET['id']?>">
                                
                                <div class="form-group">
                                    <label class="small mb-1" for="inputNameAdmin"><h4>Name</h4></label>
                                    <input class="form-control py-4"  name="name" value="<?php echo $data['name'];?>" id="inputNameAdmin" type="text" placeholder="Enter Name"  required />
                                    <?php
                                        // if($errorFlag == 1){
                                        //     echo '<label class="small mb-1"><h6>* '.$errorMessage.'</h6></label>';
                                        // }
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label class="small mb-1" for="inputEmailAdmin"><h4>Email</h4></label>
                                    <input class="form-control py-4"  name="email" value="<?php echo $data['email'];?>"  id="inputEmailAdmin" type="email" placeholder="Enter Email"  required />
                                    <?php
                                        // if($errorFlag == 1){
                                        //     echo '<label class="small mb-1"><h6>* '.$errorMessage.'</h6></label>';
                                        // }
                                    ?>
                                </div>
                                
                                <div class="form-group">
                                    <label class="small mb-1" for="inputNameAdmin"><h4>Gender</h4></label>
                                    <select name="gender" value="<?php echo $data[''];?>"  class="custom-select custom-select-lg mb-3">

                                        <option value="male">Male</option>
                                        <option value="female">Female</option> 
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="small mb-1" for="inputNameAdmin"><h4>Picture</h4></label>
                                    <div class="custom-file">
                                        <input type="hidden"  name="oldImage" value="<?php echo $data['image']; ?>">
                                        <input name="image" type="file" class="custom-file-input form-control py-4" id="customFile">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="small mb-1" for="inputNameAdmin"><h4>Role</h4></label>
                                    <select name="role" class="custom-select custom-select-lg mb-3">
                                        <?php

                                            while($table_roles = mysqli_fetch_assoc($roles)){
                                                
                                                ?>
                                        
                                            <option value="<?php echo $data['id'];?>" <?php if($data['id_role']  ==  $table_roles['id'] ){ echo 'selected';}?> > <?php echo $table_roles['role'];?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                    <input type="submit" class="btn btn-primary" value="Save"> 
                                </div>
                            </form>
                        </div>
                        
                    </div>
                </main>
                <?php include '../../includes/layout/footer.php'; ?>
