<?php 
include '../includes/header.php';
if(isset($_SESSION['isLoggedIn'])){
    include '../api/auth.php';
    $auth = new auth();
    $uid = $_SESSION['uid'];
    $user = $auth->fetch_user_profile($uid);
}

?>


<div class="container-fluid mt-4">
    <div class="row px-sm-5 px-4">
        <div class="bg-white rounded px-sm-5 px-3 py-4">
            <h4 class="title mb-4"> Education </h4>
            <form id="addEducation">
                <div class="row">
                    <div class="col-md-4 col-sm-6 mb-4">
                        <label for="institute" class="form-label">
                            Institute
                        </label>
                        <input type="text" name="institute" id="institute" class="form-control" value="<?php echo $user['name']  ?>">
                    </div>

                    <div class="col-md-4 col-sm-6 mb-4">
                        <label for="session" class="form-label">
                            Session
                        </label>
                        <input type="text" id="session" name="session" class="form-control" value="<?php echo $user['email']  ?>">
                    </div>

                    <div class="col-md-2 col-sm-6 mb-4">
                        <label for="order" class="form-label">
                            Order
                        </label>
                        <input type="number" id="order" name="order" class="form-control" value="<?php echo $user['email']  ?>">
                    </div>

                    <div class="col-md-4 col-sm-6 mb-4">
                        <label for="desc" class="form-label">
                            Description
                        </label>
                        <textarea class="form-control h-auto" name="desc" id="desc" rows="5"><?php echo $user['bio'] ?></textarea>
                    </div>

                    <div class="col text-end mt-auto mb-4"> <button class="btn btn-primary"> Update </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>

<?php include '../includes/footer.php' ?>

<script>
     $("#updateProfile").submit(function(e) {
        e.preventDefault();
        if($("#name").val() == ""){
            alert("Please Enter Name");
            return;
        }
        else if($("#email").val() == ""){
            alert("Please Enter Email");
            return;
        }
        else if($("#contact").val() == ""){
            alert("Please Enter Contact Number");
            return;
        }
        else if($("#age").val() == ""){
            alert("Please Enter Age");
            return;
        }
        else if($("#residence").val() == ""){
            alert("Please Enter Residence");
            return;
        }
        else if($("#address").val() == ""){
            alert("Please Enter Address");
            return;
        }
        else if($("#freelance").val() == ""){
            alert("Please Select Freelance Status");
            return;
        }
        else if($("#bio").val() == ""){
            alert("Please Enter Bio");
            return;
        }
        else{
            $.ajax({
            type: "POST",
            url: "../api/process.php",
            data:  "MODE=updateProfile&" + $("#updateProfile").serialize(),
            success: function(data) {
                swal({
                    text: "Profile updated",
                    icon: 'success'
                }).then(function() {
                    window.location.reload()
                })
            }
        });
        }
    });
</script>