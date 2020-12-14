<?php
/**
 * ValidationController
 */
class ValidationController
{
  /**
   * isName
   * スタッフの名前が正しく入力されているか
   * 
   * @param string $name スタッフの氏名
   */
  public static function isName($name)
  {
    $_SESSION["error"] = array();

    // 入力されているか
    if ($name == "") {
      $_SESSION["error"] = json_encode(array("error" => "nullName", "flag" => true));
      return false;
    }

    // 20文字以内か
    if (mb_strlen($name) > 20) {
      $_SESSION["error"] = json_encode(array("error" => "overName", "flag" => true));
      return false;
    }

    return true;
  }

  /**
   * isUserNumber
   * ユーザーID(ログインID)が適切かチェック
   * 
   * @param string $userNumber ユーザーID(ログインID)
   */
  public static function isUserNumber($userNumber)
  {
    $_SESSION["error"] = array();

    // 入力されているか
    if ($userNumber == "") {
      $_SESSION["error"] = json_encode(array("error" => "nullUserNumber", "flag" => true));
      return false;
    }

    // 半角入力されているか
    if (strlen($userNumber) !== mb_strlen($userNumber)) {
      $_SESSION["error"] = json_encode(array("error" => "fullcharUserNumber", "flag" => true));
      return false;
    }

    // 20文字以内か
    if (mb_strlen($userNumber) > 20) {
      $_SESSION["error"] = json_encode(array("error" => "overUserNumber", "flag" => true));
      return false;
    }

    return true;
  }

  public static function isPassword($password)
  {
    // 入力されているか
    if ($password == "") {
      $_SESSION["error"] = json_encode(array("error" => "nullPassword", "flag" => true));
      return false;
    }

    // 8文字以上か
    if (mb_strlen($password) < 6) {
      $_SESSION["error"] = json_encode(array("error" => "lessPassword", "flag" => true));
      return false;
    }

    // 半角英数か
    if (strlen($password) !== mb_strlen($password) || !preg_match("/[a-zA-Z]/", $password) || !preg_match("/[0-9]/", $password)) {
      $_SESSION["error"] = json_encode(array("error" => "ngPassword", "flag" => true));
      return false;
    }

    // 20文字以内か
    if (mb_strlen($password) > 20) {
      $_SESSION["error"] = json_encode(array("error" => "overPassword", "flag" => true));
      return false;
    }

    return true;
  }

  public static function isEmail($email)
  {
    // アドレスが入力されてるか判定
    if ($email == "") {
      $_SESSION["error"] = json_encode(array("error" => "nullEmail", "flag" => true));
      return false;
    }

    // 100文字以内か判定
    if (mb_strlen($email) > 100) {
      $_SESSION["error"] = json_encode(array("error" => "overEmail", "flag" => true));
      return false;
    }


    // 正しいメールアドレスの形か判定
    $reg_str = "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/";
    if (!preg_match($reg_str, $email)) {
      $_SESSION["error"] = json_encode(array("error" => "badEmail", "flag" => true));
      return false;
    }

    return true;
  }

  public static function isDate($date)
  {
    // 日付が入力されているか
    if ($date == "") {
      $_SESSION["error"] = json_encode(array("error" => "nullDate", "flag" => true));
      return false;
    }

    // 半角入力か
    if (strlen($date) !== mb_strlen($date)) {
      $_SESSION["error"] = json_encode(array("error" => "fullcharDate", "flag" => true));
      return false;
    }

    return true;
  }

  public static function isRole($role)
  {
    if ($role!=="staff"&&$role!=="manager") {
      $_SESSION["error"] = json_encode(array("error" => "ngRole", "flag" => true));
      return false;
    }
    return true;
  }
}




















