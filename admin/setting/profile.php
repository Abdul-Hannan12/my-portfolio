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
            <form id="updateProfile">
                <div class="row align-items-center">
                    <div class="col-5 col-md-2">
                        <div class="avatar avatar-xl">
                            <img src="https://w0.peakpx.com/wallpaper/666/961/HD-wallpaper-anime-jujutsu-kaisen-satoru-gojo.jpg" alt="profile picture"
                                class="avatar-img rounded-circle w-100" style="background: #E4221F; aspect-ratio: 2/2;"/>
                        </div>
                    </div>
                    <div class="col">
                        <h6 class="mb-1 text-muted"><?php echo ucwords($_SESSION['username'])?></h6>
                    </div>
                </div>
                <hr class="my-4" />
                <div class="row">
                    <div class="col-md-4 col-sm-6 mb-4">
                        <label for="name" class="form-label">
                            Name
                        </label>
                        <input type="text" name="name" id="name" class="form-control" value="<?php echo $user['name']  ?>">
                    </div>

                    <div class="col-md-4 col-sm-6 mb-4">
                        <label for="email" class="form-label">
                            Email
                        </label>
                        <input type="email" id="email" name="email" class="form-control" value="<?php echo $user['email']  ?>">
                    </div>

                    <div class="col-md-4 col-sm-6 mb-4">
                        <label for="contact" class="form-label">
                            Contact No#
                        </label>
                        <input type="number" id="contact" name="contact" class="form-control" value="<?php echo $user['contact']  ?>">
                    </div>

                    <div class="col-md-4 col-sm-6 mb-4">
                        <label for="age" class="form-label">
                            Age
                        </label>
                        <input type="number" id="age" name="age" class="form-control" value="<?php echo $user['age']  ?>">
                    </div>

                    <div class="col-md-4 col-sm-6 mb-4">
                        <label for="residence" class="form-label">
                            Residences
                        </label>
                        <input type="text" id="residence" name="residence" class="form-control" value="<?php echo $user['residence']  ?>">
                    </div>

                    <div class="col-md-4 col-sm-6 mb-4">
                        <label for="address" class="form-label">
                            Address
                        </label>
                        <input type="text" id="address" name="address" class="form-control" value="<?php echo $user['address']  ?>">
                    </div>

                    <div class="col-md-4 col-sm-6 mb-4">
                        <label for="freelance" class="form-label">
                            Freelance
                        </label>
                        <select class="form-select" id="freelance" name="freelance">
                            <option value="">Select</option>
                            <option value="1" <?php echo $user['freelance'] == 1 ? 'selected' : '' ?>>Yes</option>
                            <option value="0" <?php echo $user['freelance'] == 0 ? 'selected' : '' ?>>No</option>
                        </select>
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