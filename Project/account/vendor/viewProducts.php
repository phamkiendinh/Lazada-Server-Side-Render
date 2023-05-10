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

    <!-- CSS Files -->
    <link rel="stylesheet" href="../css/account.css">
    <link rel="stylesheet" href="./css/viewProducts.css">
    <link rel="stylesheet" href="../../login/css/login.css">
    <!-- JavaScript -->
    <script src="../js/account.js"></script>


</head>

<body>
    <!-- Header -->
    <header>
        <div class="container-fluid d-flex justify-content-between bg-dark fw-bold position-fixed top-0 mb-5" id="header">
            <a class="navbar-brand ms-5 d-flex" href="vendor.php" id="h_logo">
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
                        <img class="" src="../image/lazada.png" alt="Profile" id="account-profile">
                        <a href="../php/account.php" class="nav-link link-info">My Account</a>
                        <form action="" method="post">
                            <input type="submit" name="logout" class="btn btn-primary" value="Log Out">
                        </form>
                    </div>
        </div>
    </header>

    <main>
        <div class="container-fluid d-flex flex-column justify-content-center align-items-center gap-5 m-auto p-auto">
            <?php
            if ($_SESSION['type'] == "vendor") {
                $username = $name = $address = '';
                $pos = strpos($data, '|');
                $sub_str = substr($data, 0, $pos); // Category of the account, if it is customer then start extract data process
                if ($sub_str == "vendor") {
                    for ($i = 1; $i < 6; $i++) {
                        $pos = strpos($data, '|');
                        $sub_str = substr($data, 0, $pos);
                        $data = substr($data, $pos + 1, strlen($data) - 1);
                        switch ($i) {
                            case 1:
                                break;
                            case 2:
                                $username = $sub_str;
                                break;
                            case 3:
                                break;
                            case 4:
                                $name = $sub_str;
                                break;
                            case 5:
                                $address = $sub_str;
                                break;
                        }
                    }
                }
            }
            $fileName = "company/". $name . ".csv";

            if (!file_exists($fileName)) {
                echo '<h1 class="h1 text-danger fw-bold">There are no products added yet, please add more products!</h1>';
            }
            else {
                $file = fopen("company/" . $name . ".csv", "r") or die("Not able to open file");
                $index = 1;
                while (!feof($file)) {
                    $line = fgets($file);
                    if ($line == '') {
                        $index++;
                        continue;
                    }
                    $productName = $productPrice = $productDescription = $productProfile = $subString = '';
                    $productName = substr($line, 0 , strpos($line, ','));
                    $line = substr($line, strpos($line, ',') + 1, strlen($line));
                    $productPrice = substr($line, 0 , strpos($line, ','));
                    $line = substr($line, strpos($line, ',') + 1, strlen($line));
                    $productDescription = substr($line, 0 , strpos($line, ','));
                    $productProfile = $line = substr($line, strpos($line, ',') + 1, strlen($line));
                    echo '<hr>';
                    echo '<h1 class="h1 text-danger">' . 'Product ' . $index . '</h1>';
                    echo '<h4 class="h4 fw-bold">' . 'Product Name: ' . $productName . '</h4>';
                    echo '<h4 class="h4 fw-bold">' . 'Product Price: ' . $productPrice . '</h4>';
                    echo '<h4 class="h4 fw-bold">' . 'Product Description: ' . $productDescription . '</h4>';
                    echo '<img src="' .$productProfile . '" alt="profile" class="product-profile-image">';
                    echo '<hr>';
                    $index++;
                }
                fclose($file);
            }
            ?>
        <button type="button" class="btn btn-warning mt-5 text-dark fw-bold"><a href="vendor.php">Go Back to Main Page</a></button>
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