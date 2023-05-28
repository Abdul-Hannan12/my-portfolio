<?php include './includes/header.php';

include './api/auth.php';
$auth = new auth();
$trash = $auth->getTrash();
$no=1;

?>

<div class="container-fluid mt-4">
    <div class="row">

        <div class="col-12 px-4">
            <!-- Stock Details -->
            <div class="bg-white rounded p-4">
                <h4 class="title mb-4"> Trash </h4>

                <div class="table-responsive">

                    <table id="zero-config" class="table dt-table-hover " style="width: 100%;">
    
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="d-none">#</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
    
                        <tbody>
                                <?php foreach($trash as $item){ 
                                
                                    $table = $item['table_name'];
                                    $id = $item['item_id'];
                                    
                                    $data = $auth->getitem($table, $id);

                                ?>
                                    <tr >
                                        <th style="vertical-align: middle;" scope="row"> <?php echo $no++ ?> </th>
                                        <td class="d-none"><?php echo $item['tid'] ?></td>
                                        <td style="vertical-align: middle;"><?php echo $data['name'] ?></td>
                                        <td style="vertical-align: middle;"><?php echo ucwords(substr($item['table_name'], 0, -1)) ?></td>
                                        <td style="vertical-align: middle;">
                                            <button class="btn btn-sm btn-info btn_recover"><i class="fas fa-check"></i></button>
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


<?php include './includes/footer.php' ?>

<script>


    $('.table-responsive').on('click','.btn_delete',function () {
        $tr = $(this).closest('tr');
        $td = $tr.children("td")[0];
        $id = $td.innerText;

        swal({
            title: "Are you sure?",
            text: "Do you really want to permanently delete this item?",
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
                        url: "./api/process.php",
                        data:  "MODE=deleteTrash&" + "del="+id,
                        success: function(data) {
                            var { Status } = JSON.parse(data) 
                            if (Status == 'Success'){
                                swal("Item deleted Permanently!", {icon: "success"}).then(()=>{window.location.reload()});
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
                    swal("deletion cancelled!");
                }
            });
});

    $('.table-responsive').on('click','.btn_recover',function () {
        $tr = $(this).closest('tr');
        $td = $tr.children("td")[0];
        $id = $td.innerText;

        swal({
            title: "Are you sure?",
            text: "Do you really want to recover this item?",
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
                        url: "./api/process.php",
                        data:  "MODE=recoverTrash&" + "id="+id,
                        success: function(data) {
                            var { Status } = JSON.parse(data) 
                            if (Status == 'Success'){
                                swal("Item Recovered Successfully!", {icon: "success"}).then(()=>{window.location.reload()});
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
                    swal("recovering cancelled!");
                }
            });
});

</script>
