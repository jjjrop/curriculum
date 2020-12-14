<?php
require '/home/nanablog1114/jjjrop.com/lib/DBController.php';

/**
 * SaveController
 */
class SaveController
{
  /**
   * カリキュラム進捗内容の保存
   */
  public static function saveAction()
  {
    DBController::DBConnect();

    $curriculums = array(
      "introduction" => "導入", 
      "div_puzzle_pc_lesson1" => "div_puzzle_pc_lesson1", 
      "div_puzzle_pc_lesson2" => "div_puzzle_pc_lesson2", 
      "div_puzzle_pc_lesson3" => "div_puzzle_pc_lesson3", 
      "div_puzzle_pc_lesson4" => "div_puzzle_pc_lesson4", 
      "div_puzzle_sp_lesson1" => "div_puzzle_sp_lesson1", 
      "div_puzzle_sp_lesson2" => "div_puzzle_sp_lesson2", 
      "pc_site" => "pc_site", 
      "responsive_site" => "responsive_site", 
      "environment" => "環境構築", 
      "kadai_PC_kadai_01" => "kadai_PC_kadai_01", 
      "kadai_PC_kadai_02" => "kadai_PC_kadai_02", 
      "kadai_SP_kadai_01" => "kadai_SP_kadai_01", 
      "jQuery1" => "jQuery1", 
      "jQuery2" => "jQuery2", 
      "jQuery3" => "jQuery3", 
      "jQuery4" => "jQuery4", 
      "jQuery5" => "jQuery5", 
      "jQuery6" => "jQuery6", 
      "jQuery7" => "jQuery7", 
      "jQuery8" => "jQuery8", 
      "jQuery9" => "jQuery9", 
      "jQuery10" => "jQuery10", 
      "kadai_LP" => "kadai_LP", 
      "kadai_tsubo_PC" => "kadai_tsubo_PC", 
      "kadai_tsubo_SP" => "kadai_tsubo_SP"
    );

    $statuses = array(
      "waiting" => "未着手",
      "working" => "実施中",
      "completed" => "完了"
    );

    session_start();
    $c_staff_id = $_SESSION["c_staff_id"];

    // ログ用(アップデート前)
    $c_statusBefore = DBController::selectOne("select * from c_status where c_staff_id = " . $c_staff_id);
    $c_target_dateBefore = DBController::selectOne("select * from c_target_date where c_staff_id = " . $c_staff_id);
    $c_finished_dateBefore = DBController::selectOne("select * from c_finished_date where c_staff_id = " . $c_staff_id);

    // データ更新
    foreach ($curriculums as $key => $val) {
      DBController::update('update c_status set ' . $key . ' = "' . $_POST["c_status"][$key] . '" where c_staff_id = ' . $c_staff_id);
      DBController::update('update c_finished_date set ' . $key . ' = "' . $_POST["c_finished_date"][$key] . '" where c_staff_id = ' . $c_staff_id);
      DBController::update('update c_target_date set ' . $key . ' = "' . $_POST["c_target_date"][$key] . '" where c_staff_id = ' . $c_staff_id);
    }
    unset($key, $val);

    //ログ用(アップデート後)
    $c_statusAfter = DBController::selectOne("select * from c_status where c_staff_id = " . $c_staff_id);
    $c_target_dateAfter = DBController::selectOne("select * from c_target_date where c_staff_id = " . $c_staff_id);
    $c_finished_dateAfter = DBController::selectOne("select * from c_finished_date where c_staff_id = " . $c_staff_id);

    // updated_atの更新
    $date = date("Y-m-d H:i:s");
    $ymd = date("Y/m/d H:i");
    DBController::update('update c_status set updated_at = "' . $date . '" where c_staff_id = ' . $c_staff_id);
    DBController::update('update c_finished_date set updated_at = "' . $date . '" where c_staff_id = ' . $c_staff_id);
    DBController::update('update c_target_date set updated_at = "' . $date . '" where c_staff_id = ' . $c_staff_id);

    // 更新した日時の記録
    DBController::update('update c_staff set curriculum_updated_at = "' . $date . '" where id = ' . $c_staff_id);



    // 変更前と変更後の差分を配列で取得(ログ用)
    foreach ($curriculums as $val => $key) {
      if ($c_statusBefore[$val] !== $c_statusAfter[$val]) {
        $statusDiff[$val] = array($c_statusBefore[$val] => $c_statusAfter[$val]);
      }
      if ($c_target_dateBefore[$val] !== $c_target_dateAfter[$val]) {
        $target_dateDiff[$val] = array($c_target_dateBefore[$val] => $c_target_dateAfter[$val]);
      }
      if ($c_finished_dateBefore[$val] !== $c_finished_dateAfter[$val]) {
        $finished_dateDiff[$val] = array($c_finished_dateBefore[$val] => $c_finished_dateAfter[$val]);
      }
    }
    unset($val, $key);

    // メッセージ内容作成
    $message = "[" . $ymd . "]" . "<br>";
    $message .= "<span class=\"u-blue\">" . DBController::selectOne("select * from c_staff where id = " . $c_staff_id)["name"] . "</span> さんがカリキュラムの進捗内容を更新しました。<br>";
    $message .= "変更内容：<br>";

    $updateFlag = false;

    // それぞれ配列が存在していたら、メッセージを作成していく
    if (is_array($statusDiff)) {
      $updateFlag = true;
      foreach ($statusDiff as $val => $key) {
        foreach ($key as $v => $k) {
          $message .= "・" . $curriculums[$val] . "<br>";
          $message .= "　カリキュラムの進捗状態：" . $statuses[$v] . " → " . $statuses[$k] . "<br>";
        }
      }
      unset($val, $key);
    }
    if (is_array($target_dateDiff)) {
      $updateFlag = true;
      foreach ($target_dateDiff as $val => $key) {
        foreach ($key as $v => $k) {
          if ($v == "") {
            $v = "未定";
          }
          $message .= "・" . $curriculums[$val] . "<br>";
          $message .= "　目標：" . $v . " → " . $k . "<br>";
        }
      }
      unset($val, $key);
    }
    if (is_array($finished_dateDiff)) {
      $updateFlag = true;
      foreach ($finished_dateDiff as $val => $key) {
        foreach ($key as $v => $k) {
          if ($v == "") {
            $v = "未定";
          }
          $message .= "・" . $curriculums[$val] . "<br>";
          $message .= "　期日：" . $v . " → " . $k . "<br>";
        }
      }
      unset($val, $key);
    }

    
    $deleted = 0;
    if ($updateFlag) {
      DBController::insert("insert into s_log(c_staff_id, message, deleted, created_at, updated_at) values (" . $c_staff_id . ",'" . $message . "'," . $deleted . ",'" . $date . "','" . $date . "')");
    }

    $_SESSION["success"] = json_encode(array("success" => "save", "flag" => true));

    header("Location: https://jjjrop.com");
    exit;
  }

  /**
   * レポートの保存
   */
  public static function reportSaveAction()
  {
    DBController::DBConnect();
    session_start();
    $c_staff_id = $_SESSION["c_staff_id"];
    $a = $_POST["c_ct_date"];
    $created_at = date("Y-m-d H:i:s");
    $updated_at = date("Y-m-d H:i:s");
    $ymdhi = date("Y/m/d H:i");
    $deleted = 0;
    $i = 0;
    $j = 0;
    foreach($a as $v => $k){
      $exist = self::messageExistAction($c_staff_id, $v);
      echo $exist;
      if ($exist) {
        DBController::update("update c_report set message = '" . $k . "' where c_staff_id = " . $c_staff_id . " and target_date = '" . $v . "'");
        echo "アップデート";
        $updateDiff[$i] = $v;
        $i++;
      } else if (!$exist && $k !="") {
        DBController::insert("insert into c_report(c_staff_id, target_date, message, deleted, created_at, updated_at) values (" . $c_staff_id . ",'" . $v . "','" . $k . "', " . $deleted . ",'" . $created_at . "','" . $updated_at . "')");
        echo "インサート";
        $insertDiff[$j] = $v;
        $j++;
      } else {
        echo "失敗";
      }

    }

    // メッセージ内容作成
    $message = "[" . $ymdhi . "]" . "<br>";
    $message .= "<span class=\"u-blue\">" . DBController::selectOne("select * from c_staff where id = " . $c_staff_id)["name"] . "</span> さんが訓練日報を提出しました。<br>";

    $diffFlag = false;

    if (is_array($insertDiff)) {
      $message .= "提出した訓練日報の日付：<br>";
      foreach ($insertDiff as $insertdiff) {
        $message .= "・" . $insertdiff . "<br>";
        $diffFlag = true;
      }
    }
    
    if ($diffFlag) {
      DBController::insert("insert into s_log(c_staff_id, message, deleted, created_at, updated_at) values (" . $c_staff_id . ",'" . $message . "'," . $deleted . ",'" . $created_at . "','" . $updated_at . "')");
    }

    $_SESSION["success"] = json_encode(array("success" => "save", "flag" => true));
    
    header("Location: https://jjjrop.com");
    exit;
  }
  
  /**
   * 特定の研修生、日付のレポート内容がすでに存在しているか確認
   * 
   * @param int $c_staff_id 調べたいスタッフのid番号
   * @param string $target_date 調べたい日付
   */
  private static function messageExistAction($c_staff_id, $target_date)
  {
    DBController::DBConnect();

    $countDB = DBController::selectOne("select * from c_report where c_staff_id = " . $c_staff_id . " and target_date = '" . $target_date . "'")["id"];
    echo $countDB;
    if ($countDB >= 1) {
      echo "true\n";
      echo $countDB;
      return true;
    } else {
      echo "false";
      echo $countDB;
      return false;
    }
  }
}
?>