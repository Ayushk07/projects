<?php require('../config/connections.php'); ?>
<?php require('../formvalidator.php'); ?>
<?php
session_start();
/**
 * Login process
 */

if (isset($_POST['action']) && $_POST['action'] == 'shortguy_login_process') {
    $return     =   [];
    $username   =   (isset($_POST['req_username'])  &&  !empty($_POST['req_username']))     ?   pun_trim($_POST['req_username'])  :   '';
    $password   =   (isset($_POST['req_password'])  &&  !empty($_POST['req_password']))     ?   pun_trim($_POST['req_password'])  :   '';
    $captcha    =   (isset($_POST['captcha'])       &&  !empty($_POST['captcha']))          ?   $_POST['captcha']                 :   '';
    if (empty($username)) {
        $return['status']   =   false;
        $return['field']    =   'req_username';
        $return['message']  =   'Please Enter The Username';
    } else if (empty($password)) {
        $return['status']   =   false;
        $return['field']    =   'req_password';
        $return['message']  =   'Please Enter The Password';
    } else if (empty($captcha)) {
        $return['status']   =   false;
        $return['field']    =   'captcha';
        $return['message']  =   'Please Enter captcha';
    } else {
        $getusername        =   getSimpleValues('SELECT * FROM ' . TABLE_PREFIX . 'for_users WHERE LOWER(username)=LOWER(\'' . $username . '\') LIMIT 1');
        $userdata           =   getSimpleValues("SELECT * FROM " . TABLE_PREFIX . "tbl_users WHERE username = '" . $username . "' and password = '" . $password . "'");
        if (!empty($captcha) && trim(strtolower($captcha)) != $_SESSION['captcha']) {
            $return['status']   =   false;
            $return['field']    =   'captcha';
            $return['message']  =   'Invalid captcha';
        } else if (empty($getusername) && !empty($userdata)) {
            $return['status']   =   false;
            $return['field']    =   '';
            $return['message']  =   '<div style="background: #f9d8c0; width: 100%;padding: 20px;text-align: center;color: #000;"><h4>Sorry! Your account is not activated. Please Check your email for account activation link. </h4><strong>OR<br> Click on the following link and we will resend you account activation link.</strong><br><strong><a href="resend_link.php?Resend_link=yes&id=' . $userdata['id'] . '">Resend account activation link</a></strong></div>';
        } else if (empty($getusername) && empty($userdata)) {
            $return['status']   =   false;
            $return['field']    =   '';
            $return['message']  =   'Wrong user/pass';
        } else if (!empty($userdata) && $userdata['user_block'] == 1) {
            $return['status']   =   false;
            $return['field']    =   '';
            $return['message']  =   '<div style="background: #E9C0B7; width:100%; padding:20px; text-align:center;"><h3>You are not authorized user!</h3></div>';
        } else {
            $return['status']   =   true;
            $return['field']    =   '';
            $return['message']  =   'Login successfully';
        }
    }
    echo json_encode($return);
    exit;
}


/**
 * submit contact us form
 */

if (isset($_POST['action']) && $_POST['action'] == 'shortguy_save_contact_us') {
    $name       =   $_POST['name'];
    $email      =   $_POST['email'];
    $category   =   $_POST['category'];
    $company    =   $_POST['company'];
    $message    =   $_POST['message'];

    if (!empty($name) && !empty($email) && !empty($category) && !empty($company)  && !empty($message)) {
        $sql = "INSERT INTO `" . TABLE_PREFIX . "tbl_submitted_contacts`( `name`, `email`, `category`, `company`,`message`) 
    VALUES ('$name','$email','$category','$company','$message')";
    }
    if (gmysql_query($sql)) {


        echo json_encode(array("statusCode" => 200));
    }
} else {
    echo json_encode(array("statusCode" => 201));


    exit();
}

// if (isset($_POST['action']) && $_POST['action'] == 'shortguy_save_contact_us') {
//     $name       =   $_POST['name'];
//     $email      =   $_POST['email'];
//     $category   =   $_POST['category'];
//     $company    =   $_POST['company'];
//     $message    =   $_POST['message'];

//     if (!empty($name) && !empty($email) && !empty($category) && !empty($company)  && !empty($message)) {
//         $sql = "INSERT INTO `" . TABLE_PREFIX . "tbl_submitted_contacts`( `name`, `email`, `category`, `company`,`message`) 
//     VALUES ('$name','$email','$category','$company','$message')";
//     }
//     if (gmysql_query($sql)) {


//         echo json_encode(array("statusCode" => 200));
//     }
// } else {
//     echo json_encode(array("statusCode" => 201));
// }

// exit();


if (isset($_POST['action1']) && $_POST['action1'] == 'shortguy_save_submit_artical') {
    $author_fname     =   $_POST['first_name'];
    $author_lname     =   $_POST['last_name'];
    $author_email     =   $_POST['email'];
    $article_title    =   $_POST['article_title'];
    $article_submit   =   $_POST['article_submit'];
    $article_category =   $_POST['article_category'];
    if (!empty($author_fname) && !empty($author_lname) && !empty($author_email) && !empty($article_title)  && !empty($article_submit) && !empty($article_category)) {

        echo "INSERT INTO `" . TABLE_PREFIX . "tbl_submitted_article`(title,tag,summary,description,embed,add_date,status,category_id,author_fname,author_lname,author_email) values('" . $article_title . "','','','" . $article_submit . "','','" . $date . "','0','" . $article_category . "','" . $author_fname . "','" . $author_lname . "','" . $author_email . "'";
        $sql = "INSERT INTO `" . TABLE_PREFIX . "tbl_submitted_article`(title,tag,summary,description,embed,add_date,status,category_id,author_fname,author_lname,author_email) values('" . $article_title . "','','','" . $article_submit . "','','" . $date . "','0','" . $article_category . "','" . $author_fname . "','" . $author_lname . "','" . $author_email . "'";
        if (gmysql_query($sql)) {
            echo json_encode(array("statusCode" => 200));
        }
    } else {
        echo json_encode(array("statusCode" => 201));
    }
    exit();
}


//$in = mysql_query("INSERT INTO `tbl_submitted_article`(title,uid,tag,summary,description,embed,add_date,status,category_id,author_fname,author_lname,author_email) values('".$_POST['article_title']."','".$_SESSION['customer_id']."','','','". mysql_real_escape_string(trim($_POST['article_submit']))."','','".$date."','0','".$_POST['article_category']."','".$_POST['first_name']."','".$_POST['last_name']."','".$_POST['email']."')");







?>
