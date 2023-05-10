<!DOCTYPE html>
<html lang="en">
<head>
    <!-- This was made by Dinh Pham
         Last Change: August 1st, 2022-->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <!-- BootStrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">    
    
    <!-- CSS files -->
    <link rel="stylesheet" href="../login//css/login.css">

    <!-- JavaScript FIles -->
    <script src="../login/js/login.js"></script>

</head>
<body>
    <!-- Header -->
    <header>
        <div class="container-fluid d-flex justify-content-between bg-dark fw-bold" id="header">
            <a class="navbar-brand ms-5" href="#" id="h_logo">
                <img src="../login/html/logo.png" alt="logo" class="rounded-circle bg-warning" id="logo">
            </a>
            <h1 class="h1 text-light pe-5">Groot</h1>
            <a href="./index.php" class="nav-link link-light p-auto mt-3 h-50" id="login">Login</a>
        </div>
    </header>
    <main>

        <div class="container-fluid d-flex justify-content-center mt-5">
            <hr>
            <h5 class="h5" style="color: gray;">
                Login
            </h5>
            <hr>
        </div>
        <!-- Login Form -->
        <div class="container-fluid d-flex justify-content-center fw-bold" id="login-form">  
            <form action="../login/php/login.php" method="post">
                <div class="mb-3 mt-5">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" name="username" required pattern="[A-Z a-z 0-9]+{8,15}" required title="Min-length is 8! No Special Characters allowed!">
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control" id="password" name="password" required pattern="(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*]).{8,20}">
                  <div class="container d-flex justify-content-center">
                    <button type="button" class="form-control btn btn-warning w-100 mt-3 fw-bold" onclick="showPassWord();" id="showPass">Show Password</button>
                    </div>
                </div>
                <div class="mb-3 form-check d-flex gap-2 justify-content-center">
                    <input type="checkbox" class="form-check-input" id="checkBox">
                    <label class="form-check-label" for="checkBox" id="checkBoxLabel">Remember Me</label>
                </div>
                <div class="container-fluid d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary mb-5" id="submit" name="submit">Login</button>
                </div>
              </form>
        </div>

        <!--  -->
        <div class="container-fluid d-flex justify-content-center mt-5">
            <hr>
            <h5 class="h5" style="color: gray;">
                Haven't Registered Account Yet?
            </h5>
            <hr>
        </div>


        <!-- Register Different Accounts  -->
        <div class="container-fluid d-flex flex-column w-25 gap-3 justify-content-center mb-3" id="category">
            <button type="button" class="btn btn-warning"> <a href="../login/html/customer.html" class="link link-primary">Create New Customer Account</a></button>
            <button type="button" class="btn btn-success"> <a href="../login/html/vendor.html" class="link link-light">Create New Vendor Account</a></button>
            <button type="button" class="btn btn-info"> <a href="../login/html/shipper.html" class="link link-primary">Create New Shipper Account</a></button>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container-fluid position-relative bg-dark mt-auto" id="footer">
            <div class="navbar d-flex flex-column">
                <ul class="nav d-flex fw-bold">
                    <li class="nav-item">
                        <a href="../static/about.html" class="nav-link link-light">About</a>
                    </li>
                    <li class="nav-item">
                        <a href="../static/copyright.html" class="nav-link link-light">Copyright</a>
                    </li>
                    <li class="nav-item">
                        <a href="../static/privacy.html" class="nav-link link-light">Privacy</a>
                    </li>
                    <li class="nav-item">
                        <a href="../static/help.html" class="nav-link link-light">Help Links</a>
                    </li>
                </ul>
            </div>
        </div>
    </footer>
</body>
</html>