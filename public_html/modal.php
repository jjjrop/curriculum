<?php
require_once '/home/nanablog1114/jjjrop.com/lib/DBController.php';
// $server = "mysql10030.xserver.jp";
// $userName = "nanablog1114_db";
// $password = "sibrin103";
// $dbName = "nanablog1114_db";

DBController::DBConnect();

// $c_staff_id = 1;

// $c_status = DBController::select('select * from c_status where c_staff_id = ' . $c_staff_id);
// $c_finished_date = DBController::select('select * from c_finished_date where c_staff_id = ' . $c_staff_id);
// $c_target_date = DBController::select('select * from c_target_date where c_staff_id = ' . $c_staff_id);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Practice</title>
    <link rel="stylesheet" type="text/css" href="/assets/stylesheets/modal.css">
    <link rel="stylesheet" type="text/css" href="/assets/stylesheets/reset.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  </head>

  <div class="p-modal-back">
    <div class="c-modal">
      <div class="c-modal__icon">
        <img class="c-modal__image" src="/assets/images/attention.png">
      </div>
      <div class="c-modal__title"></div>
      <div class="c-modal__text"></div>
      <div class="c-modal__button">
        OK
      </div>
    
    
    </div>  
  </div>
    
  <script>
  $(function() {

    function modal(title, text) {
      $(".p-modal-back").addClass("block");
      if (title!=="") {
        $(".c-modal__title").addClass("block");
        $(".c-modal__title").text(title);
      }
      if (text!=="") {
        $(".c-modal__text").addClass("block");
        $(".c-modal__text").text(text);
      }
      $(".c-modal__button").click(function() {
        $(".p-modal-back").removeClass("block");
      });
    }

    function errormodal(title, text) {
      $(".p-modal-back").addClass("block");
      $(".c-modal__icon").addClass("block");
      if (title!=="") {
        $(".c-modal__title").addClass("block");
        $(".c-modal__title").text(title);
      }
      if (text!=="") {
        $(".c-modal__text").addClass("block");
        $(".c-modal__text").text(text);
      }
      $(".c-modal__button").click(function() {
        $(".p-modal-back").removeClass("block");
      });
    }

  })
  
  </script>
</html>