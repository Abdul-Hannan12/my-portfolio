<?php include '../includes/header.php' ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-sm-12 px-sm-4 px-3">
            <div class="bg-white rounded py-4 px-5 ">
                <h4 class="title mb-4">Add New Skill</h4>
                <form id="addSkill">
                    <div class="row">
                        <div class="col-sm-4 mb-4">
                            <label for="name" class="form-label">Skill Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="col-sm-4 mb-4">
                            <label for="percent" class="form-label">Percetage</label>
                            <input type="number" class="form-control" id="percent" name="percent" >
                        </div>
                        <div class="col-sm-4 mb-4">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select" id="type" name="type">
                                <option value="">Select</option>
                                <option value="app">Coding Skill</option>
                                <option value="web">Other Skill</option>
                            </select>
                        </div>
                        <div class="col-sm-8 mb-4">
                            <label for="desc" class="form-label">Description</label>
                            <textarea name="desc" rows="5" class="form-control h-auto" id="desc"></textarea>
                        </div>
                        <div class="text-end"> <button class="btn btn-primary"> Submit </button> </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php' ?>
<script>
     $("#addSkill").submit(function(event) {
        event.preventDefault();
        if($("#username").val() == ""){
            alert("Please Enter Name");
            return
        }else if($("#email").val() == ""){
            alert("Please Enter Email");
            return
        }else if($("#contact").val() == ""){
            alert("Please Enter Contact");
            return
        }else if($("#whatsapp").val() == ""){
            alert("Please Enter Whatsapp");
            return
        }else if($("#cname").val() == ""){
            alert("Please Enter Center Name");
            return
        }else if($("#address").val() == ""){
            alert("Please Enter Address");
            return
        }else{
            $.ajax({
            type: "POST",
            url: "../api/process.php",
            data:  "MODE=addSkil&" + $("#addSkill").serialize(),
            success: function(data) {
                var {Status} = JSON.parse(data) 
                        if(Status == "Success"){
                            swal(
                                'Welldone',
                                'Center Added Successfully!',
                                'success'
                            ).then(function() {
                                window.location.reload();
                            });
                        }else{
                            swal(
                                'Opss',
                                'Couldn\'t Add Center!',
                                'error'
                            )
                        }
            }
        });
        }

    });

</script>