<?php 
include '../includes/header.php';
if(isset($_SESSION['isLoggedIn'])){
    include '../api/auth.php';
    $auth = new auth();
    $educations = $auth->fetchServices();
    $no=1;
}

?>


<div class="container-fluid mt-4">
    <div class="row px-sm-5 px-4">
        <div class="bg-white rounded px-sm-5 px-3 py-4">
            <h4 class="title mb-4"> Serivces </h4>
            <form id="addService">
                <div class="row">
                    <div class="col-md-4 col-sm-6 mb-4">
                        <label for="name" class="form-label">
                            Name
                        </label>
                        <input type="text" name="name" id="name" class="form-control">
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
                                <th>Name</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
    
                        <tbody>
                                <?php foreach($educations as $education){ ?>
                                    <tr >
                                        <th style="vertical-align: middle;" scope="row"> <?php echo $no++ ?> </th>
                                        <td class="d-none"><?php echo $education['sid'] ?></td>
                                        <td style="vertical-align: middle;"><?php echo $education['name'] ?></td>
                                        <td style="vertical-align: middle;"><?php echo $education['description'] ?></td>
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
            <h5 class="modal-title" id="exampleModalLabel">Edit Service</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        
        <form id="updateService">
            <div class="row">
                <div class="col-sm-11 mb-4">
                    <input type="hidden" name="id" id="id">
                    <label for="nam" class="form-label">Institute</label>
                    <input type="text" class="form-control" id="nam" name="name">
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

     $("#addService").submit(function(e) {
        e.preventDefault();
        if($("#name").val() == ""){
            alert("Please Enter Service Name");
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
            data:  "MODE=addService&" + $("#addService").serialize(),
            success: function(data) {
                let { Status } = JSON.parse(data);
                if(Status == "Success"){
                    swal({
                        text: "Service Added!",
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
            data:  `MODE=getService&id=${$id}`,
            success: function(data) {
                var eduData = JSON.parse(data);
                if(eduData['Status'] != "Error" && eduData['sid'] == $id){

                    $('#id').val(eduData['sid']);
                    $('#nam').val(eduData['name']);
                    $('#ord').val(eduData['service_order']);
                    $('#desp').val(eduData['description']);

                }
            }
    });
});

$('.table-responsive').on('click','.btn_delete',function () {
        swal({
            title: "Are you sure?",
            text: "Do you really want to delete this service",
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
                        data:  "MODE=deleteService&id="+id,
                        success: function(data) {
                            var { Status } = JSON.parse(data) 
                            if (Status == 'Success'){
                                swal("Service has been deleted!", {icon: "success"}).then(()=>{window.location.reload()});
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
                    swal("Service not deleted!");
                }
            });
});

$("#updateService").submit(function(event) {
        event.preventDefault();
        $.ajax({
                type: "POST",
                url: "../api/process.php",
                data:  "MODE=updateService&" + $("#updateService").serialize(),
                success: function(data) {
                    var {Status} = JSON.parse(data)
                            if(Status == "Success"){
                                swal(
                                    'Welldone',
                                    'Service Updated Successfully!',
                                    'success'
                                ).then(function() {
                                    window.location.reload();
                                });
                            }else{
                                swal(
                                    'Opss',
                                    'Service Not Updated',
                                    'error'
                                )
                            }
                }
            });
    });

</script>