<div class="main">
    <p class="page__title">
        <a href="user.php">
            <img src="assets/img/user1.jpg">
        </a> Accueil</p>
    <div class="tweet__box tweet__add">
        <div class="tweet__left">
            <img src="
                <?php
                    if (!empty($user)) {
                        echo $user->profileImage;
                    }
                ?>"
                 alt=""
            >
        </div>
        <div class="tweet__body">
            <form method="post" enctype="multipart/form-data">
                <label>
                    <textarea class="post_text"  maxlength="141" name="status" placeholder="Écrivez quelque chose!" rows="2" cols="50"></textarea>
                </label>
                <div class="hash-box">
                    <ul>
                    </ul>
                </div>
                <div class="tweet__icons-wrapper">
                    <div class="tweet__icons-add">
                        <ul>
                            <li>
                                <input type="file" name="file" id="file" style="display: none" />
                                <label for="file"><i class="fa fa-camera" aria-hidden="true"></i></label>
                                <span class="tweet-error"><?php if(isset($error)){echo $error;}else if(isset($imgError)){echo $imgError;} ?></span>
                            </li>
                        </ul>
                        <i class="fa fa-chart-bar"></i>
                        <i class="far fa-smile"></i>
                        <i class="far fa-calendar-alt"></i>
                    </div>
                    <div class="d-f">
                        <span id="count">140</span>
                        <input type="submit" name="tweet" value="tweet" class="button__tweet"/>
                    </div>
            </form>
        </div>
    </div>
</div>