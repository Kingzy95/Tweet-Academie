<?php
    include ('core/init.php');

    $user_id = $_SESSION['user_id'];

    if (!empty($getFromU)) {
        $user = $getFromU->userData($user_id);
    }
    if (!empty($getFromM)) {
        $notify  = $getFromM->getNotificationCount($user_id);
    }

    if($getFromU->loggedIn() === false) {
    header('Location: '.BASE_URL.'index.php');
    }

    if(isset($_POST['tweet'])){
    $status = $getFromU->checkinput($_POST['status']);
    $tweetImage = '';
    if(!empty($status) or !empty($_FILES['file']['name'][0])){
      if(!empty($_FILES['file']['name'][0])) {
        $tweetImage = $getFromU->uploadImage($_FILES['file']);
      }
      if(strlen($status) > 140){
        $error = "The text of your tweet is too long";
      }
      $tweet_id = $getFromU->create('tweets', array('status' => $status, 'tweetBy' => $user_id, 'tweetImage' => $tweetImage, 'postedOn' => date('Y-m-d H:i:s')));
      preg_match_all("/#+([a-zA-Z0-9_]+)/i", $status, $hashtag);

      if(!empty($hashtag)){
          if (!empty($getFromT)) {
              $getFromT->addTrend($status);
          }
      }
      $getFromT->addMention($status, $user_id, $tweet_id);
      header('Location: home.php');
    }else{
      $error = "Type or choose image to tweet";
    }
    }
?>


<?php require_once 'includes/header.php'; ?>

<?php require_once 'includes/sidebar-left.php'; ?>

<?php require_once 'includes/main.php'; ?>

<?php echo require_once 'includes/tweet.php'; ?>

<?php require_once 'includes/sidebar-right.php'; ?>

<script type="text/javascript" src="assets/js/search.js"></script>
<script type="text/javascript" src="assets/js/hashtag.js"></script>
<script type="text/javascript" src="assets/js/follow.js"></script>
<script type="text/javascript" src="assets/js/like.js"></script>
<script type="text/javascript" src="assets/js/retweet.js"></script>
<script type="text/javascript" src="assets/js/popuptweets.js"></script>
<script type="text/javascript" src="assets/js/delete.js"></script>
<script type="text/javascript" src="assets/js/comment.js"></script>
<script type="text/javascript" src="assets/js/popupForm.js"></script>
<script type="text/javascript" src="assets/js/fetch.js"></script>
<script type="text/javascript" src="assets/js/messages.js"></script>
<script type="text/javascript" src="assets/js/notification.js"></script>
<script type="text/javascript" src="assets/js/postMessage.js"></script>