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
    <!-- <title>カリキュラム管理</title> -->
    <link rel="stylesheet" type="text/css" href="/assets/stylesheets/signup_form.css">
    <link rel="stylesheet" type="text/css" href="/assets/stylesheets/reset.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  </head>
    <section class="l-signup-wrapper">
      <form class="p-signup-csvForm" enctype="multipart/form-data" action="/action/csvSignup.php" method="POST">
        <div class="p-signup-form__title">csvで一括登録<span class="u-qiestion" id="js-question">？</span></div>
        <input class="u-marginTop" name="userfile" type="file" />
        <input class="p-signup-csvForm__registButton" type="submit" value="送信" />
      </form>
      <br><br><span class="u-or">または</span><br>
      <form class="p-signup-form" action="/action/signupAction.php" method="post">
        <div class="p-signup-form__title">アカウント作成</div>
        <div class="p-signup-form__wrapper">
          <div class="p-signup-form__text">氏名</div>
          <input class="p-signup-form__input" type="text" name="c_staff_name_signup">
          <div class="p-signup-form__text">ユーザーID</div>
          <input class="p-signup-form__input" type="text" name="c_staff_user_number_signup">
          <div  class="p-signup-form__text">マネージャー or スタッフ</div>
          <select class="p-signup-form__selection" name="c_staff_role_signup">
            <option value="manager">マネージャー</option>
            <option value="staff" selected>スタッフ</option>
          </select>
          <input class="p-signup-form__makeButton" type="submit" value="作成">
        </div>
      </form>
    </section>
    
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

    $("#js-question").click(function(){
      var border = "ーーーーーーーーーーーーーーーーー";
      modal("csv入力例", "<div>" + border + "<br>山田次郎,j-yamada,staff<br>上田奈緒子,n-ueda,staff<br>矢部真之介,s-yabe,manager<br>：<br>" + border + "</div><div><h3>1番右の列について：</h3>管理者の場合：manager<br>研修生の場合：staff</div>");
    });

    // 以下処理
    // if (signup.length !== 0) {
    
    // アカウント作成成功モーダル
    var signup = <?php echo $_SESSION["signup"]; ?>;
    if (signup["flag"]) {
      var title = "アカウントを作成しました";
      var name = signup["name"];
      var user_number = signup["user_number"];
      var password = signup["password"]
      var text = "氏名：" + name + "<br>ユーザーID：" + user_number + "<br>パスワード：" + password;
      modal(title, text);
      <?php $_SESSION["signup"] = array(); ?>
    }

    // csvでアカウント作成成功モーダル
    var csvSignups = <?php echo $_SESSION["csvSignup"]; ?>;
    var text ="";
    var p = 0;
    var q = 0;
    csvSignups.forEach(function(csvSignup) {
      p += 1;
      if (csvSignup.flag) {
        t = '<div class="u-small">' + '名前：' + csvSignup.name + '　ログインID：' + csvSignup.user_number + '　パスワード：' + csvSignup.password + '</div>';
        text = text + t;
        q += 1;
      }
    });
    if (p==q && p!==0 && q!==0) {
      var title = "以下のアカウントを作成しました"
      modal(title, text);
      <?php $_SESSION["csvSignup"] = array(); ?>
    }
  });
  
  </script>
</html>