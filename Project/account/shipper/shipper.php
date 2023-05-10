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
$type = $username = $hub = '';
while (!feof($file)) {
    $line = fgets($file);
    $temp = $line;
    // Category of the account, if it is customer then start extract data process
    for ($i = 1; $i < 5; $i++) {
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
            case 4:
                $hub = $sub_str;
            }
        }
        if ($username == $_SESSION['username']) {
            $data = $temp;
            break;
        }
    }
    fclose($file);
    
$_SESSION['hub'] = $hub;
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

    <title>Shipper</title>

    <!-- BootStrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <!-- CSS Files -->
    <link rel="stylesheet" href="../css/account.css">
    <link rel="stylesheet" href="./shipper.css">
    <link rel="stylesheet" href="../../login/css/login.css">

    <!-- JavaScript -->
    <script src="../js/account.js"></script>
    <script src="./shipper.js"></script>
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
                        <img class="" src="../image/lazada.png" alt="Profile" id="account-profile">
                        <a href="../php/account.php" class="nav-link link-info">My Account</a>
                        <form action="" method="post">
                            <input type="submit" name="logout" class="btn btn-primary" value="Log Out">
                        </form>
                    </div>
        </div>
    </header>

    <main>
        <div id="main-body">
        <?php
            if (isset($_SESSION['hub'])) {
                $sectionData = array();
                if (isset($_SESSION['section-data'])) {
                    unset($_SESSION['section-data']);
                }
                $orderIndex = 1;
                $index = 1;
                $hub = $_SESSION['hub'];
                $file = fopen("./hub/" . $hub . '.txt', "r");
                $filePath = "./hub/" . $hub . '.txt';
                $order = '';
                while (!feof($file)) {
                    $line = fgets($file);
                    $line = str_replace(array("\r", "\n"), '',$line);
                    if (filesize($filePath) == 0) {
                        echo '<h1 class="h1 text-danger text-center"> There are no orders! Please wait until customers order!</h1>';
                        break;
                    }
                    if ($line == 'start') {
                        continue;
                    }
                    if ($line == 'end') {
                        $string = '<hr>' .
                        '<div class="container-fluid d-flex justify-content-center" id="order' . $orderIndex . '">' . 
                            '<h4 class="h4 text-danger m-auto">Order ' . $orderIndex .'</h4>'.
                            '<button type="button" class="btn btn-danger h-25 m-auto" id="button' . $orderIndex . '" onclick=showInformation(' . $orderIndex . ');>Show This Order Information </button>' .
                            '<div class="d-none" id="order-info-' . $orderIndex . '">' .
                                '<h4 class="h4 text-primary">' . $order .'</h4>'.
                            '</div>'.
                            '<form action="./loader.php" method="POST" class="form-control w-25">' .
                                '<input class="d-none" type="text" name="ID" value="' . $orderIndex . '">'.
                                '<label for="status" class="fw-bold mb-1 form-control">Update This Order Status</label>' .
                                '<select class="form-select mb-5" name="status" id="status">' . 
                                    '<option selected disabled class="bg-dark">Active</option>'.
                                    '<option value="delivered">Delivered</option>'.
                                    '<option value="canceled">Canceled</option>'.
                                '</select>'.
                                '<button type="submit" name="confirmOrder" id="confirmOrder" class="btn btn-success btn-lg form-control">Confirm Status</button>'.
                            '</form>'.
                        '</div>'.
                        '<hr>';
                        array_push($sectionData, $string);
                        $order = '';
                        $index = 1;
                        $orderIndex += 1;
                    }
                    else {
                        $substring = '';
                        $temp_str = $line;
                        

                        $order = $order . '<hr><span class="text-danger">' . "Product " . $index . '</span><br>';
                        $order = $order . 'Product Name: ' . substr($temp_str, 0, strpos( $temp_str,',')) . '<br>';
                        $temp_str = substr($temp_str, strpos($temp_str, ',') + 1, strlen($temp_str));
                        $order = $order . 'Product Price: ' . substr($temp_str, 0, strpos( $temp_str,',')) . '<br>';
                        $temp_str = substr($temp_str, strpos($temp_str, ',') + 1, strlen($temp_str));
                        $order = $order . 'Product Description: ' . $temp_str . '<br><hr>';

                        $index++;
                    }
                }

                //Write out all active orders
                $_SESSION['section-data'] = $sectionData;
                foreach ($sectionData as $key) {
                    echo $key;   
                }
            }
        ?>

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