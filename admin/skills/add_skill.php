<?php include '../includes/header.php' ?>

<!-- Sale & Revenue Start -->
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-sm-12 px-sm-4 px-3">
            <div class="bg-white rounded py-4 px-5 ">
                <h4 class="title mb-4">Add New Center</h4>

                <form id="addCenter">
                    <div class="row">
                        <div class="col-sm-4 mb-4">
                            <label for="name" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                        <div class="col-sm-4 mb-4">
                            <label for="name" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" >
                        </div>
                        <div class="col-sm-4 mb-4">
                            <label for="name" class="form-label">Contact No#</label>
                            <input type="text" class="form-control" id="contact" name="contact">
                        </div>
                        <div class="col-sm-4 mb-4">
                            <label for="name" class="form-label">Whatsapp No#</label>
                            <input type="text" class="form-control" id="whatsapp" name="whatsapp">
                        </div>
                        <div class="col-sm-4 mb-4">
                            <label for="name" class="form-label">Center Name</label>
                            <input type="text" class="form-control" id="cname" name="cname" >
                        </div>
                        <div class="col-sm-4 mb-4">
                            <label for="name" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" >
                        </div>

                        <div class="text-end"> <button class="btn btn-primary"> Submit </button> </div>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>
<!-- Sale & Revenue End -->

<?php include '../includes/footer.php' ?>
<script>
     $("#addCenter").submit(function(event) {
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
            data:  "MODE=addCenter&" + $("#addCenter").serialize(),
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
                           
                        }else if (Status == "Found"){
                            swal("Center Already Exists!", "please try to create a center with a different name", "warning")
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