<?php 

	include 'core/init.php';
    $user_id = $_SESSION['user_id'];
    if (!empty($getFromU)) {
        $user    = $getFromU->userData($user_id);
    }
    if (!empty($getFromM)) {
        $notify  = $getFromM->getNotificationCount($user_id);
    }

	if(isset($_GET['hashtag']) && !empty($_GET['hashtag'])){
        if (!empty($getFromU)) {
            $hashtag  = $getFromU->checkInput($_GET['hashtag']);
        }
		$user_id  = @$_SESSION['user_id'];
        if (!empty($getFromU)) {
            $user     = $getFromU->userData($user_id);
        }
        if (!empty($getFromT)) {
            $tweets   = $getFromT->getTweetsByHash($hashtag);
        }
        if (!empty($getFromT)) {
            $accounts = $getFromT->getUsersByHash($hashtag);
        }
        if (!empty($getFromM)) {
            $notify  = $getFromM->getNotificationCount($user_id);
        }

   	}else{
		header('Location: hashtag.php');
	}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>#<?php echo $hashtag;?> Hashtag sur TweetAcademy</title>

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
                <a href="home.php" class="logo"><img src="./assets/images/logo.png"></a>
            </li>
            <li>
                <a href="home.php"><i class="fa fa-home"></i><span> Accueil</span></a>
            </li>
            <li class="active__menu">
                <a href="hashtag.php"><i class="fa fa-hashtag"></i><span> Explore</span></a>
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
            <li>
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
                <h2>#<?php echo $hashtag;?> <br><span><?php echo $user->screenName; ?></span></h2>
            </div>
           
            <?php if(strpos($_SERVER['REQUEST_URI'], '?f=photos')):?>
           
            <div class="hash-img-wrapper"> 
                <div class="hash-img-inner">
                <?php 
                    foreach ($tweets as $tweet) {
                        $likes        = $getFromT->likes($user_id, $tweet->tweetID);
                        $retweet      = $getFromT->checkRetweet($tweet->tweetID, $user_id);
                        $user         = $getFromT->userData($tweet->retweetBy);
                        
                        if(!empty($tweet->tweetImage)){
                        echo '';
                        }
                    }
                ?>

                </div>
            </div> 
            <?php elseif(strpos($_SERVER['REQUEST_URI'], '?f=users')):?>
 
            <?php else:?>
          
                <?php 
                    foreach ($tweets as $tweet) {
                    $likes        = $getFromT->likes($user_id, $tweet->tweetID);
                    $retweet      = $getFromT->checkRetweet($tweet->tweetID, $user_id);
                    $user         = $getFromT->userData($tweet->retweetBy);
                        
                        echo '<div class="tweet__box">
                                <div class="tweet__left">
                                    <images src="'.$tweet->profileImage.'" alt="" />
                                </div>
                                <div class="tweet__body">
                                    <div class="tweet__header">
                                        <p class="tweet__name">'.$tweet->screenName.'</p>
                                        <p class="tweet__username">@'.$tweet->username.'</p>
                                        <p class="tweet__date"> &nbsp;&bull;&nbsp; '.$getFromU->timeAgo($tweet->postedOn).'</p>
                                    </div>

                                    <p class="tweet__text">'.$tweet->status.'</p>
                            
                                    <div class="tweet__icons">
                                        <ul>
                                            <li><button class="icons"><i class="far fa-comment"></i></button></li>
                                            <li>'.((isset($retweet['retweetID']) ? $tweet->tweetID === $retweet['retweetID'] : '') ?
                                                '<button class="retweeted" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($tweet->retweetCount > 0) ? $tweet->retweetCount : '').'</span></button>' :
                                                '<button class="retweet" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($tweet->retweetCount > 0) ? $tweet->retweetCount : '').'</span></button>').'
                                            </li>
                                            <li>'.((isset($likes['likeOn']) ? $likes['likeOn'] === $tweet->tweetID : '') ? 
                                                '<button class="unlike-btn" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-heart" aria-hidden="true"></i><span class="likesCounter">'.(($tweet->likesCount > 0) ? $tweet->likesCount : '' ).'</span></button>' : 
                                                '<button class="like-btn" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter">'.(($tweet->likesCount > 0) ? $tweet->likesCount : '' ).'</span></button>').'
                                            </li>
                                            <li><button class="icons"><i class="fa fa-share"></i></button></li>
                                            <li><button class="icons"><i class="far fa-chart-bar"></i></button></li>
                                        </ul>
                                    </div>
                                </div>
                                
                            
                                <div class="tweet__del">
                                    <div class="dropdown">
                                        <button class="dropbtn"><span class="fa fa-ellipsis-h"></span></button>
                                        <div class="dropdown-content">
                                            <a href="#"><i class="far fa-trash-alt">Supprimer</i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>';

                    }
                ?>
            
        <?php endif;?>
            
        </div>
    <?php include 'includes/sidebar-right.php'; ?>