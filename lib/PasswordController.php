<?php
require_once '/home/nanablog1114/jjjrop.com/lib/DBController.php';
require_once '/home/nanablog1114/jjjrop.com/lib/ValidationController.php';

/**
 * PasswordController
 */
class PasswordController
{
  /**
   * パスワードを忘れたユーザー情報を取得し、メールを送信する
   */
  public static function passwordForgotAction()
  {
    DBController::DBConnect();

    $c_staff_user_number_forgot = $_POST["c_staff_user_number_forgot"];
    $c_staff_birth_date_forgot = $_POST["c_staff_birth_date_forgot"];
    $date = date("Y-m-d H:i:s");

    $c_staff_birth_date = DBController::selectOne("select * from c_staff where user_number = '" . $c_staff_user_number_forgot . "'")["birth_date"];
    $c_staff_id = DBController::selectOne("select * from c_staff where user_number = '" . $c_staff_user_number_forgot . "'")["id"];
    $c_staff_email = DBController::selectOne("select * from c_staff where user_number = '" . $c_staff_user_number_forgot . "'")["email"];

    if ($c_staff_birth_date_forgot == $c_staff_birth_date && $c_staff_birth_date_forgot!=="") {
      $restert = true;
      while ($restert) {
        $password = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 8);
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $restert = is_array(DBController::selectArray("select * from s_pw_reset where password = '" . $password_hash . "'"));
      }

      mb_language("Japanese");
      mb_internal_encoding("UTF-8");
      $to = $c_staff_email;
      $title = "パスワードリセットのお知らせ";
      $content = "以下の文字列をパスワード再設定画面に入力してください。\n\n" . $password . "\n\n パスワード再設定画面：\n https://jjjrop.com/reset_form.php";
      $mailfrom ="From:" . mb_encode_mimeheader("カリキュラム管理システム");
      if(mb_send_mail($to, $title, $content, $mailfrom)){
        DBController::insert("insert into s_pw_reset(c_staff_id, done, password, deleted, created_at, updated_at) values (" . $c_staff_id . "," . 0 . ",'" . $password_hash . "'," . 0 . ",'" . $date . "','" . $date . "')");
        $_SESSION["success"] = json_encode(array("success" => "passwordForgot", "flag" => true));
        echo "メールを送信しました";
      } else {
        echo "メールの送信に失敗しました";
      };
    }

    header("Location: https://jjjrop.com/forgot_form.php");
    exit;
  }

  /**
   * メールに届いたランダム文字列からユーザー情報を取得し、パスワードを再設定する
   */
  public static function passwordResetAction()
  {
    DBController::DBConnect();

    $s_pw_reset_password = $_POST["mail_pw"];
    $password = $_POST["c_staff_resetPassword"];
    $password_confirm = $_POST["c_staff_resetPassword_confirm"];
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $s_pw_reset = DBController::selectOne("select * from s_pw_reset where done = 0 and deleted = 0 order by created_at desc limit 1");

    if (!ValidationController::isPassword($password)) {
      header("Location: https://jjjrop.com/reset_form.php");
      exit;
    }

    // バリデーション(パスワード確認用と一致しているか)
    if ($password !== $password_confirm) {
      $_SESSION["error"] = json_encode(array("modal" => "rePassword"));
      $_SESSION["error"] = json_encode(json_decode($_SESSION["error"], true)+array("error" => "notMatchPassword", "flag" => true));
      header("Location: https://jjjrop.com/reset_form.php");
      exit;
    }

    if (password_verify($s_pw_reset_password, $s_pw_reset["password"]) && $password==$password_confirm && $password!=="" && $s_pw_reset_password!=="") {
      $c_staff_id = $s_pw_reset["c_staff_id"];
      DBController::update("update c_staff set password = '" . $password_hash . "' where id = " . $c_staff_id);
      DBController::update("update s_pw_reset set done = 1 where id = " . $s_pw_reset["id"]);
      $_SESSION["success"] = json_encode(array("success" => "passwordReset", "flag" => true));
    }

    header("Location: https://jjjrop.com/login_form.php");
    exit;
  }
}

