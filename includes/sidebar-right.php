        <div class="right__sidebar">
            <div class="search-container">
                <a href="#" class="search-btn">
                    <i class="fa fa-search"></i>
                </a>
                <input type="text" name="search" placeholder="Recherche Twitter" class="search-input">
            </div>

            <div>
                <?php $getFromT->trends(); ?>
            </div>

            <div>
                <?php $getFromF->whoToFollow($user_id,$user_id);?>
            </div>

        </div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
        $(".trends__body").slice(0, 3).show()
        $(".btn").on("click", function(){
            $(".trends__body:hidden").slice(0, 3).slideDown()
            if ($(".trends__body:hidden").length == 0) {
                $(".btn").fadeOut('slow')
            }
        });
</script>
</body>
</html>