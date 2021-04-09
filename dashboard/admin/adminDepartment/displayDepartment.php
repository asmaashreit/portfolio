<?php
    require '../../includes/connection.php';
    include '../../includes/helperFunction.php';

    //Select data from table roles
    $sql = "SELECT * FROM department";
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
                        <h1 class="mt-4">Display Departments</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="../../index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Departments</li>
                        </ol>

                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                               Data || <a href="<?php   echo url('admin/adminDepartment/addDepartment.php');  ?> ">add Department</a>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
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
                                                        <td>
                                                            <a href ="#">Delete</a> ||
                                                            <a href ="#">Edit</a></td>
                                                        
                                                    </tr>
                                                <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        
                    </div>
                </main>
                <?php include '../../includes/layout/footer.php'; ?>
