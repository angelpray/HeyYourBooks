<?php
include_once './lib/func.php';
session_start();
unset($_SESSION['user']);
 ?>
 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title></title>
   </head>
   <body>

   </body>
    <script src="./static/js/jquery-1.10.2.min.js"></script>
   <script>
   $(document).ready(function(){
     location.href='index.html';
   })
   </script>
 </html>
