<?php 
include '../includes/header.php';

include '../api/auth.php';
$data_fetched = new auth();

if($_SESSION['role'] != 0) {
    header("Location: ../dashboard.php");
}

// only users not manager or super admin for selection of Branch head person.
$user = '2';
$data = $data_fetched->fetch_user_by_roleBrnach($user);
?>

<!-- Sale & Revenue Start -->
<div class="container-fluid mt-4">
<div class="row">
    <div class="col-11 px-sm-4 px-2">
            <div class="bg-white rounded px-sm-5 px-4 py-4">
                <h4 class="title mb-4"> Add Branch </h4>

                <form id="addBranch">
                    <div class="row">
                        <div class="col-sm-6 col-md-4 mb-4">
                            <label for="branch_name" class="form-label">
                                Branch name
                            </label>
                            <input type="text" class="form-control" name="branch_name" id="branch_name">
                        </div>

                        <div class="col-sm-6 col-md-4 mb-4">
                            <label for="branch_city" class="form-label">
                                Branch city
                            </label>
                            <input type="text" class="form-control" name="branch_city" id="branch_city">
                        </div>
                        <div class="col-sm-6 col-md-4 mb-4">
                            <label for="branch_head_person" class="form-label">
                                Branch Head Person
                            </label>
                            
                                <select class="form-select" name="branch_head_person" id="branch_head_person">
                                    <option selected>select</option>
                                    <?php if($data) { 
                                        foreach($data as $user)  {  
                                    ?>
                                        <option value="<?php echo $user['uid'] ?>"><?php echo $user['username'] ?></option>
                                    <?php } } ?>
                                </select>
                        </div>

                        <div class="col text-end mt-auto mb-4"> <button class="btn btn-primary"> Submit </button> </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- Sale & Revenue End -->

<?php include '../includes/footer.php' ?>

<script>
     $("#addBranch").submit(function(event) {
        event.preventDefault();
        if($("#branch_name").val() == ""){
            alert("Please Enter Branch Name");
            return
        }else if($("#branch_city").val() == ""){
            alert("Please Enter Branch City");
            return
        }else if($("#branch_head_person").val() == ""){
            alert("Please Enter Branch Head Person");
            return
        }else{
            $.ajax({
            type: "POST",
            url: "../api/process.php",
            data:  "MODE=addBranch&" + $("#addBranch").serialize(),
            success: function(data) {
                var {Status} = JSON.parse(data) 
                        if(Status == "Success"){
                            swal(
                            'Welldone',
                            'Branch Added Successfully!',
                            'success'
                            ).then(function() {
                                window.location.reload();
                            });
                           
                        }else{
                            swal(
                            'Opss',
                            'Couldn\'t Add Branch!',
                            'error'
                            )
                        }
            }
        });
        }
    });
</script>