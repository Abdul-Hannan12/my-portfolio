<?php include '../includes/header.php';
include '../api/auth.php';
$data_fetched = new auth();
$role = $_SESSION['role'];
$bid = $_SESSION['bid'];
date_default_timezone_set("Asia/Karachi");
$Short = date('Y'); 
$Expiry = date('Y', strtotime('+3 years'));
$data  = ($role == 0) ?  $data_fetched->fetch_stocks() : $data_fetched->fetch_stocks_by_branch($bid);


$no=1;
?>


<div class="container-fluid mt-4">
    <div class="row">

        <div class="col-12 px-sm-4 px-1">
            <!-- Stock Details -->
            <div class="bg-white rounded p-sm-4 px-2">
                <h4 class="title mb-4"> Stock Managment Details </h4>

                <div class="table-responsive">
                    <style>
                        .short td{
                            color: white !important;
                        }
                    </style>
                    <table id="zero-config" class="table dt-table-hover " style="width: 100%;">
    
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="d-none">#</th>
                                <th> Name</th>
                                <th> Company</th>
                                <th>Manufacturing date</th>
                                <th>Expiry date</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Branch</th>
                                <th>lot number</th>
                                <th style="width: 160px"> Description</th>

                                <?php if ($role != 2){ ?><th style="width: 100px">Action</th><?php } ?>


                            </tr>
                        </thead>
    
                        <tbody>
                        

                        <?php foreach($data as $stock) {?>
                                    
                            <tr <?php
                                $datetime = new DateTime($stock['edate']);
                                $e = $datetime->format('Y');
                                if( $e <= $Short ){
                                    echo "class='bg-danger short'";
                                }elseif($e <= $Expiry ){
                                    echo "class='bg-warning expiry '";
                                }
                                
                                ?>>
                                <td scope="row"> <?php echo $no++; ?> </td>
                                <td class="d-none"> <?php echo $stock['pid'] ?> </td>  
                                <td> <?php echo $stock['pname'] ?> </td>
                                <td> <?php echo $stock['mcompany'] ?> </td>
                                <td> <?php echo $stock['mdate'] ?> </td>
                                <td> <?php echo $stock['edate'] ?> </td>
                                <td> <?php echo $stock['price'] ?> </td>
                                <td> <?php echo $stock['quantity'] ?> </td>
                                <td> <?php echo $stock['branch_name'] ?> </td>
                                <td> <?php echo $stock['lotnumber'] ?> </td>
                                <td> <?php echo $stock['desp'] ?> </td>
                                <?php if ($role != 2){ ?>
                                    <td>
                                        <button class="btn btn-info text-white btn_edit"><i class="fas fa-pencil-alt"></i></button>
                                        <button class="btn btn-sm btn-danger btn_delete"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                <?php } ?>
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
            <h5 class="modal-title" id="exampleModalLabel">Edit Stock</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        
        <form id="edit_stock" >
        <div class="row">
                        <div class="col-sm-6 mb-4">
                            <input type="hidden" name="id" id="id" >
                            <label for="name" class="form-label">Product name</label>
                            <input type="text" class="form-control" id="pname" name="pname">
                        </div>
                        <div class="col-sm-6 mb-4">
                            <label for="name" class="form-label">Manufacturing Company</label>
                            <input type="text" class="form-control" id="mcompany" name="mcompany">
                        </div>
                        <div class="col-sm-6 mb-4">
                            <label for="name" class="form-label">Manufacturing Date</label>
                            <input type="date" class="form-control" id="mdate" name="mdate">
                        </div>
                        <div class="col-sm-6 mb-4">
                            <label for="name" class="form-label">Expiry Date</label>
                            <input type="date" class="form-control" id="edate" name="edate">
                        </div>
                        <div class="col-sm-6 mb-4">
                            <label for="name" class="form-label">Price</label>
                            <input type="text" class="form-control" id="price" name="price">
                        </div>
                        <div class="col-sm-6 mb-4">
                            <label for="name" class="form-label">Quantity</label>
                            <input type="text" class="form-control" id="qty" name="quantity">
                        </div>
                        <div class="col-sm-6 mb-4">
                            <label for="name" class="form-label">Lot Number</label>
                            <input type="text" class="form-control" id="lot" name="lotnumber">
                        </div>
                        <div class="col-sm-6 mb-4">
                            <label for="name" class="form-label">Description</label>
                            <textarea name="desp" rows="5" class="form-control h-auto" id="desc"></textarea>
                        </div>
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

            $('#id').val(editData[1]);
            $('#pname').val(editData[2]);
            $('#mcompany').val(editData[3]);
            $('#mdate').val(editData[4].trim(' '));
            $('#edate').val(editData[5].trim(' '));
            $('#price').val(editData[6]);
            $('#qty').val(editData[7]);
            $('#lot').val(editData[9]);
            $('#desc').val(editData[10]);

            console.log(editData);
            exit();
            
        });
    });

    // EDITING DATA
    $("#edit_stock").submit(function(event) {
        event.preventDefault();
            $.ajax({
            type: "POST",
            url: "../api/process.php",
            data:  "MODE=edit_stock&" + $("#edit_stock").serialize(),
            success: function(data) {
                // console.log(data);
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
        text: "Once deleted, you will not be able to recover this Stock!",
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

                        let id = editData[1];

                        $.ajax({
                            type: "POST",
                            url: "../api/process.php",
                            data:  "MODE=delete_stock&" + "delete="+id,
                            success: function(data) {
                                console.log(data);
                                window.location.reload();
                            }
                        });
                    swal("Stock has been deleted!", {
                    icon: "success",
                    });

                } else {

            swal("Stock not deleted!");

                }
            });
        });
    });



</script>