<?php
//ob_clean();
session_start();
session_unset();
session_destroy();
session_write_close();
header("location: login.html");
?>