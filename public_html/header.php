<?php
require_once '/home/nanablog1114/jjjrop.com/lib/DBController.php';
require_once '/home/nanablog1114/jjjrop.com/lib/GeneralController.php';
if (!isset($_SESSION["c_staff_id"])) {
  header("Location: https://jjjrop.com/login_form.php");
  exit;
}
function h($text)
{
  return htmlspecialchars($text, ENT_QUOTES, "UTF-8");
}

$c_staff_id = $_SESSION["c_staff_id"];
$c_staff = DBController::selectOne('select * from c_staff where id = ' . $c_staff_id);
$c_staff_role = $_SESSION["c_staff_role"];

if (isset($_POST["sub1"])) {
  $_SESSION["thisPage"] = h($_POST["sub1"]);
}

if (!isset($_SESSION["thisPage"])) {
  if ($c_staff_role == "staff") {
    $_SESSION["thisPage"] = "カリキュラム";
  } else if ($c_staff_role == "manager") {
    $_SESSION["thisPage"] = "シート";
  }
}

?>

<!-- <?php echo GeneralController::seasonAction(); ?> -->
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>カリキュラム管理</title>
    <link rel="stylesheet" href="/assets/stylesheets/reset.css" type="text/css">
    <link rel="stylesheet" href="/assets/stylesheets/header.css" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script>
    $(function() {
      $(document).click(function(e){
        if ($(e.target).closest("#js-header__icon").length && !$("#js-headerList").hasClass("block")) {
        // if (true) {
          $("#js-headerList").addClass("block");
        } else if (!$(e.target).closest("#js-headerList").length) {
          $("#js-headerList").removeClass("block");
        }
      });

      $("#js-accountSetting__form").hide();
      $("#js-repassword__form").hide();
      $("#js-delete__form").hide();

      $("#js-account").click(function() {
        $("#js-accountSetting").fadeIn(300);
        $("#js-accountSetting__form").slideToggle(300);
      });

      $("#js-accountSetting__close").click(function() {
        $("#js-accountSetting").fadeOut(300);
        $("#js-accountSetting__form").fadeOut(300);
      });

      $("#js-repassword1").click(function() {
        $("#js-repassword").fadeIn(300);
        $("#js-repassword__form").slideToggle(300);
      });

      $("#js-repassword__close").click(function() {
        $("#js-repassword").fadeOut(300);
        $("#js-repassword__form").fadeOut(300);
      });
    });
    </script>
  </head>
  <body>
    <header class="c-header">

      <!-- 管理者用画面 -->
      <?php if ($c_staff_role == "manager"): ?>
      <form method="POST" action="" class="c-header-form">
        <input class="c-header-form__button <?php if ($_SESSION["thisPage"]=="シート") echo "u-selected"; ?>" type="submit" value="シート" name="sub1">　
        <input class="c-header-form__button <?php if ($_SESSION["thisPage"]=="レポート") echo "u-selected"; ?>" type="submit" value="レポート" name="sub1">　
        <input class="c-header-form__button <?php if ($_SESSION["thisPage"]=="アカウント作成") echo "u-selected"; ?>" type="submit" value="アカウント作成" name="sub1">　
        <input class="c-header-form__button <?php if ($_SESSION["thisPage"]=="ログ") echo "u-selected"; ?>" type="submit" value="ログ" name="sub1">　
      </form>
      <?php endif; ?>

      <!-- 研修者用画面 -->
      <?php if ($c_staff_role == "staff"): ?>
      <form method="POST" action="" class="c-header-form">
        <input class="c-header-form__button <?php if ($_SESSION["thisPage"]=="カリキュラム") echo "u-selected"; ?>" type="submit" value="カリキュラム" name="sub1">　
        <input class="c-header-form__button <?php if ($_SESSION["thisPage"]=="レポート") echo "u-selected"; ?>" type="submit" value="レポート" name="sub1">　
        <input class="c-header-form__button <?php if ($_SESSION["thisPage"]=="シート") echo "u-selected"; ?>" type="submit" value="シート" name="sub1">　
      </form>
      <?php endif; ?>

      <div class="p-header-account">
        <div class="p-header-account__name"><?php echo h($c_staff["name"]); ?></div>
        <div class="p-header-account__icon" id="js-header__icon">
          <img class="p-header-account__image" src="/assets/images/accountIcon2.png">
        </div>
        <!-- 続き -->
        <ul class="p-header-account-list" id="js-headerList">
          <li class="p-header-account-list__item" id="js-account">
            <img class="p-header-account-list__icon" src="/assets/images/account.png">
            　アカウント設定
          </li>
          <li class="p-header-account-list__item" id="js-repassword1">
            <img class="p-header-account-list__icon" src="/assets/images/password.png">
            　パスワード再設定
          </li>
          <li class="p-header-account-list__item js-logout">
            <a href="/login_form.php" class="p-header-account-list__link">
              <img class="p-header-account-list__icon" src="/assets/images/logout.png">　ログアウト
            </a>
          </li>
        </ul>
      </div>
      <div class="p-header-modal" id="js-accountSetting">
        <form class="p-header-accountSetting" id="js-accountSetting__form" action="/action/accountSetting.php" method="post">
          <h2 class="p-header-accountSetting__title">アカウント設定</h2>
          <div class="p-header-accountSetting__box">
            <p class="p-header-accountSetting__text">名前</p>
            <input class="p-header-accountSetting__input" type="input" name="c_staff_name_setting" value="<?php echo h($c_staff['name']); ?>" placeholder="<?php echo h($c_staff["name"]); ?>">
            <p class="p-header-accountSetting__text">ユーザーID</p>
            <input class="p-header-accountSetting__input" type="input" name="c_staff_user_number_setting" value="<?php echo h($c_staff['user_number']); ?>" placeholder="<?php echo h($c_staff["user_number"]); ?>">
            <p class="p-header-accountSetting__text">生年月日</p>
            <input class="p-header-accountSetting__input" type="date" name="c_staff_birth_date_setting" value="<?php echo $c_staff["birth_date"]; ?>" placeholder="<?php echo $c_staff["birth_date"]!==NULL ? h($c_staff["birth_date"]) : "1990-01-01"; ?>">
            <br>※パスワードを忘れた際に必要です
            <p class="p-header-accountSetting__text">メールアドレス</p>
            <input class="p-header-accountSetting__input" type="input" name="c_staff_email_setting" value="<?php echo h($c_staff['email']); ?>" placeholder="<?php echo h($c_staff["email"]); ?>">
            <br>※パスワードを忘れた際に必要です
            <div class="p-header-accountSetting__buttons">
              <div class="p-header-accountSetting__close" id="js-accountSetting__close">閉じる</div>
              <input class="p-header-accountSetting__save" type="submit" value="保存">
            </div>
          </div>
        </form>
      </div>

      <div class="p-header-modal" id="js-repassword">
        <form class="p-header-accountSetting" id="js-repassword__form" method="post" action="/action/passwordSetting.php">
          <h2 class="p-header-accountSetting__title">パスワード再設定</h2>
          <div class="p-header-accountSetting__box">
            <p class="p-header-accountSetting__text">現在のパスワード</p>
            <input class="p-header-accountSetting__input" type="password" name="prev-password">
            <p class="p-header-accountSetting__text">新しいパスワード</p>
            <input class="p-header-accountSetting__input" type="password" name="new-password">
            <div>半角英数 6文字〜20文字<br>(記号は任意)</div>
            <p class="p-header-accountSetting__text">新しいパスワード(再入力)</p>
            <input class="p-header-accountSetting__input" type="password" name="new-password__confirm">
            <div class="p-header-accountSetting__buttons">
              <div class="p-header-accountSetting__close" id="js-repassword__close">閉じる</div>
              <input class="p-header-accountSetting__save" type="submit" value="パスワード更新">
            </div>
          </div>
        </form>
      </div>

      <div class="p-header-modal" id="js-delete">
        <form class="p-header-accountSetting" id="js-delete__form" action="/action/accountDelete.php" method="post">
          <h2 class="p-header-accountSetting__title">アカウント削除</h2>
          <div class="p-header-accountSetting__box">
            <p class="p-header-accountSetting__text">アカウント名</p>
            <input class="p-header-accountSetting__input js-delete_staffName u-readonly" type="text" name="delete_staffName" value="" readonly>
            <p class="p-header-accountSetting__text">ユーザーID</p>
            <input class="p-header-accountSetting__input js-delete_staffId u-readonly" type="text" name="delete_staffId" value="" readonly>
            <div class="p-header-accountSetting__buttons">
              <div class="p-header-accountSetting__close" id="js-delete__close">閉じる</div>
              <input class="p-header-accountSetting__delete" type="submit" value="削除">
            </div>
          </div>
        </form>
      </div>
    </header>
    <main class="l-main">