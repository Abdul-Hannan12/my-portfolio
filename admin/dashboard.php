<?php 
include './includes/header.php';
include './api/auth.php';
$data_fetched = new auth();
$role = $_SESSION['role'];
$bid = $_SESSION['bid'];

$no=1;
$centers = ($role == 0) ?  $data_fetched->total_Centers() : $data_fetched->total_Centers_branch($bid);
$TotalConsignment = ($role == 0) ?  $data_fetched->total_Consignment() : $data_fetched->total_Consignment_branch($bid);
$RecoveredConsignment = ($role == 0) ?  $data_fetched->total_Consignment_recoverd() : $data_fetched->total_Consignment_recoverd_branch($bid);
$Entertainments = ($role == 0) ?  $data_fetched->total_Entertainments() : $data_fetched->total_Entertainments_branch($bid);
$EntertainmentsSchedule = ($role == 0) ?  $data_fetched->display_entertainments() : $data_fetched->display_entertainments_branch($bid);
$Expiry = ($role == 0) ?  $data_fetched->Expiry() : $data_fetched->Expiry_branch($bid);

?>

<!-- Sale & Revenue Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light h-100 rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-line fa-3x text-primary"></i>
                <div class="ms-3 text-end">
                    <p class="mb-2">Today Centers</p>
                    <h6 class="mb-0"><?php echo $centers;?></h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light h-100 rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-bar fa-3x text-primary"></i>
                <div class="ms-3 text-end">
                    <p class="mb-2">Total Consignment</p>
                    <h6 class="mb-0"><?php echo $TotalConsignment;?></h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light h-100 rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-area fa-3x text-primary"></i>
                <div class="ms-3 text-end">
                    <p class="mb-2">Recived Consignment</p>
                    <h6 class="mb-0">PKR <?php echo $RecoveredConsignment['totalpaid'];?></h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light h-100 rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-pie fa-3x text-primary"></i>
                <div class="ms-3 text-end">
                    <p class="mb-2">Total Entertainments</p>
                    <h6 class="mb-0"><?php echo $Entertainments;?></h6>
                </div>
            </div>
        </div>
    </div>
    <div class="row ">    
        <div class="col-sm-12 col-xl-6  mt-5 bg-light p-3">
            
            <h5>Upcoming Events</h5>
            <div class="col-sm-12 col-xl-12 mt-4">
                <?php 
                foreach($EntertainmentsSchedule as $each){
                    ?>
                    <div class="alert alert-primary" role="alert">
                    You have a Sheduled Entertiment with <?php echo $each ['person']?>  from branch <?php echo $each ['branch_name']?> today.
                </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6  mt-5 bg-light p-3">
            
            <h5>Upcoming Expires</h5>
            <div class="col-sm-12 col-xl-12 mt-4">
                <?php 
                foreach($Expiry as $each){
                    ?>
                    <div class="alert alert-danger" role="alert">
                    You have a Product <?php echo $each ['pname']?>  from branch <?php echo $each ['branch_name']?> Expiring one <?php echo $each ['edate']?>.
                </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    
</div>
<!-- Sale & Revenue End -->

<?php include './includes/footer.php' ?>