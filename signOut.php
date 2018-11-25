<?php
    /**
     * Created by PhpStorm.
     * User: Mid
     * Date: 11/22/2018
     * Time: 6:25 PM
     */
    session_start();
    session_destroy();
    header('Location: index.php');
    ?>