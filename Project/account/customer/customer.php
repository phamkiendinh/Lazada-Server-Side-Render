<?php session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
} else {
    header('Location: ../../www/index.php');
    exit;
}

function logOut()
{
    session_destroy();
    header('Location: ../../www/index.php');
}

if (array_key_exists('logout', $_POST)) {
    logOut();
}


// Obtain User Information
$file = fopen("../../../Project/account.db", "r") or die("Unable to open file!");
$data = $temp = '';
$type = $username = '';
while (!feof($file)) {
    $line = fgets($file);
    $temp = $line;
    // Category of the account, if it is customer then start extract data process
    for ($i = 1; $i < 3; $i++) {
        $pos = strpos($line, '|');
        $sub_str = substr($line, 0, $pos);
        $line = substr($line, $pos + 1, strlen($line) - 1);
        switch ($i) {
            case 1:
                $type = $sub_str;
                break;
            case 2:
                $username = $sub_str;
                break;
        }
    }
    if ($username == $_SESSION['username']) {
        $data = $temp;
        break;
    }
}
fclose($file);

$_SESSION['type'] = $type;

//Load Existing Profile Picture
$file = fopen("../../../Project/account.db", "r") or die("Unable to open file!");
$file_path = '';
$data_line = $replace_line = $current_line = $type = $username = '';
while (!feof($file)) {
    $line = fgets($file);
    $temp = $line;
    $current_line = '';
    if ($_SESSION['type'] == 'shipper') {
        for ($i = 1; $i < 6; $i++) {
            $pos = strpos($line, '|');
            $sub_str = substr($line, 0, $pos);
            $line = substr($line, $pos + 1, strlen($line) - 1);
            $current_line = $current_line . $sub_str . '|';
            switch ($i) {
                case 1:
                    $type = $sub_str;
                    break;
                case 2:
                    $username = $sub_str;
                    break;
                case 4:
                    if ($username == $_SESSION['username']) {
                        $replace_line = $current_line;
                    }
                    break;

                case 5:
                    if ($username == $_SESSION['username']) {
                        $data_line = $temp;
                        $file_path = $sub_str;
                    }
                    break;
            }
        }
    } else {
        // Category of the account, if it is customer then start extract data process
        for ($i = 1; $i < 7; $i++) {
            $pos = strpos($line, '|');
            $sub_str = substr($line, 0, $pos);
            $line = substr($line, $pos + 1, strlen($line) - 1);
            $current_line = $current_line . $sub_str . '|';
            switch ($i) {
                case 1:
                    $type = $sub_str;
                    break;
                case 2:
                    $username = $sub_str;
                    break;
                case 5:
                    if ($username == $_SESSION['username']) {
                        $replace_line = $current_line;
                    }
                    break;

                case 6:
                    if ($username == $_SESSION['username']) {
                        $data_line = $temp;
                        $file_path = $sub_str;
                    }
                    break;
            }
        }
    }
}
fclose($file);

$_SESSION['file-path'] = $file_path;


//Check For New Profile Uploads
if (isset($_POST["submit"])) {
    $info = pathinfo($_FILES['new-profile']['name']);
    $ext = $info['extension']; // get the extension of the file
    $newname = $info['filename'] . '.' . $ext;


    $target = '../../login/uploads/' . $newname;
    $replace_line = $replace_line . $target . "|\n";

    //Use to delete old profile picture. However, since only one folder is used for many accounts, can let user use/share duplicate photos 
    //for testing purposes
    if (file_exists($file_path)) {
        // unlink($file_path);
    }

    move_uploaded_file($_FILES['new-profile']['tmp_name'], $target);

    //Set reference for current session
    $_SESSION['file-path'] = $target;
    //Replace image url in database
    $read_file = fopen("../../account.db", "r") or die("Unable to open file!");


    //
    while (!feof($read_file)) {
        $line = fgets($read_file);
        // Update new file Path for the loaded profile picture, every time user logs in will also show new image
        if ($data_line == $line) {
            $write_file = fopen("../../temp_account.db", "a") or die("Unable to open file!");
            fwrite($write_file, $replace_line);
            fclose($write_file);
        } else {
            $write_file = fopen("../../temp_account.db", "a") or die("Unable to open file!");
            fwrite($write_file, $line);
            fclose($write_file);
        }
    }
    fclose($read_file);
    rename("../../account.db", "../../delete.db");
    rename("../../temp_account.db", "../../account.db");
    unlink("../../delete.db");
    $create_file =  fopen("../../temp_account.db", "w");
    fclose($create_file);
}

$_SESSION['file-path'] = $file_path;

// echo $data_line;
// echo '<br>';
// echo '<br>';
// echo $replace_line;

//Check For New Profile Uploads
if (isset($_POST["submit"])) {
    $info = pathinfo($_FILES['new-profile']['name']);
    $ext = $info['extension']; // get the extension of the file
    $newname = $info['filename'] . '.' . $ext;


    $target = '../../login/uploads/' . $newname;
    $replace_line = $replace_line . $target . "|\n";

    //Use to delete old profile picture. However, since only one folder is used for many accounts, can let user use/share duplicate photos 
    //for testing purposes
    if (file_exists($file_path)) {
        // unlink($file_path);
    }

    move_uploaded_file($_FILES['new-profile']['tmp_name'], $target);

    //Set reference for current session
    $_SESSION['file-path'] = $target;
    //Replace image url in database
    $read_file = fopen("../../account.db", "r") or die("Unable to open file!");


    //
    while (!feof($read_file)) {
        $line = fgets($read_file);
        // Update new file Path for the loaded profile picture, every time user logs in will also show new image
        if ($data_line == $line) {
            $write_file = fopen("../../temp_account.db", "a") or die("Unable to open file!");
            fwrite($write_file, $replace_line);
            fclose($write_file);
        } else {
            $write_file = fopen("../../temp_account.db", "a") or die("Unable to open file!");
            fwrite($write_file, $line);
            fclose($write_file);
        }
    }
    fclose($read_file);
    rename("../../account.db", "../../delete.db");
    rename("../../temp_account.db", "../../account.db");
    unlink("../../delete.db");
    $create_file =  fopen("../../temp_account.db", "w");
    fclose($create_file);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Account</title>

    <!-- BootStrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <!-- CSS Files -->
    <link rel="stylesheet" href="../css/account.css">
    <link rel="stylesheet" href="../cart/cart.css">
    <link rel="stylesheet" href="../../login/css/login.css">

    <!-- JavaScript -->
    <script src="./customer.js"></script>
    <script src="../js/account.js"></script>



</head>

<body>
    <!-- Header -->
    <header>
        <div class="container-fluid d-flex justify-content-between bg-dark fw-bold position-fixed top-0 mb-5" id="header">
            <a class="navbar-brand ms-5 d-flex" href="../customer/customer.php" id="h_logo">
                <img src=" <?php echo $_SESSION['file-path']; ?> " alt="logo" class="rounded-circle" id="logo">
                <div class="container-fluid d-flex justify-content-center m-auto p-auto" id="form">
                    <form action="" method="post" enctype="multipart/form-data">
                        <label for="new-profile" class="btn btn-info btn-sm fw-bold" onclick="showSubmit();" id="file-label">Change Profile</label>
                        <input type="file" name="new-profile" id="new-profile" onchange="changeLabelButton();">
                        <button type="submit" name="submit" id="change-profile" class="btn btn-dark bg-light text-dark fw-bold border border-2 border-danger btn-sm" onclick="hideSubmit();">Apply</button>
                    </form>
                </div>
            </a>
            <span class="text-light">Logged in as <?php echo $_SESSION['username']; ?><span>
                    <div class="d-flex">
                        <a class="navbar-brand ms-5 d-flex" href="../cart/cart.php" id="cart-icon">
                            <i class="bi bi-cart-fill fas fa-lg">
                                <span class="badge bg-danger rounded-pill left-0" id="badge">0</span>
                            </i>
                        </a>
                        <img class="" src="../image/lazada.png" alt="Profile" id="account-profile">
                        <a href="../php/account.php" class="nav-link link-info">My Account</a>
                        <form action="" method="post">
                            <input type="submit" name="logout" class="btn btn-primary" value="Log Out">
                        </form>
                    </div>
        </div>
    </header>

    <main>
        <div class="container-fluid d-flex flex-column align-items-center" id="function">
            <div id="search" class="mb-3">
                <form action="" method="POST">
                    <label for="product-text" class="fw-bold">Enter Product Name: </label>
                    <input type="text" name="product-text" class="form-control" required pattern="[A-Z a-z 0-9]+">
                    <button class="btn btn-primary" type="submit" name="search-text">Search</button>
                </form>
            </div>
            <div id="filter" class="mb-3">
                <form action="" method="POST">
                    <label for="product-min-price" class="fw-bold">Enter Product Minimum Price: </label>
                    <input type="text" name="product-min-price" class="form-control" required pattern="[0-9]+">
                    <label for="product-max-price" class="fw-bold">Enter Product Maximum Price: </label>
                    <input type="text" name="product-max-price" class="form-control" required pattern="[0-9]+">
                    <button class="btn btn-primary" type="submit" name="search-price">Filter</button>
                </form>
            </div>
        </div>

        <div class="row d-flex flex-column justify-content-center align-items-center gap-5 m-auto p-auto" id="product-display">
            <?php
            unset($_SESSION['column1']);
            unset($_SESSION['column2']);
            unset($_SESSION['column3']);
                $file = fopen("../../account.db", "r") or die("Unable to open file!");
                //code...            
                $index = 1;
                $integrity = true;
                while (!feof($file)) {
                    $type = $username = $password = $name = $address = '';
                    $line = fgets($file);
                    $pos = strpos($line, '|');
                    $sub_str = substr($line, 0, $pos); // Category of the account, if it is customer then start extract data process
                    if ($sub_str == "vendor") {
                        for ($i = 1; $i < 6; $i++) {
                            $pos = strpos($line, '|');
                            $sub_str = substr($line, 0, $pos);
                            $line = substr($line, $pos + 1, strlen($line) - 1);
                            switch ($i) {
                                case 1:
                                    $type = $sub_str;
                                    break;
                                case 2:
                                    $username = $sub_str;
                                    break;
                                case 3:
                                    $password = $sub_str;
                                    break;
                                case 4:
                                    $name = $sub_str;
                                    break;
                                case 5:
                                    $address = $sub_str;
                                    break;
                            }
                        }
                        $path = "../vendor/company/" . $name . ".csv";
                        if (!file_exists($path)) {
                            echo '<h1 class="h1 text-warning fw-bold">Vendors have not published any products</h1>';
                        } else {
                            $dataFile = fopen($path, "r") or die("vendors have not published any items yet");
                            while (!feof($dataFile)) {
                                $line = fgets($dataFile);
                                //Filter empty string
                                if ($line == '') {
                                    continue;
                                }
                                //Filter Product By Name
                                if (isset($_POST['search-text'])) {
                                    $temp = $line;
                                    $substring = substr($temp, 0, strpos($temp, ','));
                                    echo $substring;
                                    if (isset($_POST['product-text']) && $_POST['product-text'] == $substring) {
                                        $_SESSION['filter'] = true;
                                    } 
                                    else if (isset($_POST['product-text']) && str_contains(strtolower($substring), strtolower($_POST['product-text']))) {
                                        $_SESSION['filter'] = true;
                                    }
                                    else {
                                        continue;
                                    }
                                }
                                //Filter Product By Price
                                if (isset($_POST['search-price'])) {
                                    if (isset($_POST['product-min-price']) && isset($_POST['product-max-price'])) {
                                        $temp = $line;
                                        $name = substr($temp, 0, strpos($temp, ','));
                                        $temp = substr($temp, strpos($temp, ',') + 1, strlen($temp));
                                        $price = substr($temp, 0, strpos($temp, ','));
                                        if ($price >= $_POST['product-min-price'] && $price <= $_POST['product-max-price']) {
                                            $_SESSION['filter'] = true;
                                        } else {
                                            continue;
                                        }
                                    } else if (isset($_POST['product-min-price']) && !isset($_POST['product-max-price'])) {
                                        $temp = $line;
                                        $name = substr($temp, 0, strpos($temp, ','));
                                        $temp = substr($temp, strpos($temp, ',') + 1, strlen($temp));
                                        $price = substr($temp, 0, strpos($temp, ','));
                                        if ($price >= $_POST['product-min-price']) {
                                            $_SESSION['filter'] = true;
                                        } else {
                                            continue;
                                        }
                                    } else if (!isset($_POST['product-min-price']) && isset($_POST['product-max-price'])) {
                                        $temp = $line;
                                        $name = substr($temp, 0, strpos($temp, ','));
                                        $temp = substr($temp, strpos($temp, ',') + 1, strlen($temp));
                                        $price = substr($temp, 0, strpos($temp, ','));
                                        if ($price <= $_POST['product-max-price']) {
                                        } else {
                                            continue;
                                        }
                                    }
                                }

                                //Print out Product Info and Distribute them to columns sequentially
                                if ($index == 3) {
                                    $index = 1;
                                    if (isset($_SESSION['column3'])) {
                                        $column3 = $_SESSION['column3'];
                                        // $newLine = '<form action="../product/product.php" method="POST"> <button type="submit" class="btn btn-primary mb-3 me-2" name="' . $line . '">' . $line . '</button></form> <br>';
                                        // $_SESSION['column3'] = $column3 . $newLine;
                                        $_SESSION['column3'] = $column3 . $line . '|';
                                    } else {
                                        $_SESSION['column3'] = $line . '|';
                                        // $_SESSION['column3'] = '<form action="../product/product.php" method="POST"><button type="submit" class="btn btn-primary mb-3 me-2" name="' . $line . '">' . $line . '</button> </form> <br>';
                                    }
                                } else if ($index == 2) {
                                    $index = 3;
                                    if (isset($_SESSION['column2'])) {
                                        $column2 = $_SESSION['column2'];
                                        // $newLine = '<form action="../product/product.php" method="POST"> <button type="submit" class="btn btn-primary mb-3 me-2" name="' . $line . '">' . $line . '</button></form><br>';
                                        // $_SESSION['column2'] = $column2 . $newLine;
                                        $_SESSION['column2'] = $column2 . $line . '|';
                                    } else {
                                        $_SESSION['column2'] = $line . '|';
                                        // $_SESSION['column2'] = '<form action="../product/product.php" method="POST"><button type="submit" class="btn btn-primary mb-3 me-2" name="' . $line . '">' . $line . '</button> </form> <br>';
                                    }
                                } else {
                                    $index = 2;
                                    if (isset($_SESSION['column1'])) {
                                        $column1 = $_SESSION['column1'];
                                        // $newLine = '<form action="../product/product.php" method="POST"> <button type="submit" class="btn btn-primary mb-3 me-2" name="' . $line . '">' . $line . '</button></form> <br>';
                                        // $_SESSION['column1'] = $column1 . $newLine;
                                        $_SESSION['column1'] = $column1 . $line . '|';

                                    } else {
                                        // $_SESSION['column1'] = '<form action="../product/product.php" method="POST"><button type="submit" class="btn btn-primary mb-3 me-2" name="' . $line . '">' . $line . '</button> </form> <br>';
                                        $_SESSION['column1'] = $line . '|';
                                        
                                    }
                                }
                            }
                            fclose($dataFile);
                        }
                    }
                }
                fclose($file);


            ?>
        </div>
        <?php
        if (isset($_POST['delete-filter'])) {
            unset($_SESSION['filter']);
            echo '<script> window.href = "../customer/customer.php" </script>';
        } else {
            if (isset($_SESSION['filter']) && $_SESSION['filter'] == true) {
                echo ' <div class="container-fluid d-flex flex-column justify-content-center align-items-center mb-3" id="filter-form">
                        <span class="h1 text-success" id="info-message">Item Filtered</span>
                        <form action="" method="POST">
                            <button class="btn btn-warning" name="delete-filter" type="submit">Delete Filtering</button>
                        </form>
                        
                    </div>';
            }
        }
        ?>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 fw-bold" id="column1">
                <?php
                if (isset($_SESSION['column1'])) {
                    $line = $_SESSION['column1'];
                    while($line != '') {
                        $data = $temp = substr($line, 0, strpos($line, '|'));
                        $name = substr($temp, 0 , strpos($temp, ','));
                        $temp = substr($temp, strpos($temp, ',') + 1, strlen($temp));
                        $price = substr($temp, 0 , strpos($temp, ','));
                        $temp = substr($temp, strpos($temp, ',') + 1, strlen($temp));
                        echo '<form action="../product/product.php" method="POST"> <button type="submit" class="btn btn-primary mb-3 me-2" name="' . $data . '">Name: ' . $name . ', Price: ' . $price . '</button></form> <br>';
                        $line = substr($line, strpos($line, '|') + 1, strlen($line));
                    }
                }
                ?>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 fw-bold" id="column2">
                <?php
                if (isset($_SESSION['column2'])) {
                    $line = $_SESSION['column2'];
                    while($line != '') {
                        $data = $temp = substr($line, 0, strpos($line, '|'));
                        $name = substr($temp, 0 , strpos($temp, ','));
                        $temp = substr($temp, strpos($temp, ',') + 1, strlen($temp));
                        $price = substr($temp, 0 , strpos($temp, ','));
                        $temp = substr($temp, strpos($temp, ',') + 1, strlen($temp));
                        echo '<form action="../product/product.php" method="POST"> <button type="submit" class="btn btn-primary mb-3 me-2" name="' . $data . '">Name: ' . $name . ', Price: ' . $price . '</button></form> <br>';
                        $line = substr($line, strpos($line, '|') + 1, strlen($line));
                    }
                }
                ?>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 fw-bold" id="column3">
                <?php
                if (isset($_SESSION['column3'])) {
                    $line = $_SESSION['column3'];
                    while($line != '') {
                        $data = $temp = substr($line, 0, strpos($line, '|'));
                        $name = substr($temp, 0 , strpos($temp, ','));
                        $temp = substr($temp, strpos($temp, ',') + 1, strlen($temp));
                        $price = substr($temp, 0 , strpos($temp, ','));
                        $temp = substr($temp, strpos($temp, ',') + 1, strlen($temp));
                        echo '<form action="../product/product.php" method="POST"> <button type="submit" class="btn btn-primary mb-3 me-2" name="' . $data . '">Name: ' . $name . ', Price: ' . $price . '</button></form> <br>';
                        $line = substr($line, strpos($line, '|') + 1, strlen($line));
                    }
                }
                ?>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container-fluid position-relative bg-dark mt-auto" id="footer">
            <div class="navbar d-flex flex-column">
                <ul class="nav d-flex fw-bold">
                    <li class="nav-item">
                        <a href="../../static/about.html" class="nav-link link-light">About</a>
                    </li>
                    <li class="nav-item">
                        <a href="../../static/copyright.html" class="nav-link link-light">Copyright</a>
                    </li>
                    <li class="nav-item">
                        <a href="../../static/privacy.html" class="nav-link link-light">Privacy</a>
                    </li>
                    <li class="nav-item">
                        <a href="../../static/help.html" class="nav-link link-light">Help Links</a>
                    </li>
                </ul>
            </div>
        </div>
    </footer>
</body>

</html>