<?php
require '/home/nanablog1114/jjjrop.com/lib/DBController.php';
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
      <link rel="stylesheet" type="text/css" href="/assets/stylesheets/reset_form.css">
      <link rel="stylesheet" type="text/css" href="/assets/stylesheets/reset.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  </head>
  <body>
    <main class="p-reset">
      <form class="p-reset-form" action="/action/passwordReset.php" method="post">
        <div class="p-reset-form__title">パスワード再設定</div>
        <div class="p-reset-form__text">メールに記載された文字列</div>
        <input class="p-reset-form__input" type="text" name="mail_pw">
        <div class="p-reset-form__text">新しいパスワード</div>
        <input class="p-reset-form__input" type="password" name="c_staff_resetPassword">
        半角英数 6文字〜20文字<br>
        (記号は任意)
        <div class="p-reset-form__text">新しいパスワード(再入力)</div>
        <input class="p-reset-form__input" type="password" name="c_staff_resetPassword_confirm">
        <input class="p-reset-form__button" type="submit" value="パスワード再設定">
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

    // アカウント設定画面のエラー表示
    var error = <?php echo $_SESSION["error"]; ?>;
    if (error["flag"]) {
      // エラーの種類によってモーダルを変える
      switch (error["error"]) {
        case "nullPassword": errormodal("入力エラー", "新しいパスワードを入力してください"); break;
        case "lessPassword": errormodal("入力エラー", "新しいパスワードは6文字以上(半角英数)<br>で入力してください"); break;
        case "ngPassword": errormodal("入力エラー", "新しいパスワードは半角英数(6文字以上)<br>で入力してください"); break;
        case "overPassword": errormodal("入力エラー", "新しいパスワードは20文字以下(半角英数)<br>で入力してください"); break;
        case "notMatchPassword": errormodal("入力エラー", "新しいパスワード(再入力)が一致しません"); break;
      }
      <?php $_SESSION["error"] = array(); ?>
    }

    
  </script>
  </body>
</html>

