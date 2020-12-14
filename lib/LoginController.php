<?php
  require '/home/nanablog1114/jjjrop.com/lib/DBController.php';
class LoginController
{
  /**
   * ログイン時のアクション
   */
  public static function loginAction()
  {
    DBController::DBConnect();
    $user_number = $_POST["c_staff_user_number_login"];
    $password = $_POST["c_staff_password_login"];

    $password_hash = DBController::selectOne("select * from c_staff where user_number = '" . $user_number . "'")["password"];
    $deleted = DBController::selectOne("select * from c_staff where user_number = '" . $user_number . "'")["deleted"];
    session_reset();
    $_SESSION["c_staff_id"] = DBController::selectOne("select * from c_staff where user_number = '" . $user_number . "'")["id"];
    $_SESSION["company_id"] = DBController::selectOne("select * from c_staff where user_number = '" . $user_number . "'")["company_id"];
    $_SESSION["c_staff_role"] = DBController::selectOne("select * from c_staff where user_number = '" . $user_number . "'")["role"];
    // DBController::update("update c_staff set status = 'active' where user_number = '" . $user_number . "'");

    if (password_verify($password, $password_hash) && $input_password !== "" && !$deleted) {
      session_regenerate_id(true);
      DBController::update("update c_staff set status = 'active' where user_number = '" . $user_number . "'");
      // header("Location: https://jjjrop.com/aaa/staff/index.php");
      header("Location: https://jjjrop.com");
      exit;
    } else {
      header("Location: https://jjjrop.com/login_form.php");
      exit;
    }
  }
}
?>