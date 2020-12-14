<?php
require_once '/home/nanablog1114/jjjrop.com/lib/DBController.php';
session_start();
// $server = "mysql10030.xserver.jp";
// $userName = "nanablog1114_db";
// $password = "sibrin103";
// $dbName = "nanablog1114_db";

DBController::DBConnect();

$c_staff_id = $_SESSION["c_staff_id"];
$c_status = DBController::selectOne("select * from c_report where c_staff_id = ". $c_staff_id . " and target_date = '" . $ymd . "'");
$c_staffs = DBController::selectArray("select * from c_staff where deleted = 0 and status = 'active' and role = 'staff'");

if ($_SESSION["c_staff_role"] == "manager") {
  if (!isset($_POST["ggg"])) {
    $_POST["ggg"] = DBController::selectArray("select * from c_staff where deleted = 0 and status = 'active' and role = 'staff'")[0]["id"];
  }
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>カリキュラム管理</title>
    <link rel="stylesheet" type="text/css" href="/assets/stylesheets/reset.css">
    <link rel="stylesheet" type="text/css" href="/assets/stylesheets/trainingReport.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  </head>
    <section class="l-trainingReport-wrapper">
      <div class="p-trainingReport-box">
        <div class="<?php if ($_SESSION["c_staff_role"] == "manager") echo "u-flex"; ?>">
        <?php if ($_SESSION["c_staff_role"] == "manager"): ?>
          <?php
          if (isset($_POST["ggg"])) {
            $_SESSION["hhhh"] = $_POST["ggg"];
          }
          ?>
          <form class="p-trainingReport-selectStaffForm" action="" method="post">
            <select class="p-trainingReport-selectStaffForm__selection" name="ggg">
              <?php foreach ($c_staffs as $c_staff): ?>
              <option value="<?php echo $c_staff["id"]; ?>" <?php if ($_SESSION["hhhh"]==$c_staff["id"]) echo "selected"; ?>><?php echo $c_staff["name"]; ?></option>
              <?php endforeach; ?>
            </select>
            <input class="p-trainingReport-selectStaffForm__searchButton" type="submit" value="表示">
          </form>
          <?php $c_staff_id = $_SESSION["hhhh"]; ?>
          
          <?php endif; ?>
          
          <form class="p-trainingReport-changeDateForm" action="/action/changeDate.php" method="post">
            <button class="p-trainingReport-changeDateForm__arrow" type="submit" name="prev">＜</button>
            <?php
            $x = $_SESSION['x'];
            $week = array( "日", "月", "火", "水", "木", "金", "土" );
            $wtoday = $week[date("w", strtotime(date("Y-m-d")))];
            // 先頭を日曜日にする
            switch ($wtoday) {
              case "日": $x -= 6; break;
              case "月": $x -= 7; break;
              case "火": $x -= 8; break;
              case "水": $x -= 9; break;
              case "木": $x -= 10; break;
              case "金": $x -= 11; break;
              case "土": $x -= 12; break;
            }
            $year = date("Y", strtotime($x+6 . "day"));
            $month = date("m", strtotime($x+6 . "day"));
            $length = 7;
            ?>
            <?php echo $year . "年 " . abs($month) . "月"; ?>
            
            <button class="p-trainingReport-changeDateForm__arrow" type="submit" name="next">＞</button>
          </form>
        </div>
        <form class="p-trainingReport-form" action="/action/reportSave.php" method="post">
          <table class="p-trainingReport-table" border="1" style="border-collapse: collapse">
            <tr>
              <th>日付</th>
              <th>実施内容</th>
            </tr>
            <?php
            
            
            ?>
            <?php for ($i=$x+6; $i<$x+6+$length;$i++): ?>
            <?php
            $m = date("m", strtotime($i . "day"));
            $d = date("d", strtotime($i . "day"));
            $w = $week[date("w", strtotime($i . "day"))];
            $date = abs($m) . "月" . $d . "日" . "(" . $w . ")";
            $ymd = date("Y-m-d", strtotime($i . "day"));
            ?>
            <tr>
              <td class="p-trainingReport-table__data--date <?php if($ymd == date("Y-m-d")) echo "u-today"; ?> <?php if($w=="日"||$w=="土") echo "u-red"; ?>"><?php echo h($date); ?></td>
              <td class="p-trainingReport-table__data">
                <textarea class="p-trainingReport-form__textArea" name="c_ct_date[<?php echo h($ymd); ?>]" rows="4" cols="100" <?php if ($_SESSION["c_staff_role"] == "manager") echo "readonly"; ?>><?php echo h(DBController::selectOne("select * from c_report where c_staff_id = ". $c_staff_id . " and target_date = '" . $ymd . "'")["message"]); ?>
                </textarea>
              </td>
              <!-- <td class="p-trainingReport__text">
              </td> -->
            </tr>
            <?php endfor; ?>
          </table>
          <?php if ($_SESSION["c_staff_role"] == "staff"): ?>
          <input class="p-trainingReport-form__saveButton" type="submit" value="保存"> 
          <?php endif; ?>    
        </form>
      </div>
    </section>
  <script src="script.js"></script>
</html>