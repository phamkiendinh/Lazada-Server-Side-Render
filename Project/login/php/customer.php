<?php    
    session_start();
    // Declare Regular Expression For Username and Password
    $username_regexp = '/^[A-Z a-z 0-9]{8,15}$/';
    $password_regexp = "/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*]).{8,20}$/";
    

    // Read Data From Form
    if (isset($_POST['c-username']) && isset($_POST['c-password']) && isset($_POST['c-name']) && isset($_POST['c-address'])) {

        $form_username = $_POST['c-username'];
        $form_password = $_POST['c-password'];
        $form_name = $_POST['c-name'];
        $form_address = $_POST['c-address'];
    }
    // Verify UserName and Filter customer Category
    $file = fopen("../../../Project/account.db", "r") or die("Unable to open file!");
    $integrity = true; 
    while(!feof($file)) {
        $type = $username = $password = $name = $address = '';
        $line = fgets($file);
        $pos = strpos($line, '|');
        $sub_str = substr($line, 0, $pos); // Category of the account, if it is customer then start extract data process
        if ($sub_str == "customer") {
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
        }

        if ($username == $form_username) {
            echo "<script> 
            location.href = '../html/customer.html';
            alert('Duplicated UserName Detected');
            </script>";
            die("");
        }
    }
    
    if (strlen($form_name) < 5) {
        echo "<script> 
        location.href = '../html/customer.html';
        alert('Name Length Must Be Greater Than 5');
        </script>";
        die("");
    }

    if (strlen($form_address) < 5) {
        echo "<script> 
        location.href = '../html/customer.html';
        alert('Address Length Must Be Greater Than 5');
        </script>";
        die("");
    }
    if(!preg_match($username_regexp, $form_username)) {
        echo "<script> 
        location.href = '../html/customer.html';
        alert('Username must contain only letters (lower and upper case) and digits, has a length from 8 to 15 characters');
        </script>";        
        die("");
    }

    if(!preg_match($password_regexp, $form_password)) {
        echo "<script> 
        location.href = '../html/customer.html';
        alert('Password must contain at least one upper case letter, at least one lower case letter, at least one digit, at least one special letter in the set !@#$%^&*, NO other kind of characters, has a length from 8 to 20 characters');
        </script>";        
        die("");
    }
    fclose($file);

    
    // Store image file in dedicated folder
        if(isset($_POST["submit"])) {
            $info = pathinfo($_FILES['c-profile']['name']);
            $ext = $info['extension']; // get the extension of the file
            $newname = $info['filename'] . '.' . $ext; 
            
            $target = '../uploads/'.$newname;
            move_uploaded_file( $_FILES['c-profile']['tmp_name'], $target);
        }


    // Write data

        $file_path = '../../login/uploads/' . $newname;

        $form_type = 'customer';

        $form_password = password_hash($form_password, PASSWORD_DEFAULT);

        $string = $form_type . '|' . $form_username . '|' . $form_password . '|' . $form_name . '|' . $form_address . '|' . $file_path ."|\n";
        
        $_SESSION['file_path'] = $file_path; 

        $file = fopen("../../../Project/account.db", "a") or die("Unable to open file!");
        fwrite($file, $string); 
        fclose($file);        


    header("Location: ../../account/php/account.php");
?>

