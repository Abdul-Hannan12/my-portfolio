<?php 
include '../includes/header.php';
if(isset($_SESSION['isLoggedIn'])){
    include '../api/auth.php';
    $data_fetched = new auth();
    $uid = $_SESSION['uid'];
    $user = $data_fetched->fetch_user_profile($uid);
}

?>


<div class="container-fluid mt-4">
    <div class="row px-sm-5 px-4">
        <div class="bg-white rounded px-sm-5 px-3 py-4">
            <form id="updateProfile">
                <div class="row align-items-center">
                    <div class="col-5 col-md-2">
                        <div class="avatar avatar-xl">
                            <img src="https://findmydoctor.pk/asset/home-card-1.png" alt="..."
                                class="avatar-img rounded-circle w-100" style="background: #E4221F;"/>
                        </div>
                    </div>
                    <div class="col">
                        <h6 class="mb-1 text-muted"><?php echo ucwords($_SESSION['username'])?></h6>
                    </div>
                </div>
                <hr class="my-4" />
                <div class="row">
                    <div class="col-md-4 col-sm-6 mb-4">
                        <label for="branch-name" class="form-label">
                            userame
                        </label>
                        <input type="text" name="username" id="username" class="form-control" value="<?php echo $user['username']  ?>">
                    </div>

                    <div class="col-md-4 col-sm-6 mb-4">
                        <label for="branch-name" class="form-label">
                            role
                        </label>
                        <input readonly type="text" class="form-control" 
                            value="<?php 
                                if($user['role'] == 0) {
                                    echo "Super Admin";
                                }elseif($user['role'] == 1){
                                    echo "Branch Manager";
                                }else{ echo "User";}
                            ?>"
                        >
                    </div>

                    <div class="col-md-4 col-sm-6 mb-4">
                        <label for="branch-name" class="form-label">
                            email
                        </label>
                        <input type="email" id="email" name="email" class="form-control" value="<?php echo $user['email']  ?>">
                    </div>

                    <div class="col-md-4 col-sm-6 mb-4">
                        <label for="branch-name" class="form-label">
                            Contact No#
                        </label>
                        <input type="number" id="contact" name="contact" class="form-control" value="<?php echo $user['contact']  ?>">
                    </div>

                    <div class="col-md-4 col-sm-6 mb-4">
                        <label for="branch-name" class="form-label">
                            CNIC
                        </label>
                        <input type="text" id="cnic" name="cnic" disabled class="form-control" value="<?php echo $user['cnic']  ?>">
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
        if($("#username").val() == ""){
            alert("Please Enter username");
            return
        }
        else if($("#email").val() == ""){
            alert("Please Enter email");
            return
        }
        else if($("#contact").val() == ""){
            alert("Please Enter contact");
            return
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