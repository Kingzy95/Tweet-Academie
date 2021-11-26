
    <?php

        if (!empty($getFromT)) {
        if (isset($user_id)) {
            $getFromT->tweets($user_id, 20);
            }
        }
        ?>

    </div>