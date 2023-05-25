<?php 
 $uri = "http://".  $_SERVER['SERVER_NAME'] ."/portfolio/admin/";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login | Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link rel="icon" href="assets/images/favicon.ico">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?php echo $uri ?>assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- custom Stylesheet -->
    <link href="<?php echo $uri ?>assets/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5">
                    <form id="login">
                        <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="alert alert-danger" style="display: none;" role="alert" id="alert">
                        Incorrect Email or Password    
                    </div>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <a href="index.html" class="">
                                    <h3 class="text-primary">Sign In</h3>
                                </a>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingInput"
                                    placeholder="name@example.com" name="email">
                                <label for="floatingInput">Email address</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" id="floatingPassword" placeholder="Password"
                                    name="password">
                                <label for="floatingPassword">Password</label>
                            </div>
                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </div>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Template Javascript -->
    <script src="<?php echo $uri ?>assets/js/main.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script>
    $("#login").submit(function(event) {
                event.preventDefault();
                $("#alert").css("display","none");
                $.ajax({
                    type: "POST",
                    url: "./api/process.php",
                    data: "MODE=Signin&" + $("#login").serialize(),
                    success: function(data) {
                        var {Status} = JSON.parse(data) 
                        if(Status == "Success"){
                            window.location.replace("dashboard.php");
                        }else{
                            $("#alert").css("display","block");
                            $("#alert").fadeTo(2000, 500).slideUp(500, function(){
                            $("#alert").slideUp(500);
                        });
                        }
                      
                    }
                });
            })
    </script>
</body>

</html>