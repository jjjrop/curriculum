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
    <title>カリキュラム管理</title>
      <link rel="stylesheet" type="text/css" href="/assets/stylesheets/forgot_form.css">
      <link rel="stylesheet" type="text/css" href="/assets/stylesheets/reset.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  </head>
  <body>
    <main class="l-forgot-wrapper">
      <form class="p-forgot-form" action="/action/passwordForgot.php" method="post">
      <div class="p-forgot-form__title">パスワード再発行</div>
        <div class="p-forgot-form__text">ログインID</div>
        <input class="p-forgot-form__input" type="text" name="c_staff_user_number_forgot">
        <div class="p-forgot-form__text">生年月日</div>
        <input class="p-forgot-form__input" type="date" name="c_staff_birth_date_forgot" value="1990-11-11">
        <input class="p-forgot-form__button" type="submit" value="パスワード再発行">
        <div class="p-forgot-form__link"><a class="p-forgot-form__forgot__link" href="https://jjjrop.com/login_form.php">ログイン画面</a>へ戻る</div>
      </form>
      <?php include("/home/nanablog1114/jjjrop.com/public_html/modal.php"); ?>
    </main>
    <footer>
    </footer>



  <script>
    // モーダル
    function modal(title, text) {
      $(".p-modal-back").addClass("block");
      if (title!=="") {
        $(".c-modal__title").addClass("block");
        $(".c-modal__title").text(title);
      }
      if (text!=="") {
        $(".c-modal__text").addClass("block");
        $(".c-modal__text").html(text);
      }
      $(".c-modal__button").click(function() {
        $(".p-modal-back").removeClass("block");
      });
    }

    // エラーモーダル
    function errormodal(title, text) {
      $(".p-modal-back").addClass("block");
      $(".c-modal__icon").addClass("block");
      if (title!=="") {
        $(".c-modal__title").addClass("block");
        $(".c-modal__title").html(title);
      }
      if (text!=="") {
        $(".c-modal__text").addClass("block");
        $(".c-modal__text").html(text);
      }
      $(".c-modal__button").click(function() {
        $(".p-modal-back").removeClass("block");
      });
    }

    // 処理成功のモーダル表示
    var success = <?php echo $_SESSION["success"]; ?>;
    if (success["flag"] && success["success"]=="passwordForgot") {
      // 処理成功のモーダルを変える
        modal("", "メールを送信しました");
      <?php $_SESSION["success"] = array(); ?>
    }
  </script>
  </body>
</html>

