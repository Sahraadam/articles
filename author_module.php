<?php
require_once 'db_configuration/connection.php';
session_start();

if (!isset($_SESSION['authname']) && !isset($_SESSION['authname1']) && !isset($_SESSION['authname2'])) {
    header("Location: index.html");
}else{
  $filter = $_SESSION['authname'];
$sql = "SELECT * FROM `users` WHERE `userId` = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$filter]);
$row1 = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Articles Web Platform - Author Homepage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="fontawesome/css/all.min.css" type="text/css" /> 
    <link rel="stylesheet" href="css/slick.css" type="text/css" />   
    <link rel="stylesheet" href="css/styles.css" type="text/css" />
</head>
        <style type="text/css">
        
          table{
    align-items: center;
    color: white;
  }

   th, tr, td{
    padding: 10px 10px;
  }

  label{
    color: white;
  }
    </style>
<body onload="loade();">
    <div id="outer">
        <header class="header order-last" id="tm-header">
            <nav class="navbar">
                <div class="collapse navbar-collapse single-page-nav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#section-1"><span class="icn"><i class="fa fa-home" aria-hidden="true"></i></span> Homepage</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" onclick="myFunction1();"><span class="icn"><i class="fa fa-user" aria-hidden="true"></i></span> Update My Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" onclick="myFunction2();"><span class="icn"><i class="fas fa-users" aria-hidden="true"></i></span> Manage Articles</a>
                        </li> 
                        <li class="nav-item">
                            <a class="nav-link" onclick="myFunction3();"><span class="icn"><i class="fas fa-newspaper"></i></span> View Articles</a>
                        </li>                                          
                    </ul>
                </div>
            </nav>
        </header>
        
        <button class="navbar-button collapsed" type="button">
            <span class="menu_icon">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </span>
        </button>
        
        <main id="content-box" class="order-first">
            <div class="banner-section section parallax-window" data-parallax="scroll" data-image-src="img/bg.jpg" id="section-1">
                <div class="container">
                    <div class="item">
                        <div class="bg-blue-transparent logo-fa"><span><i class="fas fa-newspaper"></i></span>Welcome <?php echo $row1['UserType']; ?>, <?php echo $row1['Full_Name']; ?>!</div>
                        <div class="bg-blue-transparent simple"><p>Simplify the publication process with a structured workflow, ensuring smooth transitions from drafting to editing and final publication.</p>                            <br>
                            <a class="nav-link" href="features/user_logout.php"><span class="icn"><i class="fas fa-power-off"></i></span> Logout</a></div></div>
                    </div>
                </div>
            </div>

            <section class="contact-section section">
                <div class="container" id="profile">
                    <div class="title">
                        <h3>Update My Profile</h3>
                    </div>
                    <div class="row">
                        <div class="col-lg-5 col-md-6 mb-4 contact-form">
                            <div class="form tm-contact-item-inner">
                   <div class="title">
                        <h3>My Profile</h3>
                    </div>
                         <table>
<tr style="text-align: left;
  padding: 8px;">
<th style="text-align: left;
  padding: 8px;">#</th> 
 <th style="text-align: left;
  padding: 8px;">Access Time</th> 
 <th style="text-align: left;
  padding: 8px;">Image</th>      
  <th style="text-align: left;
  padding: 8px;">User Type</th>
   <th style="text-align: left; padding: 8px;"></th>
</tr>

<?php
$sql = "SELECT `userId`, `Full_Name`, `User_Name`, `phone_Number`, `email`, `Gender`, `AccessTime`, `UserType`, `Address`, `profile_Image` FROM `users` WHERE `userId` =:filter";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':filter', $filter, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
?>
<tr>
<td><?php echo($row["userId"]); ?></td>
<td><?php echo($row["AccessTime"]); ?></td>
<td><img style="width: 50px;" src="img/<?php echo($row["profile_Image"]); ?>" title="<?php echo($row["Full_Name"]); ?>"></td>
<td><?php echo($row["UserType"]); ?></td>
</tr>
<?php
}
} else { echo "No results"; }

?>

</table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5 col-md-6 mb-4 contact-form">
                            <div class="form tm-contact-item-inner">
                            <form action="features/main-features.php" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <input name="fname" type="text" class="form-control" placeholder="Fullname" value="<?php echo $row1['Full_Name']; ?>" required>
                                        <input type="hidden" value="<?php echo $filter; ?>" name="uid" required>
                                        <input type="hidden" value="3" name="mod" required>
                                    </div>
                                    <div class="form-group">
                                        <input name="uname" type="text" class="form-control" placeholder="Username" value="<?php echo $row1['User_Name']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <input name="phone" type="text" class="form-control" value="<?php echo $row1['phone_Number']; ?>" placeholder="Phone Number" required>
                                    </div>

                                    <div class="form-group">
                                        <input name="email" type="email" class="form-control" value="<?php echo $row1['email']; ?>" placeholder="Email Address" required>
                                    </div>                      
                                     <div class="form-group">
                                        <input name="address" type="text" value="<?php echo $row1['Address']; ?>" class="form-control" placeholder="Address" required>
                                    </div>
                                    <div class="form-group">
                            <select class="form-control" name="gender" required>
                              <option disabled value="" selected>Select A Gender</option>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                           </select>  
                                    </div>
                                    <div class="form-group">
                                        <label>Profile Picture:</label>
                                        <br>
                                     <input name="image" type="file" accept=".jpg, .png, .jpeg" class="form-control" required>   
                                    </div>
                                    <div class="form-group">
                                        <input name="password" type="password" minlength="8" class="form-control" placeholder="Password" required>
                                    </div>
                                    <div class="form-group">
                                        <input name="cpassword" type="password" minlength="8" class="form-control" placeholder="Confirm Password" required>
                                    </div>                                                          
                                    <div class="form-group text-right">
                                        <input type="submit" name="upu" class="btn btn-primary" value="Update">
                                        <br>
                                        <br>
                                        <br>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>               
                </div>
                    <div class="container" id="articles">
                    <div class="title">
                        <h3>View Articles</h3>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-12 mb-4 contact-details">
                            <div class="tm-contact-item-inner-2">
                   <div class="title">
                        <h3>Articles</h3>
                    </div>
                         <table>
<tr style="text-align: left;
  padding: 8px;">
<th style="text-align: left;
  padding: 8px;">#</th>
<th style="text-align: left;
  padding: 8px;">Author ID</th>
  <th style="text-align: left;
  padding: 8px;">Title</th>
  <th style="text-align: left;
  padding: 8px;">Display</th> 
  <th style="text-align: left;
  padding: 8px;">Created At</th>
    <th style="text-align: left;
  padding: 8px;">Last Updated At</th>
   <th style="text-align: left; padding: 8px;"></th>
<th style="text-align: left; padding: 8px;"></th>
</tr>

<?php
$sql = "SELECT `article_id`, `authorId`, `article_title`, `article_full_text`, `article_display`, `article_order`, `article_created_date`, `article_last_update` FROM `articles` WHERE `authorId` =:filter";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':filter', $filter, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
?>
<tr>
<td><?php echo($row["article_id"]); ?></td>
<td><?php echo($row["authorId"]); ?></td>
<td><?php echo($row["article_title"]); ?></td>
<td><?php echo($row["article_display"]); ?></td>
<td><?php echo($row["article_created_date"]); ?></td>
<td><?php echo($row["article_last_update"]); ?></td>
<td><button class="btn btn-primary py-3 px-5" onclick="return confirm('Are you sure that you want to delete this article?')?window.location.href='features/main-features.php?action=deleteA&id=<?php echo($row["article_id"]); ?>':true;" title='Delete Article'><i class="fas fa-trash-alt"></i></button></td>
<td><button class="btn btn-primary py-3 px-5" onclick="return confirm('Are you sure that you want to print this article?')?window.location.href='features/main-features.php?action=printA&id=<?php echo($row["article_id"]); ?>':true;" title='Print Article'><i class='fas fa-print'></i></button></td>
<br>
<br>
</tr>
<?php
}
} else { echo "No results"; }
?>

</table>                                
                            </div>                        
                        </div>
                    </div>                
                </div>
                                    <div class="container" id="manage_articles">
                    <div class="title">
                        <h3>Manage Articles</h3>
                    </div>
                    <div class="row">
                    <div class="col-lg-5 col-md-6 mb-4 contact-form">
                            <div class="form tm-contact-item-inner">
                                <form action="features/main-features.php" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <input name="atitle" type="text" class="form-control" placeholder="Article Title" required>
                                    </div>
                                    <div class="form-group">
                                <input name="aorder" type="text" class="form-control" placeholder="Article Order" required>
                                    </div> 
<!--                                  <div class="form-group">
                                        <label>Article Display:</label>
                                        <br>
                                     <input name="image" type="file" accept=".jpg, .png, .jpeg" class="form-control" required>   
                                    </div> -->                                          
                            <div class="form-group">
                            <select class="form-control" name="adisplay" required>
                              <option disabled value="" selected>Select A Display</option>
                              <option value="Yes">Yes</option>
                              <option value="No">No</option>
                           </select>  
                                    </div>                      
                                    <div class="form-group">
                                        <textarea name="aftext" class="textarea form-control" placeholder="Article Full Text..." required></textarea>
                                    </div>                       
                                    <div class="form-group text-right">
                                        <input type="submit" name="addarticle" class="btn btn-primary" value="Add Article">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-lg-5 col-md-6 mb-4 contact-form">
                            <div class="form tm-contact-item-inner">
                                <form action="features/main-features.php" method="POST" enctype="multipart/form-data">
                            <div>
                            <select class="form-control" name="gender" required>
                              <option disabled value="" selected>Select An Article</option>
                                     <?php
$sql = "SELECT * FROM `articles` WHERE `authorId` = :filter";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':filter', $filter, PDO::PARAM_INT);
$stmt->execute();

while ($category = $stmt->fetch(PDO::FETCH_ASSOC)):
?>
                                  <option value="<?php echo $category["article_id"];?>"><?php echo $category["article_title"];?></option>
                                  <?php
                                      endwhile;
                                  ?>
                           </select>  
                                    </div>
                                    <div class="form-group">
                                        <input name="atitle" type="text" class="form-control" placeholder="Article Title" required>
                                    </div>
                                    <div class="form-group">
                                <input name="aorder" type="text" class="form-control" placeholder="Article Order" required>
                                    </div> 
<!--                                  <div class="form-group">
                                        <label>Article Display:</label>
                                        <br>
                                     <input name="image" type="file" accept=".jpg, .png, .jpeg" class="form-control" required>   
                                    </div>  -->                        
                            <div class="form-group">
                            <select class="form-control" name="adisplay" required>
                              <option disabled value="" selected>Select A Display</option>
                              <option value="Yes">Yes</option>
                              <option value="No">No</option>
                           </select>  
                                    </div>                    
                                    <div class="form-group">
                                        <textarea name="aftext" class="textarea form-control" placeholder="Article Full Text..." required></textarea>
                                    </div>                         
                                    <div class="form-group text-right">
                                        <input type="submit" name="updatearticle" class="btn btn-primary" value="Update Article">
                                        <br>
                                        <br>
                                        <br>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>                 
                </div>
                <footer class="footer container container-2">
                    <div class="row"> 
                        <p class="col-sm-7">Copyright 2023.</p>
                    </div>
                </footer>
            </section>
        </main-features>
    </div>
   <script defer>
        var x1 = document.getElementById("profile");
        var x2 = document.getElementById("manage_articles");
        var x3 = document.getElementById("articles");

function loade() {
    x1.style.display = "none";
    x2.style.display = "none";
    x3.style.display = "none";
}

function myFunction1() {
  if (x1.style.display === "none") {
    x1.style.display = "block";
  } else {
    x1.style.display = "none";
    x2.style.display = "none";
    x3.style.display = "none";
  }
}

function myFunction2() {
  if (x2.style.display === "none") {
    x2.style.display = "block";
  } else {
    x1.style.display = "none";
    x2.style.display = "none";
    x3.style.display = "none";
  }
}

function myFunction3() {
  if (x3.style.display === "none") {
    x3.style.display = "block";
  } else {
    x1.style.display = "none";
    x2.style.display = "none";
    x3.style.display = "none";
  }
}

document.addEventListener("DOMContentLoaded", loade);
</script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.singlePageNav.min.js"></script>
    <script src="js/slick.js"></script>
    <script src="js/parallax.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>