<?php

class Tweet extends User{
	protected $message;

 	public function __construct($pdo){
		$this->pdo = $pdo;
		// added new code for PHP 7
		$this->message  = new Message($this->pdo);
	}
 
	//$stmt = $this->pdo->prepare("SELECT * FROM `tweets` LEFT JOIN `users` ON `tweetBy` = `user_id` WHERE `tweetBy` = 2");

	public function tweets($user_id, $num){
	    $stmt = $this->pdo->prepare("SELECT * FROM `tweets` LEFT JOIN `users` ON `tweetBy` = `user_id` ORDER BY `tweetID` DESC");
	    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
	    $stmt->bindParam(":num", $num, PDO::PARAM_INT);
	    $stmt->execute();
	    $tweets = $stmt->fetchAll(PDO::FETCH_OBJ);

	    foreach ($tweets as $tweet) {
	      $likes = $this->likes($user_id, $tweet->tweetID);
	      $retweet = $this->checkRetweet($tweet->tweetID, $user_id);
	      $user = $this->userData($tweet->retweetBy);
		  echo '<div class="tweet__box">
					<div class="tweet__left">
						<img src="'.$tweet->profileImage.'">
					</div>
					<div class="tweet__body">
						<div class="tweet__header">
							<a href="#"><p class="tweet__name">'.$tweet->screenName.'</p></a>
							<p class="tweet__username">@'.$tweet->username.'</p>
							<p class="tweet__date"> &nbsp;&bull;&nbsp; '.$this->timeAgo($tweet->postedOn).'</p>
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
	}
  
	public function getUserTweets($user_id){
		$stmt = $this->pdo->prepare("SELECT * FROM `tweets` LEFT JOIN `users` ON `tweetBy` = `user_id` WHERE `tweetBy` = :user_id AND `retweetID` = '0' OR `retweetBy` = :user_id ORDER BY `tweetID` DESC");
		$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	public function addLike($user_id, $tweet_id, $get_id){
		$stmt = $this->pdo->prepare("UPDATE `tweets` SET `likesCount` = `likesCount`+1 WHERE `tweetID` = :tweet_id");
		$stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
		$stmt->execute();

		$this->create('likes', array('likeBy' => $user_id, 'likeOn' => $tweet_id));
	
		if($get_id != $user_id){
			//this fixed php 7 error for non static methods
			$this->message->sendNotification($get_id, $user_id, $tweet_id, 'like');
		}
	}

	public function unLike($user_id, $tweet_id, $get_id){
		$stmt = $this->pdo->prepare("UPDATE `tweets` SET `likesCount` = `likesCount`-1 WHERE `tweetID` = :tweet_id");
		$stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
		$stmt->execute();

		$stmt = $this->pdo->prepare("DELETE FROM `likes` WHERE `likeBy` = :user_id and `likeOn` = :tweet_id");
		$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
		$stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
		$stmt->execute(); 
	}

	public function likes($user_id, $tweet_id){
		$stmt = $this->pdo->prepare("SELECT * FROM `likes` WHERE `likeBy` = :user_id AND `likeOn` = :tweet_id");
		$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
		$stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	
	public function getTrendByHash($hashtag){
		$stmt = $this->pdo->prepare("SELECT * FROM `trends` WHERE `hashtag` LIKE :hashtag LIMIT 5");
		$stmt->bindValue(":hashtag", $hashtag.'%');
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	public function getMension($mension){
		$stmt = $this->pdo->prepare("SELECT `user_id`,`username`,`screenName`,`profileImage` FROM `users` WHERE `username` LIKE :mension OR `screenName` LIKE :mension LIMIT 5");
		$stmt->bindValue("mension", $mension.'%');
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);

	}

	public function addTrend($hashtag){
		preg_match_all("/#+([a-zA-Z0-9_]+)/i", $hashtag, $matches);
		if($matches){
			$result = array_values($matches[1]);
		}
		$sql = "INSERT INTO `trends` (`hashtag`, `createdOn`) VALUES (:hashtag, CURRENT_TIMESTAMP)";
		foreach ($result as $trend) {
			if($stmt = $this->pdo->prepare($sql)){
				$stmt->execute(array(':hashtag' => $trend));
			}
		}
	}

	public function addMention($status,$user_id, $tweet_id){
		if(preg_match_all("/@+([a-zA-Z0-9_]+)/i", $status, $matches)){
			if($matches){
				$result = array_values($matches[1]);
			}
			$sql = "SELECT * FROM `users` WHERE `username` = :mention";
			foreach ($result as $trend) {
				if($stmt = $this->pdo->prepare($sql)){
					$stmt->execute(array(':mention' => $trend));
					$data = $stmt->fetch(PDO::FETCH_OBJ);
				}
			}

			if($data->user_id != $user_id){
				//This fixed PHP 7 error for non static methods
				$this->message->sendNotification($data->user_id, $user_id, $tweet_id, 'mention');
			}
		}
	}

	public function getTweetLinks($tweet){
		$tweet = preg_replace("/(https?:\/\/)([\w]+.)([\w\.]+)/", "<a href='$0' target='_blink'>$0</a>", $tweet);
		$tweet = preg_replace("/#([\w]+)/", "<a href='http://localhost:8888/twitter/hashtag/$1'>$0</a>", $tweet);		
		$tweet = preg_replace("/@([\w]+)/", "<a href='http://localhost:8888/twitter/$1'>$0</a>", $tweet);
		return $tweet;		
	}

	public function getPopupTweet($tweet_id){
		$stmt = $this->pdo->prepare("SELECT * FROM `tweets`,`users` WHERE `tweetID` = :tweet_id AND `tweetBy` = `user_id`");
		$stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_OBJ);
	}

	public function retweet($tweet_id, $user_id, $get_id, $comment){
		$stmt = $this->pdo->prepare("UPDATE `tweets` SET `retweetCount` = `retweetCount`+1 WHERE `tweetID` = :tweet_id AND `tweetBy` = :get_id");
		$stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
		$stmt->bindParam(":get_id", $get_id, PDO::PARAM_INT);
		$stmt->execute();

		$stmt = $this->pdo->prepare("INSERT INTO `tweets` (`status`,`tweetBy`,`retweetID`,`retweetBy`,`tweetImage`,`postedOn`,`likesCount`,`retweetCount`,`retweetMsg`) SELECT `status`,`tweetBy`,`tweetID`,:user_id,`tweetImage`,`postedOn`,`likesCount`,`retweetCount`,:retweetMsg FROM `tweets` WHERE `tweetID` = :tweet_id");
		$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
		$stmt->bindParam(":retweetMsg", $comment, PDO::PARAM_STR);
		$stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
		$stmt->execute();

		//This fixed PHP 7 error for non static methods
		$this->message->sendNotification($get_id, $user_id, $tweet_id, 'retweet');

 	}

	public function checkRetweet($tweet_id, $user_id){
		$stmt = $this->pdo->prepare("SELECT * FROM `tweets` WHERE `retweetID` = :tweet_id AND `retweetBy` = :user_id or `tweetID` = :tweet_id and `retweetBy` = :user_id");
		$stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
		$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function tweetPopup($tweet_id){
		$stmt = $this->pdo->prepare("SELECT * FROM `tweets`,`users` WHERE `tweetID` = :tweet_id and `user_id` = `tweetBy`");
		$stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_OBJ);
	}

	public function comments($tweet_id){
		$stmt = $this->pdo->prepare("SELECT * FROM `comments` LEFT JOIN `users` ON `commentBy` = `user_id` WHERE `commentOn` = :tweet_id");
		$stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}
	//$stmt = $this->pdo->prepare("SELECT COUNT(`tweetID`) AS `totalTweets` FROM `tweets` WHERE `tweetBy` = :user_id AND `retweetID` = '0' OR `retweetBy` = :user_id");

	public function countTweets($user_id){
		$stmt = $this->pdo->prepare("SELECT COUNT(`tweetID`) AS `totalTweets` FROM `tweets`");
		$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
		$stmt->execute();
		$count = $stmt->fetch(PDO::FETCH_OBJ);
		echo $count->totalTweets;
	}

	public function countFollowing($user_id){
		$stmt = $this->pdo->prepare("SELECT COUNT(``) AS `totalFollowing` FROM ");
	}

	public function countLikes($user_id){
		$stmt = $this->pdo->prepare("SELECT COUNT(`likeID`) AS `totalLikes` FROM `likes` WHERE `likeBy` = :user_id");
		$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
		$stmt->execute();
		$count = $stmt->fetch(PDO::FETCH_OBJ);
		echo $count->totalLikes;
	} 

	public function trends(){
		$stmt = $this->pdo->prepare("SELECT *, COUNT(`tweetID`) AS `tweetsCount` FROM `trends` INNER JOIN `tweets` ON `status` LIKE CONCAT('%#',`hashtag`,'%') OR `retweetMsg` LIKE CONCAT('%#',`hashtag`,'%') GROUP BY `hashtag` ORDER BY `tweetID` DESC LIMIT 3");
		$stmt->execute();	
		$trends = $stmt->fetchAll(PDO::FETCH_OBJ);
		echo '<div class="trends__container"><div class="trends__box"><div class="trends__header"><p>Tendances</p><i class="fa fa-cog"></i></div>';
		foreach ($trends as $trend) {
			echo '<div class="trends__body">
					<div class="trend">
						<span>Tendance dans la categorie France</span>
						<a href="'.BASE_URL.'hashtag/'.$trend->hashtag.'"><p>#'.$trend->hashtag.'</p></a>
						<span>'.$trend->tweetsCount.' Tweets</span>
					</div>
				</div>';
		}
		echo'<div class="trends__show-more">
				<button class="btn">Voir plus</button>
			</div>';		
		}

	public function getTweetsByHash($hashtag){
		$stmt = $this->pdo->prepare("SELECT * FROM `tweets` LEFT JOIN `users` ON `tweetBy` = `user_id` WHERE `status` LIKE :hashtag OR `retweetMsg` LIKE :hashtag");
		$stmt->bindValue(":hashtag", '%#'.$hashtag.'%', PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	public function getUsersByHash($hashtag){
		$stmt = $this->pdo->prepare("SELECT DISTINCT * FROM `tweets` INNER JOIN `users` ON `tweetBy` = `user_id` WHERE `status` LIKE :hashtag OR `retweetMsg` LIKE :hashtag GROUP BY `user_id`");
		$stmt->bindValue(":hashtag", '%#'.$hashtag.'%', PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}
	
}
?>	