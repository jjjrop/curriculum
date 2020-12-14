<?php
require_once '/home/nanablog1114/jjjrop.com/lib/DBController.php';
require_once '/home/nanablog1114/jjjrop.com/lib/ValidationController.php';
class AccountController
{
  /**
   * アカウント設定
   */
  public static function accountSettingAction()
  {
    DBController::DBConnect();

    $c_staff_name_after = htmlspecialchars($_POST["c_staff_name_setting"], ENT_QUOTES, "UTF-8");
    $c_staff_user_number_after = htmlspecialchars($_POST["c_staff_user_number_setting"], ENT_QUOTES, "UTF-8");
    $c_staff_birth_date_after = htmlspecialchars($_POST["c_staff_birth_date_setting"], ENT_QUOTES, "UTF-8");
    $c_staff_email_after = htmlspecialchars($_POST["c_staff_email_setting"], ENT_QUOTES, "UTF-8");
    $c_staff_id = $_SESSION["c_staff_id"];

    // バリデーション(氏名)
    if (!ValidationController::isName($c_staff_name_after)) {
      $_SESSION["error"] = json_encode(json_decode($_SESSION["error"], true)+array("modal" => "accountSetting"));
      header("Location: https://jjjrop.com");
      exit;
    }

    // バリデーション(ユーザーID)
    if (!ValidationController::isUserNumber($c_staff_user_number_after)) {
      $_SESSION["error"] = json_encode(json_decode($_SESSION["error"], true)+array("modal" => "accountSetting"));
      header("Location: https://jjjrop.com");
      exit;
    }

    // バリデーション(メールアドレス)
    if (!ValidationController::isEmail($c_staff_email_after)) {
      $_SESSION["error"] = json_encode(json_decode($_SESSION["error"], true)+array("modal" => "accountSetting"));
      header("Location: https://jjjrop.com");
      exit;
    }

    // 入力されたユーザーIDがすでに存在していたらエラーを返す
    $existUserNumber = is_array(DBController::selectArray("select * from c_staff where user_number = '" . $c_staff_user_number_after . "' and id not in (" . $c_staff_id . ")"));
    if ($existUserNumber) {
      $_SESSION["error"] = json_encode(array("error" => "existUserNumber", "flag" => true));
      $_SESSION["error"] = json_encode(json_decode($_SESSION["error"], true)+array("modal" => "accountSetting"));
      header("Location: https://jjjrop.com");
      exit;
    }

    DBController::update("update c_staff set name = '" . $c_staff_name_after . "'where id = " . $c_staff_id);
    DBController::update("update c_staff set user_number = '" . $c_staff_user_number_after . "'where id = " . $c_staff_id);
    DBController::update("update c_staff set birth_date = '" . $c_staff_birth_date_after . "'where id = " . $c_staff_id);
    DBController::update("update c_staff set email = '" . $c_staff_email_after . "'where id = " . $c_staff_id);

    $_SESSION["success"] = json_encode(array("success" => "save", "flag" => true));
    
    header("Location: https://jjjrop.com");
    exit;
    
  }

  /**
   * パスワード再設定
   */
  public static function passwordSettingAction()
  {
    DBController::DBConnect();
    $c_staff_id = $_SESSION["c_staff_id"];
    $password_hash = DBController::selectOne("select * from c_staff where id = " . $c_staff_id)["password"];
    $prev_password = $_POST["prev-password"];
    $new_password = $_POST["new-password"];
    $new_password__confirm = $_POST["new-password__confirm"];

    // バリデーション(現在のパスワードが正しいか)
    if (!password_verify($prev_password, $password_hash)) {
      $_SESSION["error"] = json_encode(array("error" => "notPrevPassword", "flag" => true));
      $_SESSION["error"] = json_encode(json_decode($_SESSION["error"], true)+array("modal" => "rePassword"));
      header("Location: https://jjjrop.com");
      exit;
    }

    // バリデーション(新しいパスワードのバリデーション)
    if (!ValidationController::isPassword($new_password)) {
      $_SESSION["error"] = json_encode(json_decode($_SESSION["error"], true)+array("modal" => "rePassword"));
      header("Location: https://jjjrop.com");
      exit;
    }

    // バリデーション(パスワード確認用と一致しているか)
    if ($new_password !== $new_password__confirm) {
      $_SESSION["error"] = json_encode(array("modal" => "rePassword"));
      $_SESSION["error"] = json_encode(json_decode($_SESSION["error"], true)+array("error" => "notMatchPassword", "flag" => true));
      header("Location: https://jjjrop.com");
      exit;
    }

    if (password_verify($prev_password, $password_hash) && $new_password == $new_password__confirm) {
      $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
      DBController::update("update c_staff set password = '" . $new_password_hash . "' where id = " . $c_staff_id);
    }

    $_SESSION["success"] = json_encode(array("success" => "update", "flag" => true));

    header("Location: https://jjjrop.com");
    exit;

  }

  /**
   * アカウント削除
   */
  public static function accountdeleteAction()
  {
    DBController::DBConnect();
    $c_staff_user_number = htmlspecialchars($_POST["delete_staffId"], ENT_QUOTES, "UTF-8");

    DBController::update("update c_staff set deleted = 1 where user_number = '" . $c_staff_user_number . "'");

    $_SESSION["success"] = json_encode(array("success" => "delete", "flag" => true));

    header("Location: https://jjjrop.com");
    exit;
  }
}

