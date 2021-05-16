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
            <li class="active__menu">
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
                        <img src="<?php echo $user->profileImage ?>" alt="">
                        <div class="sidebar-log">
                            <h5>Se déconnecter</h5>
                            <span>@<?php echo $user->username; ?></span>
                        </div>
                    </a>
                </div>
                
            </div>
        </div>