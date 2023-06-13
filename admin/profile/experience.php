<?php 
include '../includes/header.php';
if(isset($_SESSION['isLoggedIn'])){
    include '../api/auth.php';
    $auth = new auth();
    $experiences = $auth->fetchExperiences();
    $no=1;
}

?>


<div class="container-fluid mt-4">
    <div class="row px-sm-5 px-4">
        <div class="bg-white rounded px-sm-5 px-3 py-4">
            <h4 class="title mb-4"> Experiences </h4>
            <form id="addExperience">
                <div class="row">
                    <div class="col-md-4 col-sm-6 mb-4">
                        <label for="organization" class="form-label">
                            Organization
                        </label>
                        <input type="text" name="organization" id="organization" class="form-control">
                    </div>

                    <div class="col-md-4 col-sm-6 mb-4">
                        <label for="duration" class="form-label">
                            Duration
                        </label>
                        <input type="text" id="duration" name="duration" class="form-control">
                    </div>

                    <div class="col-md-2 col-sm-6 mb-4">
                        <label for="order" class="form-label">
                            Order
                        </label>
                        <input type="number" id="order" name="order" class="form-control">
                    </div>

                    <div class="col-md-4 col-sm-6 mb-4">
                        <label for="desc" class="form-label">
                            Description
                        </label>
                        <textarea class="form-control h-auto" name="desc" id="desc" rows="5"></textarea>
                    </div>

                    <div class="col text-end mt-auto mb-4"> <button class="btn btn-primary"> Add </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-white rounded p-4 mt-4">

                <div class="table-responsive">

                    <table id="zero-config" class="table dt-table-hover " style="width: 100%;">
    
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="d-none">#</th>
                                <th>Organization</th>
                                <th>Duration</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
    
                        <tbody>
                                <?php foreach($experiences as $exp){ ?>
                                    <tr >
                                        <th style="vertical-align: middle;" scope="row"> <?php echo $no++ ?> </th>
                                        <td class="d-none"><?php echo $exp['exid'] ?></td>
                                        <td style="vertical-align: middle;"><?php echo $exp['organization'] ?></td>
                                        <td style="vertical-align: middle;"><?php echo $exp['duration'] ?></td>
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

<div class="modal fade" id="edit" tabindex="-1" aria-labelledby="enrollLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Experience</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        
        <form id="updateExperience">
            <div class="row">
                <div class="col-sm-11 mb-4">
                    <input type="hidden" name="id" id="id">
                    <label for="org" class="form-label">Organization</label>
                    <input type="text" class="form-control" id="org" name="organization">
                </div>
                <div class="col-sm-11 mb-4">
                    <label for="dur" class="form-label">Duration</label>
                    <input type="text" class="form-control" id="dur" name="duration">
                </div>
                <div class="col-sm-11 mb-4">
                    <label for="ord" class="form-label">Order</label>
                    <input type="number" class="form-control" id="ord" name="order">
                </div>
                <div class="col-sm-12 mb-4">
                    <label for="desp" class="form-label">Description</label>
                    <textarea name="desc" rows="5" class="form-control h-auto" id="desp"></textarea>
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

     $("#addExperience").submit(function(e) {
        e.preventDefault();
        if($("#organization").val() == ""){
            alert("Please Enter Organization");
            return;
        }
        else if($("#duration").val() == ""){
            alert("Please Enter Duration");
            return;
        }
        else if($("#order").val() == ""){
            alert("Please Enter Order");
            return;
        }
        else if($("#desc").val() == ""){
            alert("Please Enter Description");
            return;
        }
        else{
            $.ajax({
            type: "POST",
            url: "../api/process.php",
            data:  "MODE=addExperience&" + $("#addExperience").serialize(),
            success: function(data) {
                let { Status } = JSON.parse(data);
                if(Status == "Success"){
                    swal({
                        text: "Experience Added!",
                        icon: 'success'
                    }).then(function() {
                        window.location.reload()
                    })
                }else{
                        swal(
                            'Opss',
                            'Something Went Wrong!',
                            'error'
                        );
                    }
            }
        });
        }
    });

    $('.table-responsive').on('click','.btn_edit',function () {
        $("#edit").modal('show');
        $tr = $(this).closest('tr');
        $td = $tr.children("td")[0];
        $id = $td.innerText;

        $.ajax({
            type: "POST",
            url: "../api/process.php",
            data:  `MODE=getExperience&id=${$id}`,
            success: function(data) {
                var expData = JSON.parse(data);
                if(expData['Status'] != "Error" && expData['exid'] == $id){

                    $('#id').val(expData['exid']);
                    $('#org').val(expData['organization']);
                    $('#dur').val(expData['duration']);
                    $('#ord').val(expData['exp_order']);
                    $('#desp').val(expData['description']);

                }
            }
    });
});

$('.table-responsive').on('click','.btn_delete',function () {
        swal({
            title: "Are you sure?",
            text: "Do you really want to delete this experience",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
                if (willDelete) {
                    $tr = $(this).closest('tr');
                    $td = $tr.children("td")[0];
                    let id = $td.innerText;
                    $.ajax({
                        type: "POST",
                        url: "../api/process.php",
                        data:  "MODE=deleteExperience&id="+id,
                        success: function(data) {
                            var { Status } = JSON.parse(data) 
                            if (Status == 'Success'){
                                swal("Experience has been deleted!", {icon: "success"}).then(()=>{window.location.reload()});
                            }else{
                                swal(
                                    'Opss',
                                    'Something Went Wrong!',
                                    'error'
                                );
                            }
                        }
                    });
                } else {
                    swal("Experience not deleted!");
                }
            });
});

$("#updateExperience").submit(function(event) {
        event.preventDefault();
        $.ajax({
                type: "POST",
                url: "../api/process.php",
                data:  "MODE=updateExperience&" + $("#updateExperience").serialize(),
                success: function(data) {
                    var {Status} = JSON.parse(data)
                            if(Status == "Success"){
                                swal(
                                    'Welldone',
                                    'Experience Updated Successfully!',
                                    'success'
                                ).then(function() {
                                    window.location.reload();
                                });
                            }else{
                                swal(
                                    'Opss',
                                    'Experience Not Updated',
                                    'error'
                                )
                            }
                }
            });
    });

</script>