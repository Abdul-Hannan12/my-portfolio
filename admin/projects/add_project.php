<?php include '../includes/header.php' ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-sm-11 px-sm-4 mb-5">
            <div class="bg-white rounded px-md-5 px-4 py-4">
                <h4 class="title mb-4"> Add Project </h4>

                <form method="POST" action="../api/process.php" id="addProject" enctype="multipart/form-data">
                    <div class="row">

                        <div class="col-sm-12 mb-4">
                            <!-- Uploaded image area-->
                            <img id="imageResult" src="#" alt="" class="img-fluid rounded shadow-sm mx-auto d-block w-25">
                            <!-- Image Upload Input -->
                            <div class="col-sm-12 mt-4">
                                <input type="file" id="img" name="img" class="form-control" onchange="readURL(this);">
                            </div>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <label for="pname" class="form-label">Project name</label>
                            <input type="text" class="form-control" id="pname" name="pname">
                        </div>
                        <div class="col-sm-6 mb-4">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select" id="type" name="type">
                                <option value="">Select</option>
                                <option value="app">App</option>
                                <option value="web">Web</option>
                                <option value="design">Design</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-sm-6 mb-4" id="urlDiv">
                            <label for="url" class="form-label">Url</label>
                            <input type="text" class="form-control" id="url" name="url">
                        </div>
                        <div class="col-sm-6 mb-4">
                            <label for="desc" class="form-label">Description</label>
                            <textarea name="desc" rows="5" class="form-control h-auto" id="desc"></textarea>
                        </div>

                        <input type="hidden" name="MODE" value="addProject">

                        <div class="text-end"> <input type="submit" class="btn btn-primary" id="addProject" name="addProject"> </div>
                        
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<?php include '../includes/footer.php' ?>

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

$("#urlDiv").hide();

$("#type").change(function(e){
    if(e.target.value == 'web' || e.target.value == 'other'){
        $("#urlDiv").show();
    }else{
        $("#urlDiv").hide();
    }
});

</script>

<script>

$('#addProject').ajaxForm(function(result) {
        if($("#img").val() == ""){
            alert("Please Upload an Image");
            return;
        }else if($("#pname").val() == ""){
            alert("Please Enter Project Name");
            return;
        }else if($("#type").val() == ""){
            alert("Please Enter Type");
            return;
        }else if (($("#type").val() == 'web' || $("#type").val() == 'other') && ($("#url").val() == "")){
            alert("Please Enter Url");
            return;
        }else if($("#desc").val() == ""){
            alert("Please Enter description");
            return;
        }else{
            var {Status} = JSON.parse(result) 
                if(Status == "Success"){
                    swal(
                    'Welldone',
                    'Project Added Successfully!',
                    'success'
                    ).then(function() {
                        window.location.reload();
                    });
                    
                }else{
                    swal(
                    'Opss',
                    'Project couldn\'t be Added',
                    'error'
                )
            }
        }
        
    });
    
</script>
