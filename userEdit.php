<?php 

	include 'core/init.php';
	if($getFromU->loggedIn() === false){
		header('Location: index.php');
	}
    
	$user_id = $_SESSION['user_id'];
	$user    = $getFromU->userData($user_id);
	$notify  = $getFromM->getNotificationCount($user_id);

 
	if(isset($_POST['screenName'])){
		if(!empty($_POST['screenName'])){
			$screenName  = $getFromU->checkInput($_POST['screenName']);
			$profileBio  = $getFromU->checkInput($_POST['bio']);
			$country     = $getFromU->checkInput($_POST['country']);
			$website     = $getFromU->checkInput($_POST['website']);

			if(strlen($screenName) > 20){
				$error  = "Le nom doit contenir entre 6-20 caractères";
			}else if(strlen($profileBio) > 120){
				$error = "La description est trop longue";
			}else if(strlen($country) > 80){
				$error = "Le nom de votre pays est trop grand";
			}else {
				 $getFromU->update('users', $user_id, array('screenName' => $screenName, 'bio' => $profileBio, 'country' => $country, 'website' => $website));
				 header('Location:'.$user->username);
			}
		}else{
			$error = "le nom d'utilisateur ne peut être changé";
		}
	}

	if(isset($_FILES['profileImage'])){
		if(!empty($_FILES['profileImage']['name'][0])){
			$fileRoot  = $getFromU->uploadImage($_FILES['profileImage']);
			$getFromU->update('users', $user_id, array('profileImage' => $fileRoot));
			header('Location: user.php');
		}
	}


	if(isset($_FILES['profileCover'])){
		if(!empty($_FILES['profileCover']['name'][0])){
			$fileRoot  = $getFromU->uploadImage($_FILES['profileCover']);
			$getFromU->update('users', $user_id, array('profileCover' => $fileRoot));
			header('Location: user.php');
		}
	}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TweetApp</title>

    <!-- using online links -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>


    <!--NavBar mobile -->
    <div class="bottom-bar">
        <ul>
            <li class="active__menu"><a href="#"><i class="fa fa-home"></i></a></li>
            <li><a href="#"><i class="fa fa-search"></i></a></li>
            <li><a href="#"><i class="far fa-bell"></i></a></li>
            <li><a href="#"><i class="far fa-envelope"></i></a></li>
        </ul>
    </div>
    <!--Content Page-->
    <div class="grid-container">
        <!--Left Sidebar-->
        <div class="sidebar">
            <ul style="list-style: none">
            <li>
                <a href="home.php" class="logo"><img src="./assets/img/logo.png"></a>
            </li>
            <li>
                <a href="home.php"><i class="fa fa-home"></i><span> Accueil</span></a>
            </li>
            <li>
                <a href="#"><i class="fa fa-hashtag"></i><span> Explore</span></a>
            </li>
            <li>
                <a href="#"><i class="far fa-bell"></i><span> Notifications</span></a>
            </li>
            <li id="messagePopup">
                <a href="#"><i class="far fa-envelope"></i><span> Messages</span></span></a>
            </li>
            <li class="signets" style="display: none">
                <a href="#"><i class="far fa-bookmark"></i><span> Signets</span></a>
            </li>
            <li class="listes" style="display: none">
                <a href="#"><i class="fa fa-list"></i><span> Listes</span></a>
            </li>
            <li class="active__menu">
                <a href="user.php"><i class="far fa-user"></i><span> Profil</span></a>
            </li>
            <li>
                <a href="#"><i class="fa fa-ellipsis-h"></i><span> Plus</span></a>
            </li>
            <li style="padding: 10px 40px;"><button for="pop-up-tweet" class="sidebar__tweet addTweetBtn"> Tweet</button></li>
            
            </ul>

            <div class="sidebar-footer">
                <div class="dropdown">
                    <a href="includes/logout.php" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="<?php echo $user->profileImage; ?>" alt="">
                        <div class="sidebar-log">
                            <h5>Se déconnecter</h5>
                            <span>@<?php echo $user->username; ?></span>
                        </div>
                    </a>
                </div>
                
            </div>
        </div>

    <div class="main">

        <div class="page_title">
            <a href="index.php"><i class="fa fa-arrow-left"></i></a>
            <h2><?php echo $user->screenName; ?> <br><span></span></h2>
        </div>
        <div class="profile-cover-wrap"> 
            <div class="profile-cover-inner">
                <div class="profile-cover-img">
                    <!-- PROFILE-COVER -->
                    <img src="<?php echo $user->profileCover;?>"/>



                    <div class="img-upload-button-wrap">
                        <div class="img-upload-button1">
                            <label for="cover-upload-btn">
                                <i class="fa fa-camera" aria-hidden="true"></i>
                            </label>
                            <span class="span-text1">Changez votre photo de couverture</span>
                            <input id="cover-upload-btn" type="checkbox"/>
                            <div class="img-upload-menu1">
                                <span class="img-upload-arrow"></span>
                                <form method="post" enctype="multipart/form-data">
                                    <ul>
                                        <li>
                                            <label for="file-up">Upload photo</label>
                                            <input type="file" onchange="this.form.submit();" name="profileCover" id="file-up" />
                                        </li>
                                            <li>
                                            <label for="cover-upload-btn">Cancel</label>
                                        </li>
                                    </ul>
                                </form>
                            </div>
                        </div>
		            </div>
                </div>
            </div>
        </div><!--Profile Cover End-->

        <!-- Inner wrapper -->
        <div class="in-wrapper">
            <div class="in-full-wrap">
                <div class="in-left">
                    <div class="in-left-wrap">

                        <!--PROFILE INFO WRAPPER END-->
                        <div class="profile-info-wrap">
                            <div class="profile-info-inner">
                                <!-- PROFILE-IMAGE -->
                                <div class="profile-img">
                                    <img src="<?php echo $user->profileImage;?>"/>
                                    <div class="img-upload-button-wrap1">
                                        <div class="img-upload-button">
                                            <label for="img-upload-btn">
                                                <i class="fa fa-camera" aria-hidden="true" style="font-size: 20px"></i>
                                            </label>
                                            <input id="img-upload-btn" type="checkbox"/>
                                            <div class="img-upload-menu">
                                                <span class="img-upload-arrow"></span>
                                                <form method="post" enctype="multipart/form-data">
                                                    <ul>
                                                        <li>
                                                            <label for="profileImage">Upload photo</label>
                                                            <input id="profileImage" type="file"  onchange="this.form.submit();" name="profileImage"/>
                                                        </li>
                                                        <li><a href="#">Remove</a></li>
                                                        <li>
                                                            <label for="img-upload-btn">Cancel</label>
                                                        </li>
                                                    </ul>
                                                </form>
                                            </div>
                                        </div>
                                    <!-- img upload end-->
                                    </div>

                                </div>
                        
                                <div class="btn-edit">
                                    <span>
                                        <button class="f-btn" type="button" onclick="window.location.href='<?php echo BASE_URL.$user->username;?>'" value="Cancel">Cancel</button>
                                    </span>
                                    <span>
                                        <input type="submit" id="save" value="Sauvegarder" class="f-btn-input" style=" background: #fff; border: 1px solid var(--twitter-color); padding: 10px; border-radius: 22px; color: var(--twitter-color); font-weight: bold; cursor: pointer;">  
                                    </span>
                                </div>
                            <form>
                                <?php if(isset($imgError)){echo '<div>'.$imgError.'</div>';}?>
                                <div class="profile-name-wrap">
                                    <div class="profile-name">
                                        <input type="text" name="screenName" value="<?php echo $user->screenName;?>"/>
                                    </div>
                                    <div class="profile-tname">@<?php echo $user->username;?></div>
                                </div>

                                <div class="profile-bio-wrap">
                                    <textarea class="status" name="bio"><?php echo $user->bio;?></textarea>
                                    <div class="hash-box">
                                        <ul>
                                        </ul>
                                    </div>
                                </div>

                                <div class="profile-extra-info">
                                    <div class="profile-extra-inner">
                                        <ul>
                                            <li>
                                                <div class="profile-ex-location">
                                                    <input id="cn" type="text" name="country" placeholder="Country" value="<?php echo $user->country;?>" />
                                                </div>
                                            </li>
                                            <?php if(isset($error)){echo '<div>'.$error.'</div>';}?>
                            </form>
                                        </ul>
                                    </div>
                            </div><!--PROFILE INFO INNER END-->
                        </div>
                        <!--PROFILE INFO WRAPPER END-->

                    </div><!-- in left wrap-->
                </div><!-- in left end-->
            </div><!--in full wrap end-->
        </div>

       
    </div>
    </div>
    <?php include('includes/sidebar-right.php'); ?>
</div>







<script src="<?php echo BASE_URL;?>assets/js/tab.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/notification.js"></script>
<script type="text/javascript">
$('#save').click(function(){
$('#editForm').submit();
}); 
</script>
</body>
</html>
    