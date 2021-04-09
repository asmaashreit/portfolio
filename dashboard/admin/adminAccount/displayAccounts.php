<?php
    require '../../includes/connection.php';
    include '../../includes/helperFunction.php';

    //Select data from table users
    if($_SESSION['userData']['id_role'] == 5){
        $sql = "select users.* , roles.role from users join roles on users.id_role = roles.id ";
    }else{
        $sql = "select users.* , roles.role from users join roles on users.id_role = roles.id where roles.id =  ".$_SESSION['userData']['id_role'];

    }
    $op =  mysqli_query($con,$sql);
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
                        <h1 class="mt-4">Display Accounts</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="../../index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Admin Accounts</li>
                        </ol>
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                            Data || <a href="<?php   echo url('admin/adminAccount/addAccount.php');  ?> ">add Account</a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Password</th>
                                            <th>Gender</th>
                                            <th>Image</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            while($data = mysqli_fetch_assoc($op)){
                                                
                                                ?>
                                                <tr>
                                                    <td><?php echo $data['id'];?></td>
                                                    <td><?php echo $data['name'];?></td>
                                                    <td><?php echo $data['email'];?></td>
                                                    <td><?php echo $data['password'];?></td>
                                                    <td><?php echo $data['gender'];?></td>
                                                    <td>   
                                                        <img src="../../uplouds/<?php echo $data['image'];?>" width="50"  height="50" >
                                                        <!-- <img src="../../uplouds/1617841990خمسات.jpg"> -->
                                                    </td>
                                                    <td><?php echo $data['role'];?></td>
                                                    <td>
                                                        <a href ="deleteAccount.php?id=<?php echo $data['id']; ?>">Delete</a> ||
                                                        <a href ="editAccount.php?id=<?php echo $data['id']; ?>">Edit</a></td>
                                                    
                                                </tr>
                                            <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <?php include '../../includes/layout/footer.php'; ?>