<?php


include 'core/init.php';

$user_id = $_SESSION['user_id'];
$user    = $getFromU->userData($user_id);
$notify  = $getFromM->getNotificationCount($user_id);

if (isset($_GET['username']) === true && empty($_GET['username']) === false) {
  $username = $getFromU->checkInput($_GET['username']);
  $profileId = $getFromU->userIdByUsername($username);
  $profileData = $getFromU->userData($profileId);
  $user_id = @$_SESSION['user_id'];
  $user = $getFromU->userData($user_id);
  $notify  = $getFromM->getNotificationCount($user_id);

 
  if($getFromU->loggedIn() === false){
    header('Location: index.php');
}
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $profileData->screenName.' (@'.$profileData->username.')'; ?></title>

    <!-- using online links -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/style.css">
</head>
<body>


<?php require_once 'includes/sidebar-left.php'; ?>

    <div class="main">

        <div class="page_title">
            <a href="home.php"><i class="fa fa-arrow-left"></i></a>
            <h2><?php echo $user->screenName; ?> <br><span><?php $getFromT->countTweets($user_id); ?> Tweets</span></h2>
        </div>
        <div class="profile-cover-wrap"> 
            <div class="profile-cover-inner">
                <div class="profile-cover-img">
                    <!-- PROFILE-COVER -->
                    <img src="<?php echo $user->profileCover; ?>"/>
                </div>
            </div>
        </div>
        <!--Profile Cover End-->

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
                                    <img src="<?php echo $user->profileImage; ?>"/>
                                </div>
                        
                                <div class="btn-edit">
                                    <span>
                                        <button class='f-btn' onclick=location.href='userEdit.php'>Éditer Profile</button>
                                    </span>
                                </div>

                                <div class="profile-name-wrap">
                                    <div class="profile-name">
                                        <a href="#"><?php echo $user->screenName; ?></a>
                                    </div>
                                    <div class="profile-tname">@<span class="username"><?php echo $user->username; ?></span></div>
                                </div>

                                <div class="profile-bio-wrap">
                                    <div class="profile-bio-inner"><?php echo $user->bio; ?></div>
                                </div>

                                <div class="profile-extra-info">
                                    <div class="profile-extra-inner">
                                        <ul>
                                          <?php if(!empty($profileData->country)){ ?>
                                            <li>
                                                <div class="profile-ex-location-i">
                                                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                </div>
                                                <div class="profile-ex-location">Lyon, France</div>
                                            </li>
                                          <?php } ?>
                                        </ul>						
                                    </div>
                                </div>

                                <div class="follower">
                                    <div class="follower-content">
                                        <div class="profile-following">
                                            <a href="#"><?php $getFromT->countTweets($user_id); ?><span> abonnements</span></a>
                                        </div>
                                        <div class="profile-followers">
                                            <a href="#"><?php $getFromT->countTweets($user_id); ?><span> abonnés</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--PROFILE INFO INNER END-->
                        </div>
                        <!--PROFILE INFO WRAPPER END-->

                    </div><!-- in left wrap-->
                </div><!-- in left end-->
            </div><!--in full wrap end-->
        </div>

        <!--PEN HEADER-->

        <!--PEN CONTENT-->
        <div class="content">
          <div class="content__inner">
            <div class="tabs">
              <div class="tabs__nav">
                <ul class="tabs__nav-list">
                  <li class="tabs__nav-item js-active">Tweets</li>
                  <li class="tabs__nav-item">Tweets et retweets</li>
                  <li class="tabs__nav-item">Médias</li>
                  <li class="tabs__nav-item">J'aime</li>
                </ul>
              </div>
            </div>
          </div>
        </div>

    <?php include 'includes/tweet.php'; ?>
    <?php include 'includes/sidebar-right.php'; ?>
    </div>
  </div>
  <div class="popupTweet"></div>
</div>

</body>
</html>