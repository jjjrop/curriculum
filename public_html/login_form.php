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
      <link rel="stylesheet" type="text/css" href="/assets/stylesheets/login_form.css">
      <link rel="stylesheet" type="text/css" href="/assets/stylesheets/reset.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  </head>
  <body>
    <main class="p-login">
      <form class="p-login-form" action="/action/login.php" method="post">
        <div class="p-login-form__title">ログイン</div>
        <div class="p-login-form__text">ユーザー名</div>
        <input class="p-login-form__input" type="text" name="c_staff_user_number_login">
        <div class="p-login-form__text">パスワード</div>
        <input class="p-login-form__input" type="password" name="c_staff_password_login">
        <input class="p-login-form__button" type="submit" value="ログイン">
        <div class="p-login-form__forgot">パスワードを忘れた方は<a class="p-login-form__forgot__link" href="https://jjjrop.com/forgot_form.php">こちら</a></div>
      </form>
      <?php include("/home/nanablog1114/jjjrop.com/public_html/modal.php"); ?>
    </main>
    <footer>
    </footer>
  <script>
  $(function() {
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
    if (success["flag"] && success["success"]=="passwordReset") {
      // 処理成功のモーダルを変える
        modal("", "パスワードを更新しました");
      <?php $_SESSION["success"] = array(); ?>
    }
    <?php $_SESSION = array(); ?>
  });
  </script>
  </body>
</html>

