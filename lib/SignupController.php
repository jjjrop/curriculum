<?php
require_once '/home/nanablog1114/jjjrop.com/lib/ValidationController.php';

/**
 * SignupController
 */
class SignupController
{
  /**
   * アカウント作成(画面から)
   */
  public static function signupAction() {
    require_once '/home/nanablog1114/jjjrop.com/lib/DBController.php';
    DBController::DBConnect();
    session_start();

    $curriculums = array(
      "introduction", 
      "div_puzzle_pc_lesson1", 
      "div_puzzle_pc_lesson2", 
      "div_puzzle_pc_lesson3", 
      "div_puzzle_pc_lesson4", 
      "div_puzzle_sp_lesson1", 
      "div_puzzle_sp_lesson2", 
      "pc_site", 
      "responsive_site", 
      "environment", 
      "kadai_PC_kadai_01", 
      "kadai_PC_kadai_02", 
      "kadai_SP_kadai_01", 
      "jQuery1", 
      "jQuery2", 
      "jQuery3", 
      "jQuery4", 
      "jQuery5", 
      "jQuery6", 
      "jQuery7", 
      "jQuery8", 
      "jQuery9", 
      "jQuery10", 
      "kadai_LP", 
      "kadai_tsubo_PC", 
      "kadai_tsubo_SP"
    );

    $name = htmlspecialchars($_POST["c_staff_name_signup"], ENT_QUOTES, "UTF-8");
    $user_number = htmlspecialchars($_POST["c_staff_user_number_signup"], ENT_QUOTES, "UTF-8");
    $role = htmlspecialchars($_POST["c_staff_role_signup"], ENT_QUOTES, "UTF-8");
    // $company_id = $_SESSION["company_id"];
    $company_id = 1;
    $password = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 8);
    // $password = "abc1234";
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $deleted = 0;
    $created_at = date("Y-m-d H:i:s");

    // $c_finished_date = date("Y-m-d", strtotime(30 . "day"));
    // $c_target_date = date("Y-m-d", strtotime(30 . "day"));
    $c_finished_date = "";
    $c_target_date = "";

    // バリデーション(氏名)
    if (!ValidationController::isName($name)) {
      header("Location: https://jjjrop.com");
      exit;
    }

    // バリデーション(ユーザーID)
    if (!ValidationController::isUserNumber($user_number)) {
      header("Location: https://jjjrop.com");
      exit;
    }

    // 入力されたユーザーIDがすでに存在していたらエラーを返す
    $existUserNumber = is_array(DBController::selectArray("select * from c_staff where user_number = '" . $user_number . "'"));
    if ($existUserNumber) {
      $_SESSION["error"] = json_encode(array("error" => "existUserNumber", "flag" => true));
      header("Location: https://jjjrop.com");
      exit;
    }
    
    // 以下、DBにてアカウント作成
    DBController::insert('insert into c_staff(name, user_number, company_id, password, deleted, created_at, status, role) values ("' . $name . '","' . $user_number . '",' . $company_id . ',"' . $password_hash . '",' . $deleted . ',"' . $created_at . '", "apply", "' . $role . '")');

    $c_staff_id = DBController::selectOne('select * from c_staff where user_number = "' . $user_number . '"')["id"];

    DBController::insert('insert into c_status(c_staff_id, created_at) values (' . $c_staff_id . ',"' . $created_at . '")');
    DBController::insert('insert into c_finished_date(c_staff_id, created_at) values (' . $c_staff_id . ',"' . $created_at . '")');
    DBController::insert('insert into c_target_date(c_staff_id, created_at) values (' . $c_staff_id . ',"' . $created_at . '")');

    foreach ($curriculums as $curriculum) {
      DBController::update("update c_status set " . $curriculum . " = 'waiting'" . " where c_staff_id = " . $c_staff_id);
      DBController::update("update c_finished_date set " . $curriculum . " = '" . $c_finished_date . "' where c_staff_id = " . $c_staff_id);
      DBController::update("update c_target_date set " . $curriculum . " = '" . $c_target_date . "' where c_staff_id = " . $c_staff_id);
    }

    // 作成したアカウント情報をモーダルで表示させる
    $json = array("name" => $name, "user_number" => $user_number, "role" => $role, "password" => $password, "flag" => true);
    $_SESSION["signup"] = json_encode($json);

    header("Location: https://jjjrop.com");
    exit;
  }

  /**
   * アカウント作成(csv)
   */
  public static function csvSignupAction()
  {
    require_once '/home/nanablog1114/jjjrop.com/lib/DBController.php';
      DBController::DBConnect();
    // 読み込み用にtest.csvを開きます。
    // $file = fopen("/home/nanablog1114/jjjrop.com/lib/test.csv", "r");
    $file = fopen($_FILES['userfile']['tmp_name'], "r");
    
    $j = 0;
    // バリデーション(csv内容)
    while($user = fgetcsv($file)) {
      $users[$j] = $user;
      $j++;
    }

    foreach ($users as $user) {
      // バリデーション(氏名)
      if (!ValidationController::isName($user[0])) {
        header("Location: https://jjjrop.com");
        exit;
      }
      
      // バリデーション(ユーザーID)
      if (!ValidationController::isUserNumber($user[1])) {
        header("Location: https://jjjrop.com");
        exit;
      }

      // バリデーション(role)
      if (!ValidationController::isRole($user[2])) {
        header("Location: https://jjjrop.com");
        exit;
      }
      
      // 入力されたユーザーIDがすでに存在していたらエラーを返す
      $existUserNumber = is_array(DBController::selectArray("select * from c_staff where user_number = '" . $user[1] . "'"));
      if ($existUserNumber) {
        $_SESSION["error"] = json_encode(array("error" => "existUserNumber", "flag" => true));
        header("Location: https://jjjrop.com");
        exit;
      }
    }
    unset($user, $j);

    $i = 0;
    // test.csvの行を1行ずつ読み込みます。
    foreach ($users as $user) {
      // 読み込んだ結果を表示します。
      // var_dump($user);

      $curriculums = array(
        "introduction", 
        "div_puzzle_pc_lesson1", 
        "div_puzzle_pc_lesson2", 
        "div_puzzle_pc_lesson3", 
        "div_puzzle_pc_lesson4", 
        "div_puzzle_sp_lesson1", 
        "div_puzzle_sp_lesson2", 
        "pc_site", 
        "responsive_site", 
        "environment", 
        "kadai_PC_kadai_01", 
        "kadai_PC_kadai_02", 
        "kadai_SP_kadai_01", 
        "jQuery1", 
        "jQuery2", 
        "jQuery3", 
        "jQuery4", 
        "jQuery5", 
        "jQuery6", 
        "jQuery7", 
        "jQuery8", 
        "jQuery9", 
        "jQuery10", 
        "kadai_LP", 
        "kadai_tsubo_PC", 
        "kadai_tsubo_SP"
      );

      $name = $user[0];
      $user_number = $user[1];
      $role = $user[2];
      // $company_id = $_SESSION["company_id"];
      $company_id = 1;
      $password = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 8);
      // $password = "abc1234";
      $password_hash = password_hash($password, PASSWORD_DEFAULT);
      $deleted = 0;
      $created_at = date("Y-m-d H:i:s");

      // $c_finished_date = date("Y-m-d", strtotime(30 . "day"));
      // $c_target_date = date("Y-m-d", strtotime(30 . "day"));
      $c_finished_date = "";
      $c_target_date = "";

      
      
      // 以下、DBにてアカウント作成
      DBController::insert('insert into c_staff(name, user_number, company_id, password, deleted, created_at, status, role) values ("' . $name . '","' . $user_number . '",' . $company_id . ',"' . $password_hash . '",' . $deleted . ',"' . $created_at . '", "apply", "' . $role . '")');

      $c_staff_id = DBController::selectOne('select * from c_staff where user_number = "' . $user_number . '"')["id"];

      DBController::insert('insert into c_status(c_staff_id, created_at) values (' . $c_staff_id . ',"' . $created_at . '")');
      DBController::insert('insert into c_finished_date(c_staff_id, created_at) values (' . $c_staff_id . ',"' . $created_at . '")');
      DBController::insert('insert into c_target_date(c_staff_id, created_at) values (' . $c_staff_id . ',"' . $created_at . '")');

      foreach ($curriculums as $curriculum) {
        DBController::update("update c_status set " . $curriculum . " = 'waiting'" . " where c_staff_id = " . $c_staff_id);
        DBController::update("update c_finished_date set " . $curriculum . " = '" . $c_finished_date . "' where c_staff_id = " . $c_staff_id);
        DBController::update("update c_target_date set " . $curriculum . " = '" . $c_target_date . "' where c_staff_id = " . $c_staff_id);
      }

      // 作成したアカウント情報をモーダルで表示させる
      $json[$i] = array("name" => $name, "user_number" => $user_number, "role" => $role, "password" => $password, "flag" => true);
      $i += 1;
    }
    $_SESSION["csvSignup"] = json_encode($json);

    // test.csvを閉じます。
    fclose($file);
    header("Location: https://jjjrop.com");
    exit;
  }
}

