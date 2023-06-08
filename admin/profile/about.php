<?php 
include '../includes/header.php';
if(isset($_SESSION['isLoggedIn'])){
    include '../api/auth.php';
    $auth = new auth();
    $uid = $_SESSION['uid'];
    $about = $auth->fetchAboutParas($uid);
}

?>


<div class="container-fluid mt-4">
    <div class="row px-sm-5 px-4">
        <div class="bg-white rounded px-sm-5 px-3 py-4">

            <h4 class="title mb-4"> About Me </h4>

            <div class="row">
                <form id="addPara">
                    <div class="row">
                        <div class="col-md-8 col-sm-6 mb-4">
                            <label for="para" class="form-label">
                                Paragraph
                            </label>
                            <textarea name="para" rows="3" class="form-control h-auto" id="para" placeholder="Text Here ..."></textarea>
                        </div>

                        <div class="col-md-2 col-sm-6 mb-4">
                            <label for="order" class="form-label">
                                Order
                            </label>
                            <input type="number" name="order" id="order" class="form-control">
                        </div>

                        <div class="col-md-2 col-sm-6 mb-4">
                            <label for="length" class="form-label">
                                Length
                            </label>
                            <select class="form-select" id="length" name="length">
                                <option value="">Select</option>
                                <option value="0">Half</option>
                                <option value="1">Full</option>
                            </select>
                        </div>

                        <div class="col text-end mt-auto mb-4"> <button class="btn btn-primary px-4"> Add </button>

                        </div>
                    </div>
                </form>

                <hr class="my-4" />
                
                <?php foreach($about as $para){ ?>
                    
                    <form id="updatePara<?php echo $para['aid'] ?>">
                            <div class="row d-flex align-items-center">

                                <input type="hidden" name="id" value="<?php echo $para['aid'] ?>">

                                <div class="col-sm-6 mb-4">
                                    <label for="para" class="form-label">Para <?php echo $para['about_order'] ?></label>
                                    <textarea name="para" rows="5" class="form-control h-auto" id="para"><?php echo $para['para'] ?></textarea>
                                </div>

                                <div class="col-md-2 col-sm-6 mb-4">
                                    <label for="order" class="form-label">
                                        Order
                                    </label>
                                    <input type="number" name="order" id="order" class="form-control" value="<?php echo $para['about_order'] ?>">
                                </div>

                                <div class="col-md-2 col-sm-6 mb-4">
                                    <label for="length" class="form-label">
                                        Length
                                    </label>
                                    <select class="form-select" id="length" name="length">
                                        <option value="">Select</option>
                                        <option value="0" <?php echo $para['length'] == 0 ? 'selected' : '' ?>>Half</option>
                                        <option value="1" <?php echo $para['length'] == 1 ? 'selected' : '' ?>>Full</option>
                                    </select>
                                </div>

                                <div class="col-md-2 col-sm-6 d-flex align-items-center justify-content-center">
                                    <button class="btn btn-sm btn-info text-white btn_edit"><i class="fas fa-check"></i></button>
                                    &nbsp;&nbsp;&nbsp;
                                    <button class="btn btn-sm btn-danger btn_delete"><i class="fas fa-trash-alt"></i></button>
                                </div>

                            </div>

                        </form>

                    <?php } ?>
            </div>

        </div>

    </div>
</div>

<?php include '../includes/footer.php' ?>

<script>
     $("#addPara").submit(function(e) {
        e.preventDefault();
        if($("#para").val() == ""){
            alert("Please Enter Paragraph Content");
            return;
        }
        else if($("#order").val() == ""){
            alert("Please Enter The order of Paragraph");
            return;
        }
        else if($("#length").val() == ""){
            alert("Please Enter Paragraph Length");
            return;
        }
        else{
            $.ajax({
            type: "POST",
            url: "../api/process.php",
            data:  "MODE=addParagraph&" + $("#addPara").serialize(),
            success: function(data) {
                let { Status } = JSON.parse(data);
                if(Status == "Success"){    
                    swal({
                        text: "Paragraph Added",
                        icon: 'success'
                    }).then(function() {
                        window.location.reload()
                    })
                }else{
                    swal(
                        'Opss',
                        'Something Went Wrong',
                        'error'
                    );
                }
            }
        });
        }
    });

    $('.btn_edit').on('click',function (e) {
        e.preventDefault();

        $form = $(this).closest('form');
        $row = $form.children(':first');
        $idInput = $row.children(':first');
        $id = $idInput.val();

        let formId = `updatePara${$id}`;

        $.ajax({
            type: "POST",
            url: "../api/process.php",
            data:  "MODE=updateAbout&" + $(`#${formId}`).serialize(),
            success: function(data) {
                var { Status } = JSON.parse(data) 
                if (Status == 'Success'){
                    swal("Paragraph Updated!", {icon: "success"}).then(()=>{window.location.reload()});
                }else{
                    swal(
                        'Opss',
                        'Something Went Wrong!',
                        'error'
                    );
                }
            }
        });

});

$('.btn_delete').on('click',function (e) {
    e.preventDefault();

    $form = $(this).closest('form');
    $row = $form.children(':first');
    $idInput = $row.children(':first');
    $id = $idInput.val();

    swal({
        title: "Are you sure?",
        text: "Do you really want to delete this paragraph?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {

        if(willDelete){
            $.ajax({
                type: "POST",
                url: "../api/process.php",
                data:  "MODE=deleteAbout&" + `id=${$id}`,
                success: function(data) {
                    var { Status } = JSON.parse(data) 
                    if (Status == 'Success'){
                        swal("Paragraph Deleted!", {icon: "success"}).then(()=>{window.location.reload()});
                    }else{
                        swal(
                            'Opss',
                            'Something Went Wrong!',
                            'error'
                        );
                    }
                }
            });
        }else{
            swal("Paragraph not deleted")
        }
    
    });
});

</script>


