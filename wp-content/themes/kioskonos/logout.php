<?php
@session_start();
/**
 * Template Name: Logout
 *
 */

logout();

header('Location: ' . get_bloginfo('wpurl'));
exit();

?>
