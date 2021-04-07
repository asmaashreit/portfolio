<?php
    require '../../includes/connection.php';
    include '../../includes/helperFunction.php';

    //Select data from table roles
    $sql = "SELECT * FROM roles";
    $op = mysqli_query($con,$sql);
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
                        <h1 class="mt-4">Display Roles</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="../../index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Admin Roles</li>
                        </ol>

                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                               Data || <a href="<?php   echo url('admin/adminRoles/addRole.php');  ?> ">addRole</a>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>ID</th>
                                                <th>Action</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 0;
                                                while($data = mysqli_fetch_assoc($op)){
                                                    $i++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i;?></td>
                                                        <td><?php echo $data['role'];?></td>
                                                        <td><?php echo $data['id'];?></td>
                                                        <td>
                                                            <a href ="deleteRole.php?id=<?php echo $data['id']; ?>">Delete</a> ||
                                                            <a href ="editRole.php?id=<?php echo $data['id']; ?>?role=<?php $_SESSION['role']=$data['role']; echo $_SESSION['role']; ?>">Edit</a></td>
                                                        
                                                    </tr>
                                                <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        
                    </div>
                </main>
                <?php include '../../includes/layout/footer.php'; ?>
