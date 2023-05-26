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
                                        <td style="vertical-align: middle;"><img style="width: 40px;" src="../../assets/images/projects/<?php echo $project['type'].'/'.$project['img']; ?>" alt="project thumbnail"></td>
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
            <h5 class="modal-title" id="exampleModalLabel">Edit Project</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        
        <form id="editProject" method="POST" action="../api/process.php" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-12 mb-4 d-flex">
                    <img id="imageResult" style="max-width: 100%; height: 15rem;" class="mx-auto" alt="project thumbnail">
                </div>
                <div class="col-sm-12 mb-4 d-flex">
                    <input type="file" id="img" name="img" class="form-control" onchange="readURL(this);">
                </div>
                <div class="col-sm-11 mb-4">
                    <input type="hidden" name="id" id="id">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title">
                </div>
                <div class="col-sm-12 mb-4">
                    <label for="name" class="form-label">Type</label>
                    <select class="form-select" id="type" name="type">
                        <option value="">Select</option>
                        <option value="app">App</option>
                        <option value="web">Web</option>
                        <option value="design">Design</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="col-sm-12 mb-4" id="urlDiv">
                    <label for="name" class="form-label">Url</label>
                    <input type="text" class="form-control" id="url" name="url">
                </div>
                <input type="hidden" name="MODE" value="updateProject">
                <div class="col-sm-12 mb-4">
                    <label for="name" class="form-label">Description</label>
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
        data:  `MODE=getProject&pid=${$id}`,
        success: function(data) {
            var projectData = JSON.parse(data) 
            if(projectData['Status'] != "Error" && projectData['pid'] == $id){

                if (projectData['type'] != 'web' && projectData['type'] != 'other'){
                    $("#urlDiv").hide();
                }else{
                    $("#urlDiv").show();
                }

                $('#imageResult').attr('src', `../../assets/images/projects/${projectData['type']}/${projectData['img']}`);
                $('#id').val(projectData['pid']);
                $('#title').val(projectData['name']);
                $('#type').val(projectData['type']);
                $('#url').val(projectData['url']);
                $('#desc').val(projectData['description']);
                
                $("#type").change(function(e){
                    if(e.target.value == 'web' || e.target.value == 'other'){
                        $("#urlDiv").show();
                        $('#url').val(projectData['url']);
                    }else{
                        $("#urlDiv").val("");
                        $("#urlDiv").hide();
                    }
                });
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
            text: "Do you really want to delete this project",
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
                        data:  "MODE=deleteProject&" + "del="+id,
                        success: function(data) {
                            var { Status } = JSON.parse(data) 
                            if (Status == 'Success'){
                                swal("Project has been deleted!", {icon: "success"}).then(()=>{window.location.reload()});
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
                    swal("Project not deleted!");
                }
            });
});

</script>

<script>

    function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imageResult')
                .attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

    $(function () {
        $('#img').on('change', function () {
            readURL(input);
        });
    });

</script>

<script>

    // EDITING DATA
    $('#editProject').ajaxForm(function(result) {
            var {Status} = JSON.parse(result) 
                if(Status == "Success"){
                    swal(
                    'Welldone',
                    'Project Updated Successfully!',
                    'success'
                    ).then(function() {
                        window.location.reload();
                    });
                    
                }else{
                    swal(
                    'Opss',
                    'Project couldn\'t be Updated',
                    'error'
                )
            }
    });

</script>
