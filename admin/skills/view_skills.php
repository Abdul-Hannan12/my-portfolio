<?php include '../includes/header.php';

include '../api/auth.php';
$auth = new auth();
$skills = $auth->fetchAllSkills();
$no=1;

?>

<div class="container-fluid mt-4">
    <div class="row">

        <div class="col-12 px-4">
            <!-- Stock Details -->
            <div class="bg-white rounded p-4">
                <h4 class="title mb-4"> All Skills </h4>

                <div class="table-responsive">

                    <table id="zero-config" class="table dt-table-hover " style="width: 100%;">
    
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="d-none">#</th>
                                <th>Name</th>
                                <th>Percent</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
    
                        <tbody>
                                <?php foreach($skills as $skill){ ?>
                                    <tr >
                                        <th style="vertical-align: middle;" scope="row"> <?php echo $no++ ?> </th>
                                        <td class="d-none"><?php echo $skill['sid'] ?></td>
                                        <td style="vertical-align: middle;"><?php echo $skill['name'] ?></td>
                                        <td style="vertical-align: middle;"><?php echo $skill['percent'] ?></td>
                                        <td style="vertical-align: middle;"><?php echo $skill['type'] ?></td>
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
            <h5 class="modal-title" id="exampleModalLabel">Edit Skill</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        
        <form id="updateSkill">
            <div class="row">
                <div class="col-sm-11 mb-4">
                    <input type="hidden" name="id" id="id">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="col-sm-11 mb-4">
                    <label for="percent" class="form-label">Percentage</label>
                    <input type="text" class="form-control" id="percent" name="percent">
                </div>
                <div class="col-sm-12 mb-4">
                    <label for="type" class="form-label">Type</label>
                    <select class="form-select" id="type" name="type">
                        <option value="">Select</option>
                        <option value="coding">Coding Skill</option>
                        <option value="other">Other Skill</option>
                    </select>
                </div>
                <div class="col-sm-12 mb-4">
                    <label for="desc" class="form-label">Description</label>
                    <textarea name="desc" rows="5" class="form-control h-auto" id="desc"></textarea>
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
    
    $('.table-responsive').on('click','.btn_edit',function () {
        $("#edit").modal('show');
        $tr = $(this).closest('tr');
        $td = $tr.children("td")[0];
        $id = $td.innerText;

        $.ajax({
            type: "POST",
            url: "../api/process.php",
            data:  `MODE=getSkill&id=${$id}`,
            success: function(data) {
                var skillData = JSON.parse(data) 
                console.log(skillData);
                if(skillData['Status'] != "Error" && skillData['sid'] == $id){

                    $('#id').val(skillData['sid']);
                    $('#name').val(skillData['name']);
                    $('#percent').val(skillData['percent']);
                    $('#type').val(skillData['type']);
                    $('#desc').val(skillData['description']);

                }
            }
    });
});

    $('.table-responsive').on('click','.btn_delete',function () {
        $tr = $(this).closest('tr');
        $td = $tr.children("td")[0];
        $id = $td.innerText;

        swal({
            title: "Are you sure?",
            text: "Do you really want to delete this skill",
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
                        data:  "MODE=deleteSkill&" + "del="+id,
                        success: function(data) {
                            var { Status } = JSON.parse(data) 
                            if (Status == 'Success'){
                                swal("Skill has been deleted!", {icon: "success"}).then(()=>{window.location.reload()});
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
                    swal("Skill not deleted!");
                }
            });
});

</script>

<script>

    // EDITING DATA
    $("#updateSkill").submit(function(event) {
        event.preventDefault();
        $.ajax({
                type: "POST",
                url: "../api/process.php",
                data:  "MODE=updateSkill&" + $("#updateSkill").serialize(),
                success: function(data) {
                    var {Status} = JSON.parse(data)
                            if(Status == "Success"){
                                swal(
                                    'Welldone',
                                    'Skill Updated Successfully!',
                                    'success'
                                ).then(function() {
                                    window.location.reload();
                                });
                            }else{
                                swal(
                                    'Opss',
                                    'Skill Not Updated',
                                    'error'
                                )
                            }
                }
            });
    });

</script>
