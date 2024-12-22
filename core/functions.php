<?php
require_once 'database.php';

// Check User is Loggedin or not
function isLoggedin()
{
    return isset($_SESSION['user']) ? true : false;
}

// Login
function login($email, $pwd)
{
    global $db;
    $result = '';
    $pwd = md5($pwd);
    $loginQ = $db->query("SELECT id FROM users WHERE `email`='$email' AND `password`='$pwd'");
    if (mysqli_num_rows($loginQ) > 0) {
        $fetchID = mysqli_fetch_object($loginQ);
        $_SESSION['user'] = $fetchID->id;
        $result = '<h6 class="text-center alert alert-success">Login success, redirecting...</h6>
        <script>
            setTimeout(function(){
                window.location.href = "./";
            },1800);
        </script>
        ';
    } else {
        $result = '<h6 class="text-center alert alert-danger">Incorrect credentials, please check.</h6>';
    }
    return $result;
}

// Registration
function register($POST)
{
    global $db;
    $fullName = $POST['fullName'];
    $username = $POST['username'];
    $email = $POST['email'];
    $phone = $POST['phone'];
    $pwd = $POST['password'];
    // EMPTY VARIABLES
    $response = '';
    $user_type_ = '';

    $checkEmail = $db->query("SELECT email FROM `users` WHERE `email`='$email'");
    $phone_length = strlen($phone);
    $pwd_length = strlen($pwd);
    if (mysqli_num_rows($checkEmail) > 0) :
        $response = '<h6 class="text-center alert alert-danger">Email Already Exist.</h6>';
    else :
        if ($phone_length < 10) :
            $response = '<h6 class="text-center alert alert-danger">Phone length must be 10.</h6>';
        else :
            if ($pwd_length < 6) :
                $response = '<h6 class="text-center alert alert-danger">Password length must be 6 characters long.</h6>';
            else :
                // if ($pwd != $r_pwd) :
                //     $response = '<h6 class="text-center alert alert-danger">Password & Confirm Password do not match.</h6>';
                // else :
                $pwd = md5($pwd);
                $insertQ = $db->query("INSERT INTO `users` (fullname,username,email,password,phone,role) VALUES('$fullName','$username','$email','$pwd','$phone','dev')");
                if ($insertQ) {
                    $bytes = openssl_random_pseudo_bytes(32);
                    $hash = base64_encode($bytes);
                    $db->query("UPDATE `token` SET `reg_token`='$hash' WHERE `id`='1'");
                    $response = '<h6 class="text-center alert alert-success">' . $user_type_ . ' registered successfully.</h6>
                <script>
                    setTimeout(function(){
                        window.location.href = "./login.php";
                    },1800);
                </script>
                ';
                }
            // endif;
            endif;
        endif;
    endif;

    return $response;
}

function profile_pic($POST, $FILE)
{
    $targetDir = './img/prod/';
    global $db;
    $statusMsg = '';
    $profile_id = $POST['profile_id'];
    if (!empty($FILE["profile_pic"]["name"])) {

        $fileName = basename($FILE["profile_pic"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        //allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');
        if (in_array($fileType, $allowTypes)) {
            //upload file to server
            if (move_uploaded_file($FILE["profile_pic"]["tmp_name"], $targetFilePath)) {

                $prod_Q = $db->query("UPDATE `users` SET `profile_pic`='$targetFilePath' WHERE `id`='$profile_id'");

                if ($prod_Q) {

                    $statusMsg = '<h6 class="alert alert-success w-75 text-center mx-auto">Profile Picture Updated.</h6>
                    <script>
                        setTimeout(function(){
                            window.location.href = "./doctorDashboard.php";
                        },1800);
                    </script>
                    ';
                } else {
                    $statusMsg = "Something went wrong!";
                }
            } else {
                $statusMsg = "Sorry, there was an error uploading your file.";
            }
        } else {
            $statusMsg = '<h6 class="alert alert-danger w-75 text-center mx-auto">Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.</h6>';
        }
    } else {

        $statusMsg = '<h6 class="alert alert-success w-50 text-center mx-auto">Please select a file to upload.</h6>';
    }

    return $statusMsg;
}

function edit_user($POST)
{

    global $db;
    $pwd = '';
    $response = '';
    $diseases = null;
    $certificate = null;
    $experience = null;
    $checkin_time = null;
    $checkout_time = null;
    $weekend = 'no';
    $redirect = '';

    $old_owd = $POST['old_pwd'];
    $password =  $POST['password'];

    $user_id =  $POST['user_id'];
    $name =  $POST['name'];
    $email =  $POST['email'];
    $phone =  $POST['phone'];
    $dob =  $POST['dob'];
    $gender =  $POST['gender'];
    $city =  $POST['city'];
    $user_type_ = $POST['user_role'];


    if ($password == '') {
        $pwd = $old_owd;
    } else {
        $pwd = md5($password);
    }


    if ($user_type_ == 'patient') {
        $diseases = $POST['diseases'];
        $upd_Q = $db->query("UPDATE `users` SET `name`='$name', `email`='$email', `password`='$pwd', `phone`='$phone', `diseases`='$diseases', `dob`='$dob', `gender`='$gender', `city`='$city' WHERE `id`='$user_id'");
        $redirect = './dashboard.php';
    } else {
        $certificate = $POST['certificate'];
        $experience = $POST['experience'];
        $upd_Q = $db->query("UPDATE `users` SET `name`='$name', `email`='$email', `password`='$pwd', `phone`='$phone', `dob`='$dob', `gender`='$gender', `city`='$city', `certificate`='$certificate', `experience`='$experience' WHERE `id`='$user_id'");
        $redirect = './doctorDashboard.php';
    }


    if ($upd_Q) {
        echo '<h6 class="text-center alert alert-success">' . $user_type_ . ' has been updated successfully.</h6>
        <script>
        setTimeout(function(){
            window.location.href = "' . $redirect . '";
        }, 1800);
        </script>
        ';
    }
}

function add_user($POST)
{
    global $db;
    $cols = '';
    $values = '';
    $POST['password'] = md5($POST['password']);
    foreach ($POST as $key => $value) {
        if ($key != 'submit') {
            $cols .= $key . ',';
            $values .= "'" . $value . "',";
        }
    }
    $cols = substr($cols, 0, strlen($cols) - 1);
    $values = substr($values, 0, strlen($values) - 1);

    $add_Q = $db->query("INSERT INTO `users` ($cols) VALUES($values)");

    if ($add_Q) {
        echo '<h6 class="text-center alert alert-success">User has been added successfully.</h6>
        <script>
        setTimeout(function(){
            window.location.href = "./adminDashboard.php";
        }, 1800);
        </script>
        ';
    }
}

function add_category($POST)
{
    global $db;
    $statusMsg = '';
    $cat_name = $POST['category_name'];

    $add_cat_Q = $db->query("INSERT INTO `categories` (category_name,status) VALUES('$cat_name','1')");

    if ($add_cat_Q) {

        $statusMsg = ["status" => "success", "msg" => "Category has been added successfully."];
    } else {
        $statusMsg = ["status" => "error", "msg" => "Something went wrong."];
    }
    return json_encode($statusMsg);
}

function get_categories()
{
    global $db;
    $get_cat = $db->query("CALL `get_all_categories`()");
    while ($cat = mysqli_fetch_object($get_cat)):
        echo '<option value="' . $cat->id . '">' . $cat->category_name . '</option>';
    endwhile;
    $get_cat->close();
    $db->next_result();
}

function get_devs()
{
    global $db;
    $get_devs = $db->query("CALL `get_devs`()");
    while ($dev = mysqli_fetch_object($get_devs)):
        echo '<option value="' . $dev->id . '">' . $dev->fullname . '</option>';
    endwhile;
    $get_devs->close();
    $db->next_result();
}

function add_category_with_img($POST, $FILE)
{
    global $db;
    $targetDir = './img/prod/';
    $statusMsg = '';
    $cat_name = $POST['category_name'];
    if (!empty($FILE["service_image"]["name"])) {

        $fileName = basename($FILE["service_image"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        //allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');
        if (in_array($fileType, $allowTypes)) {
            //upload file to server
            if (move_uploaded_file($FILE["service_image"]["tmp_name"], $targetFilePath)) {

                $add_cat_Q = $db->query("INSERT INTO `categories` (service_name,status,img) VALUES('$cat_name','1','$targetFilePath')");

                if ($add_cat_Q) {

                    $statusMsg = '<h6 class="alert alert-success w-75 text-center mx-auto">Service has been Added Successfully.</h6>
                    <script>
                        setTimeout(function(){
                            window.location.href = "./doctorDashboard.php";
                        },1800);
                    </script>
                    ';
                } else {
                    $statusMsg = "Something went wrong!";
                }
            } else {
                $statusMsg = "Sorry, there was an error uploading your file.";
            }
        } else {
            $statusMsg = '<h6 class="alert alert-danger w-75 text-center mx-auto">Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.</h6>';
        }
    } else {

        $statusMsg = '<h6 class="alert alert-success w-50 text-center mx-auto">Please select a file to upload.</h6>';
    }


    return $statusMsg;
    // if ($add_cat_Q) {
    //     return '<h6 class="text-center alert alert-success">' . $cat_name . ' has been added.</h6>
    //     <script>
    //     setTimeout(function(){
    //         window.location.href = "./add_services.php";
    //     },1800);
    //     </script>
    //     ';
    // }
}

function forgetPassword($email, $phone)
{
    global $db;
    $msg = '';
    $checkQ = $db->query("SELECT * FROM `users` WHERE `email`='$email' AND `phone`='$phone'");
    if (mysqli_num_rows($checkQ) > 0) {
        $bytes = bin2hex(random_bytes(4));
        $newPwdMD5 = md5($bytes);
        $db->query("UPDATE `users` SET `password`='$newPwdMD5' WHERE `email`='$email' AND `phone`='$phone'");
        $msg = '<h6 class="text-center alert alert-success">Your New Password is: <span class="d-block">' . $bytes . '<span></h6>
        <script>
            setTimeout(function(){
                window.location.href = "./login.php";
            },10000);
        </script>
        ';
    } else {
        $msg = '<h6 class="text-center alert alert-danger">Invalid Credentials.</h6>';
    }
    return $msg;
}


function delete($id, $table)
{
    global $db;
    $del_Q = $db->query("DELETE FROM `$table` WHERE `id`='$id'");
    if ($del_Q) {
        echo json_encode(["status" => "success", "msg" => $table . " deleted successfully."]);
    } else {
        echo json_encode(["status" => "error", "msg" => "Something went wrong."]);
    }
}
