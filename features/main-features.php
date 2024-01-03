<?php

ob_start();

require_once '../db_configuration/connection.php';

session_start();

// PHP Mailer Imports for Email Function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer-library/src/Exception.php';
require '../phpmailer-library/src/PHPMailer.php';
require '../phpmailer-library/src/SMTP.php';

// Register, Update, Delete User
if (isset($_POST['regu']) || isset($_POST['upu']) || ($_REQUEST['action'] == 'deleteU' && !empty($_REQUEST['id']))) {
    if (isset($_POST['regu'])) {
        // Register User logic
        $fname = $_POST['fname'];
        $uname = $_POST['uname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $type = $_POST['type'];
        $gender = $_POST['gender'];
        $address = $_POST['address'];
        $password = $_POST['password'];
        $passwordconfirm = $_POST['cpassword'];

        $filename = $_FILES['image']['name'];

        $valid_extensions = array("jpg", "jpeg", "png");

        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        if (in_array(strtolower($extension), $valid_extensions)) {
            move_uploaded_file($_FILES['image']['tmp_name'], "../img/" . $filename);

            if ($password == $passwordconfirm) {
                $sql = "INSERT INTO `users`(`Full_Name`, `User_Name`, `phone_Number`, `email`, `Gender`, `Password`, `UserType`, `Address`, `profile_Image`) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $hashedPassword = md5($password);
                $stmt->execute([$fname, $uname, $phone, $email, $gender, $hashedPassword, $type, $address, $filename]);
            } else {
                echo "Passwords do not match.";
            }
        } else {
            echo "There is an error with saving the images, kindly check the image format.";
        }
    } elseif (isset($_POST['upu'])) {
        // Update User logic
        $uid = $_POST['uid'];
        $fname = $_POST['fname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordconfirm = $_POST['cpassword'];
                $gender = $_POST['gender'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $mod = $_POST['mod'];

        $filename = $_FILES['image']['name'];

        $valid_extensions = array("jpg", "jpeg", "png");

        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        if (in_array(strtolower($extension), $valid_extensions)) {
            move_uploaded_file($_FILES['image']['tmp_name'], "../img/" . $filename);

            if ($password == $passwordconfirm) {
                $sql = "UPDATE `users` SET `Full_Name`=?, `phone_Number`=?, `email`=?, `Gender`=?, `Password`=?, `Address`=?, `profile_Image`=? WHERE `userId`=?";
                $stmt = $conn->prepare($sql);
                $hashedPassword = md5($password);
                $stmt->execute([$fname, $phone, $email, $gender, $hashedPassword, $address, $filename, $uid]);
            } else {
                echo "Passwords do not match.";
            }
        } else {
            echo "There is an error with saving the images, kindly check the image format.";
        }
    } elseif ($_REQUEST['action'] == 'deleteU' && !empty($_REQUEST['id'])) {
        // Delete User logic
        $deleteItem = $_REQUEST['id'];
        $sql = "DELETE FROM `users` WHERE `userId` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$deleteItem]);
        $sql1 = "DELETE FROM `articles` WHERE `authorId` = ?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->execute([$deleteItem]);
    }

    // Redirect logic
    if (isset($_SESSION['supname'])) {
        header("Location: ../super_user_module.php");
    } elseif (isset($_SESSION['adminame'])) {
        header("Location: ../administrator_module.php");
    }elseif (isset($_SESSION['authname']) && isset($_SESSION['authname1']) && isset($_SESSION['authname2'])) {
        header("Location: ../author_module.php");
    }
}

// Add, Update, Delete Article
if (isset($_POST["addarticle"]) || isset($_POST["updatearticle"]) || ($_REQUEST['action'] == 'deleteA' && !empty($_REQUEST['id']))) {
    if (isset($_POST["addarticle"])) {
        // Add Article logic
        $aid = $_SESSION['authname'];
        $atitle = $_POST['atitle'];
        $aftext = $_POST['aftext'];
        $aorder = $_POST['aorder'];
        $adisplay = $_POST['adisplay'];

        // $filename = $_FILES['image']['name'];

        // $valid_extensions = array("jpg", "jpeg", "png");

        // $extension = pathinfo($filename, PATHINFO_EXTENSION);

        // if (in_array(strtolower($extension), $valid_extensions)) {
        //     move_uploaded_file($_FILES['image']['tmp_name'], "../img/" . $filename);

            $sql = "INSERT INTO `articles`(`authorId`, `article_title`, `article_full_text`, `article_display`, `article_order`) VALUES (?, ?, ?, ?, ?)";
try {
    $stmt = $conn->prepare($sql);
    $stmt->execute([$aid, $atitle, $aftext, $adisplay, $aorder]);

            $d = date('Y-m-d');
            
 $mail = new PHPMailer(true);

             $mail->isSMTP();
             $mail->Host = 'smtp.gmail.com';
             $mail->SMTPAuth = 'true';
             $mail->Username = ''; //Your Gmail
             $mail->Password = ''; //Your Gmail App Password
             $mail->SMTPSecure = 'ssl';
             $mail->Port = 465;

             $mail->setFrom($_SESSION['authname1']); //Sender Address
             $mail->addAddress(''); //Receiver Address
             $mail->isHTML(true);
             $mail->Subject = 'Notification of Published Article!';
             $mail->Body = '
<html>
<head></head>
<body>
<h1>Dear Administrator Sarah Ahmed,</h1>
<br>
<br>
<p>I trust this message finds you well. I am writing to inform you that an article has been successfully published on your esteemed article management web platform. The details of the published article are as follows:</p>
<br>
<br>
<ol>
<li>Title: ' . $atitle . '</li>
<br>
<li>Author: ' . $_SESSION['authname2'] . '</li>
<br>
<li>Date of Publication: ' . $d . '</li> 
<br>
<br>
<p>We believe that this contribution adds value to the platform and aligns with the standards in-place. The author has complied with all the submission guidelines, and the article has undergone the necessary review process.</p>
<br>
<br>
<p>We appreciate your commitment to maintaining the quality of content on the platform and are confident that this article will contribute positively to the platforms reputation. If there are any further actions required from our end or if you need additional information, please do not hesitate to let us know.</p>
<br>
<br>
<p>Thank you for your attention to this matter, and we look forward to continued collaboration with the Article Management Web Platform.</p>
<br>
<br>
<h1>Best regards,
' . $_SESSION['authname2'] . ' .</h1>
</body>
</html>';

             $mail->send();

             header("Location: ../author_module.php?addarticle=success");

    exit; 
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
var_dump($stmt);
            
        // } else {
        //     echo "There is an error with saving the images, kindly check the image format.";
        // }
    } elseif (isset($_POST["updatearticle"])) {
        // Update Article logic
        $aid = $_POST['aid'];
        $atitle = $_POST['atitle'];
        $aftext = $_POST['aftext'];
        $aorder = $_POST['aorder'];
        $adisplay = $_POST['adisplay'];

        // $filename = $_FILES['image']['name'];

        // $valid_extensions = array("jpg", "jpeg", "png");

        // $extension = pathinfo($filename, PATHINFO_EXTENSION);

        // if (in_array(strtolower($extension), $valid_extensions)) {
        //     move_uploaded_file($_FILES['image']['tmp_name'], "../img/" . $filename);

            $sql = "UPDATE `articles` SET `article_title`=?, `article_full_text`=?, `article_display`=?, `article_order`=?, `article_last_update`=NOW() WHERE `article_id` = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$atitle, $aftext, $adisplay, $aorder, $aid]);

            header("Location: ../author_module.php?updatearticle=success");
        // } else {
        //     echo "There is an error with saving the images, kindly check the image format.";
        // }
    } elseif ($_REQUEST['action'] == 'deleteA' && !empty($_REQUEST['id'])) {
        // Delete Article logic
        $deleteItem = $_REQUEST['id'];
        $sql = "DELETE FROM `articles` WHERE `article_id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$deleteItem]);

        header("Location: ../author_module.php?deletearticle=success");
    }
}

// Print An Article
if ($_REQUEST['action'] == 'printA' && !empty($_REQUEST['id'])) {
    $selectItem = $_REQUEST['id'];
    $sql = "SELECT * FROM `articles` WHERE `article_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$selectItem]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $author = $_SESSION['authname2'];

    echo "<html>
            <head>
                <title>Articles Web Platform - Print Article</title>
            </head>
            <style type='text/css'>
                table{
                    align-items: center;
                }
                th, tr, td{
                    padding: 10px 10px;
                }
            </style>
            <script type='text/javascript'>
                function printData() {
                    var divToPrint=document.getElementById('article');
                    newWin= window.open('');
                    newWin.document.write(divToPrint.outerHTML);
                    newWin.print();
                    newWin.close();
                }

function redirectToPreviousPage() {
    // Use history to go back to the previous page
    window.history.back();
}

            </script>
            <script src='https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js'></script>

            <script> 
                window.onload = function() {
                    printData();
                    redirectToPreviousPage();
                }
            </script>
            <body id='article'>
                <div>
                    <h1>Title: " . $data['article_title']  ." by " . $author  .".</h1>
                </div>
                <br>
                <div>
                    <label>Display: " . $data['article_display']  ."</label>
                </div>
                <br>
                <div>
                    <p>Article Text: " . $data['article_full_text']  .".</p>
                    <br>
                    <p>Article Order: " . $data['article_order']  .".</p>
                    <br>
                    <p>Article Created At: " . $data['article_created_date']  .".</p>
                    <br>
                    <p>Article Last Updated At: " . $data['article_last_update']  .".</p>
                </div>
            </body>
          </html>";

    // header("Location: ../author_module.php?printarticle=success");
}

ob_end_flush();

?>