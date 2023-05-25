<?php include '../includes/header.php';

include '../api/auth.php';
$auth = new auth();
$projects = $auth->fetchAllProjects();
$no=1;

?>

<div class="container-fluid mt-4">
    <div class="row">

        <div class="col-12 px-4">
            <!-- Stock Details -->
            <div class="bg-white rounded p-4">
                <h4 class="title mb-4"> All Projects </h4>

                <div class="table-responsive">

                    <table id="zero-config" class="table dt-table-hover " style="width: 100%;">
    
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="d-none">#</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
    
                        <tbody>
                                <?php foreach($projects as $project){ ?>
                                    <tr >
                                        <th style="vertical-align: middle;" scope="row"> <?php echo $no++ ?> </th>
                                        <td class="d-none"><?php echo $project['pid'] ?></td>
                                        <td style="vertical-align: middle;"><img style="width: 40px;" src="../../uploads/<?php echo $project['img'] ?>" alt="project thumbnail"></td>
                                        <td style="vertical-align: middle;"><?php echo $project['name'] ?></td>
                                        <td style="vertical-align: middle;"><?php echo $project['type'] ?></td>
                                        <td style="vertical-align: middle;">
                                            <button class="btn btn-sm btn-info text-white btn_edit"><i class="fas fa-pencil-alt"></i></button>
                                            &nbsp;&nbsp;&nbsp;
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


<div class="modal fade" id="edit" tabindex="-1" aria-labelledby="enrollLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Entertainment</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        
        <form id="editCenter">
            <div class="row">
                <div class="col-sm-6 mb-4">
                    <input type="hidden" name="id" id="id">
                    <label for="name" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username">
                </div>
                <div class="col-sm-6 mb-4">
                    <label for="name" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" >
                </div>
                <div class="col-sm-6 mb-4">
                    <label for="name" class="form-label">Contact No#</label>
                    <input type="text" class="form-control" id="contact" name="contact">
                </div>
                <div class="col-sm-6 mb-4">
                    <label for="name" class="form-label">Whatsapp No#</label>
                    <input type="text" class="form-control" id="whatsapp" name="whatsapp">
                </div>
                <div class="col-sm-6 mb-4">
                    <label for="name" class="form-label">Center Name</label>
                    <input type="text" class="form-control" id="cname" name="cname" >
                </div>
                <div class="col-sm-6 mb-4">
                    <label for="name" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" >
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-warning" value="Update">
            </div>

        </form>
        </div>
    </div>
    </div>


<?php include '../includes/footer.php' ?>

<script>

    // GETTING FORM DATA TO DISPLAY ON EDIT FORM
    $(document).ready(()=>{
        $('.btn_edit').on('click', function(){

            $("#edit").modal('show');

            $tr = $(this).closest('tr');

            var editData = $tr.children("td").map(function(){
                return $(this).text();
            }).get();

            $('#id').val(editData[0]);
            $('#username').val(editData[1]);
            $('#email').val(editData[2]);
            $('#contact').val(editData[3]);
            $('#whatsapp').val(editData[4]);
            $('#cname').val(editData[5]);
            $('#address').val(editData[6]);

        });
    });

    // EDITING DATA
    $("#editCenter").submit(function(event) {
        event.preventDefault();
            $.ajax({
            type: "POST",
            url: "../api/process.php",
            data:  "MODE=editCenter&" + $("#editCenter").serialize(),
            success: function(data) {
                console.log(data);
                window.location.reload();
            }
        });
    });

    // DELETING DATA
    $(document).ready(()=>{
        $('.btn_delete').on('click', function(){

    // SHOWING ALERT FOR DELETING
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this center!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    $tr = $(this).closest('tr');

                        var editData = $tr.children("td").map(function(){
                            return $(this).text();
                        }).get();

                        let id = editData[0];

                        $.ajax({
                            type: "POST",
                            url: "../api/process.php",
                            data:  "MODE=delete_center&" + "delete="+id,
                            success: function(data) {
                                console.log(data);
                                window.location.reload();
                            }
                        });
                    swal("Center has been deleted!", {
                    icon: "success",
                    });

                } else {

                    swal("Center not deleted!");

                }
            });
        });
    });

    

</script>