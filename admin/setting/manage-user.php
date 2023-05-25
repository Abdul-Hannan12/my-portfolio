<?php

include '../includes/header.php';
$role = $_SESSION['role'];
$bid = $_SESSION['bid'];

// if($role != 0 OR $role != 1) {
//     header("Location: ../dashboard.php");
//     exit();
// }

include '../api/auth.php';
$data_fetched = new auth();

$data = $data_fetched->fetch_all_branches();
$no=1;

$all_users = ($role == 0) ? $data_fetched->fetch_all_user() : $data_fetched->fetch_all_branch_users($bid);

?>

<!-- Sale & Revenue Start -->
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-sm-11 px-4 mb-4">
            
            <div class="bg-white rounded px-sm-5 px-3 py-4">
                <h4 class="title mb-4"> Add User </h4>

                <form id="manageUsers">
                    <div class="row">
                        <div class="col-sm-6 col-md-4 mb-4">
                            <label for="branch-name" class="form-label">
                                userame
                            </label>
                            <input type="text" id="name" name="name" class="form-control">
                        </div>

                        <div class="col-sm-6 col-md-4 mb-4">
                            <label for="branch-name" class="form-label">
                                email
                            </label>
                            <input type="email" id="email" name="email" class="form-control">
                        </div>

                        <div class="col-sm-6 col-md-4 mb-4">
                            <label for="branch-name" class="form-label">
                                Password
                            </label>
                            <input type="password" id="password" name="password" class="form-control">
                        </div>

                        <div class="col-sm-6 col-md-4 mb-4">
                            <label for="branch-name" class="form-label">
                                Contact No#
                            </label>
                            <input type="number" id="contact" name="contact" class="form-control">
                        </div>

                        <div class="col-sm-6 col-md-4 mb-4">
                            <label for="branch-name" class="form-label">
                                CNIC
                            </label>
                            <input type="text" id="cnic" name="cnic" class="form-control">
                        </div>

                        <div class="col-sm-6 col-md-4 mb-4">
                            <label for="role" class="form-label"> branch </label>
                            <select class="form-select" name="branch">
                                <option>select</option>
                                <?php if($data) { 
                                    foreach($data as $branch)  {  
                                        if ($role == 0){
                                ?>
                                    <option value="<?php echo $branch['bid'] ?>"><?php echo $branch['branch_name'] ?></option>
                                <?php }else if ($branch['bid'] == $bid){ ?>
                                    <option value="<?php echo $branch['bid'] ?>"><?php echo $branch['branch_name'] ?></option>
                                <?php } } } ?>
                            </select>
                        </div>

                        <div class="col-sm-6 col-md-4 mb-4">
                            <label for="role" class="form-label"> role </label>
                            <select class="form-select" name="role">
                                <option>select</option>
                                <?php if ($role == 0){ ?>
                                    <option value="0">Admin</option>
                                    <option value="1">Manager</option>
                                <?php } ?>
                                <option value="2">Distributor</option>
                            </select>
                        </div>

                        <div class="col text-end mt-auto mb-4"> <button class="btn btn-primary" > Submit </button>
                        </div>
                    </div>
                </form>


            </div>
        </div>

        <div class="col-sm-11 px-4">
            <div class="bg-white rounded px-3 py-5 px-sm-5">
                <div class="table-responsive">
                    <table id="zero-config" class="table dt-table-hover " style="width: 100%;">
                        <h4 class="title mb-4"> User Details </h4>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="d-none">Id</th>
                                <th> Name</th>
                                <th> email </th>
                                <th> contact No </th>
                                <th> CNIC </th>
                                <th> Branch </th>
                                <th> role </th>
                                <th> Actions </th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php 
                            foreach($all_users as $users){ ?>

                            <tr>
                                <th scope="row"><?php echo $no++; ?></th>
                                <td class="d-none"><?php echo $users['id']; ?></td>
                                <td><?php echo $users['username']; ?></td>
                                <td><?php echo $users['email']; ?></td>
                                <td><?php echo $users['contact']; ?></td>
                                <td><?php echo $users['cnic']; ?></td>
                                <td><?php echo $users['branch_name']; ?></td>
                                <td><?php if ($users['role'] == 0){ echo "Admin"; }else { print ($users['role'] == 1) ? "Manager" : "Distributer"; } ?></td>
                                <td>
                                    <button class="btn btn-sm btn-info text-white btn_edit"><i class="fas fa-pencil-alt"></i></button>
                                    <button class="btn btn-sm btn-danger btn_delete"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>

                        <?php } ?>
                        
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- Sale & Revenue End -->

<div class="modal fade" id="edit" tabindex="-1" aria-labelledby="enrollLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            
            <form id="edit_users">
                <input type="hidden" name="id" id="edit_id">
                        <div class="row">
                        <div class="col-6 mb-4">
                            <label class="text-muted">role</label>
                            <h5 id="edit_role"></h5>
                        </div>

                        <div class="col-6 mb-4">
                        <label class="text-muted">branch</label>
                            <h5 id="edit_branch"></h5>
                        </div>
                        </div>
                        

                    <div class="row">
                        <div class="col-12 mb-4">
                            <label for="branch-name" class="form-label">
                                userame
                            </label>
                            <input type="text" id="edit_name" name="name" class="form-control">
                        </div>

                        <div class="col-12 mb-4">
                            <label for="branch-name" class="form-label">
                                email
                            </label>
                            <input type="email" id="edit_email" name="email" class="form-control">
                        </div>

                        <div class="col-12 mb-4">
                            <label for="branch-name" class="form-label">
                                Contact No#
                            </label>
                            <input type="number" id="edit_contact" name="contact" class="form-control">
                        </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <input type="submit" class="btn btn-warning" value="Update">
                            </div>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php' ?>

<script>
     $("#manageUsers").submit(function(event) {
        event.preventDefault();
        if($("#name").val() == ""){
            alert("Please Enter Name");
            return
        }else if($("#email").val() == ""){
            alert("Please Enter Email");
            return
        }else if($("#password").val() == ""){
            alert("Please Enter Password");
            return
        }else if($("#contact").val() == ""){
            alert("Please Enter Contact");
            return
        }else if($("#cnic").val() == ""){
            alert("Please Enter CNIC");
            return
        }else if($("#role").val() == ""){
            alert("Please Enter role");
            return
        }else if($("#branch").val() == ""){
            alert("Please Enter branch");
            return
        }else{
            $.ajax({
            type: "POST",
            url: "../api/process.php",
            data:  "MODE=ManageUsers&" + $("#manageUsers").serialize(),
            success: function(data) {
                var {Status} = JSON.parse(data) 
                        if(Status == "Success"){
                            swal(
                            'Welldone',
                            'User Added Successfully!',
                            'success'
                            ).then(function() {
                                window.location.reload();
                            });
                           
                        }else{
                            swal(
                            'Opss',
                            'Couldn\'t Add User!',
                            'error'
                            )
                        }
            }
        });
        }

    });

    $(document).ready(() => {
        $('.btn_edit').on('click', function () {

            $("#edit").modal('show');

            $tr = $(this).closest('tr');

            var editData = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(editData);

            $('#edit_id').val(editData[0]);
            $('#edit_name').val(editData[1]);
            $('#edit_email').val(editData[2]);
            $('#edit_contact').val(editData[3]);
            $('#edit_branch').text(editData[5]);
            $('#edit_role').text(editData[6]);

        });
    });


    // EDITING DATA
    $("#edit_users").submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "../api/process.php",
            data: "MODE=edit_user&" + $("#edit_users").serialize(),
            success: function (data) {
                console.log(data);
                window.location.reload();
            }
        });
    });

    // DELETING DATA
    $(document).ready(() => {
        $('.btn_delete').on('click', function () {

            // SHOWING ALERT FOR DELETING
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this user!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $tr = $(this).closest('tr');

                        var editData = $tr.children("td").map(function () {
                            return $(this).text();
                        }).get();

                        let id = editData[0];

                        $.ajax({
                            type: "POST",
                            url: "../api/process.php",
                            data: "MODE=delete_user&" + "delete=" + id,
                            success: function (data) {
                                console.log(data);
                                window.location.reload();
                            }
                        });
                        swal("User has been deleted!", {
                            icon: "success",
                        });

                    } else {

                        swal("User not deleted!");

                    }
                });
        });
    });


</script>