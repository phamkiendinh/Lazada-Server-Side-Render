<?php    
    session_start();
    // Declare Regular Expression For Username and Password
    $username_regexp = '/^[A-Z a-z 0-9]{8,15}$/';
    $password_regexp = "/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*]).{8,20}$/";
    
    $match = false;

    // Read Data From Form
    if (isset($_POST['username']) && isset($_POST['password'])) {

        $form_username = $_POST['username'];
        $form_password = $_POST['password'];
    }
    
    //Verify RegExp For Username
    if(!preg_match($username_regexp, $form_username)) {
        echo "<script> 
        location.href = '../../www/index.php';
        alert('Username must contain only letters (lower and upper case) and digits, has a length from 8 to 15 characters');
        </script>";        
        die("");
    }
    //Verify RegExp For Password
    if(!preg_match($password_regexp, $form_password)) {
        echo "<script> 
        location.href = '../../www/index.php';
        alert('Password must contain at least one upper case letter, at least one lower case letter, at least one digit, at least one special letter in the set !@#$%^&*, NO other kind of characters, has a length from 8 to 20 characters');
        </script>";        
        die("");
    }    
    
    
    
    // Verify UserName and Filter customer Category
    $file = fopen("../../../Project/account.db", "r") or die("Unable to open file!");
    $integrity = true; 
    while(!feof($file)) {
        $type = $username = $password = '';
        $line = fgets($file);
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
            }
        }
        if ($username == $form_username && password_verify($form_password, $password)) {
            $match = true;
            break;
        }
    }
    fclose($file);

    // Direct to My Account Page
    if ($match) {
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['password'] = $_POST['password'];
        $_SESSION['loggedin'] = true;
        if ($type == 'vendor') {
            header("Location: ../../account/vendor/vendor.php");
        }
        if ($type == 'shipper') {
            header("Location: ../../account/shipper/shipper.php");
        }
        if ($type == 'customer') {
            header("Location: ../../account/customer/customer.php");
        }
    }
    else {
        echo "<script> 
        location.href = '../../www/index.php';
        alert('Wrong account/password! Please enter again!');
        </script>";        
        die("");        
    }



?>

