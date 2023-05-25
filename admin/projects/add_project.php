<?php include '../includes/header.php' ?>

<!-- Sale & Revenue Start -->
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-sm-11 px-sm-4 mb-5">
            <div class="bg-white rounded px-md-5 px-4 py-4">
                <h4 class="title mb-4"> Stock Managment </h4>

                <form action="" id="addStock">
                    <div class="row">
                        <div class="col-sm-6 mb-4">
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
                            <input type="number" class="form-control" id="price" name="price">
                        </div>
                        <div class="col-sm-6 mb-4">
                            <label for="name" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="qty" name="quantity">
                        </div>
                        <div class="col-sm-6 mb-4">
                            <label for="name" class="form-label">Lot Number</label>
                            <input type="text" class="form-control" id="lot" name="lotnumber">
                        </div>
                        <div class="col-sm-6 mb-4">
                            <label for="name" class="form-label">Description</label>
                            <textarea name="desp" rows="5" class="form-control h-auto" id="desc"></textarea>
                        </div>

                        <div class="text-end"> <input type="submit" class="btn btn-primary" id="addStock" name="addStock"> </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- Sale & Revenue End -->




<?php include '../includes/footer.php' ?>


<script>
     $("#addStock").submit(function(event) {
        event.preventDefault();
        if($("#pname").val() == ""){
            alert("Please Enter Name");
            return
        }else if($("#mcompany").val() == ""){
            alert("Please Enter manafacture company name");
            return
        }else if($("#mdate").val() == ""){
            alert("Please Enter manafacture date");
            return
        }else if($("#edate").val() == ""){
            alert("Please Enter expiy Date");
            return
        }else if($("#price").val() == ""){
            alert("Please Enter price");
            return
        }else if($("#qty").val() == ""){
            alert("Please Enter quantity");
            return
        }else if($("#lot").val() == ""){
            alert("Please Enter lot-Number");
            return
        }else if($("#desc").val() == ""){
            alert("Please Enter description");
            return
        }else{
            $.ajax({
            type: "POST",
            url: "../api/process.php",
            data:  "MODE=addStock&" + $("#addStock").serialize(),
            success: function(data) {
                var {Status} = JSON.parse(data) 
                        if(Status == "Success"){
                            swal(
                            'Welldone',
                            'Stock Added Successfully!',
                            'success'
                            ).then(function() {
                                window.location.reload();
                            });
                           
                        }else{
                            swal(
                            'Opss',
                            'Stock couldn\'t Added Successfully!',
                            'error'
                            )
                        }
            }
        });
        }
    });
</script>
