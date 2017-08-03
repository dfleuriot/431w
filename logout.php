<?php
   session_start();
   
   if(session_destroy()) {
      header("Location: index.php");
      setcookie(email, "", time() + (1800), "/");
      setcookie(name, "", time() + (1800), "/");
      setcookie(UID, "", time() + (1800), "/");
      setcookie(sup, "", time() - (1800), "/");

   }

?>