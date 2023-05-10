<?php    
    session_start();
    // Declare Regular Expression For Username and Password
    $username_regexp = '/^[A-Z a-z 0-9]{8,15}$/';
    $password_regexp = "/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*]).{8,20}$/";
    

    // Read Data From Form
    if (isset($_POST['s-username']) && isset($_POST['s-password']) && isset($_POST['hub'])) {

        $form_username = $_POST['s-username'];
        $form_password = $_POST['s-password'];
        $form_hub = $_POST['hub'];
    }
    // Verify UserName and Filter shipper Category
    $file = fopen("../../../Project/account.db", "r") or die("Unable to open file!");
    $integrity = true; 
    while(!feof($file)) {
        $type = $username = $password = $hub = '';
        $line = fgets($file);
        $pos = strpos($line, '|');
        $sub_str = substr($line, 0, $pos); // Category of the account, if it is customer then start extract data process
        if ($sub_str == "shipper") {
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
                    case 3: 
                        $password = $sub_str;
                        break;
                    case 4:
                        $hub = $sub_str;
                        break;
                }
            }
        }
        //Check if the username is unique
        if ($username == $form_username) {
            echo "<script> 
            location.href = '../html/shipper.html';
            alert('Duplicated UserName Detected');
            </script>";
            die("");
        }
    }


    if(!preg_match($username_regexp, $form_username)) {
        echo "<script> 
        location.href = '../html/shipper.html';
        alert('Username must contain only letters (lower and upper case) and digits, has a length from 8 to 15 characters');
        </script>";        
        die("");
    }

    if(!preg_match($password_regexp, $form_password)) {
        echo "<script> 
        location.href = '../html/shipper.html';
        alert('Password must contain at least one upper case letter, at least one lower case letter, at least one digit, at least one special letter in the set !@#$%^&*, NO other kind of characters, has a length from 8 to 20 characters');
        </script>";        
        die("");
    }
    fclose($file);

    $newname = '';

    
    // Store image file in dedicated folder
    if(isset($_POST["submit"])) {
        $info = pathinfo($_FILES['s-profile']['name']);
        $ext = $info['extension']; // get the extension of the file
        $newname = $info['filename'] . '.' . $ext; 
        
        $target = '../uploads/'.$newname;
        move_uploaded_file( $_FILES['s-profile']['tmp_name'], $target);
    }
    
    // Write data


    $file_path = '../../login/uploads/' . $newname;

    $form_type = 'shipper';

    $form_password = password_hash($form_password, PASSWORD_DEFAULT);

    $string = $form_type . '|' . $form_username . '|' . $form_password . '|' . $form_hub . '|' . $file_path ."|\n";

    $_SESSION['file_path'] = $file_path; 

    $file = fopen("../../../Project/account.db", "a") or die("Unable to open file!");
    fwrite($file, $string); 
    fclose($file);


    //Direct User
    header("Location: ../../account/php/account.php");
?>

