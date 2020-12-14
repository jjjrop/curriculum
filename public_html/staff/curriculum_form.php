<?php
require_once '/home/nanablog1114/jjjrop.com/lib/DBController.php';
// $server = "mysql10030.xserver.jp";
// $userName = "nanablog1114_db";
// $password = "sibrin103";
// $dbName = "nanablog1114_db";

DBController::DBConnect();
// $status = \DBController::selectOne('select * from c_staff where id = 1');
// echo $status['status'];
$curriculumIntermediate = array(
  "introduction" => "導入", 
  "div_puzzle_pc_lesson1" => "div_puzzle_pc_lesson1", 
  "div_puzzle_pc_lesson2" => "div_puzzle_pc_lesson2", 
  "div_puzzle_pc_lesson3" => "div_puzzle_pc_lesson3", 
  "div_puzzle_pc_lesson4" => "div_puzzle_pc_lesson4", 
  "div_puzzle_sp_lesson1" => "div_puzzle_sp_lesson1", 
  "div_puzzle_sp_lesson2" => "div_puzzle_sp_lesson2", 
  "pc_site" => "pc_site", 
  "responsive_site" => "responsive_site", 
);
$curriculumMiddle = array(
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
// session_start();
$c_staff_id = $_SESSION["c_staff_id"];

$c_staff = DBController::selectOne('select * from c_staff where id = ' . $c_staff_id);
$c_status = DBController::selectOne('select * from c_status where c_staff_id = ' . $c_staff_id);
$c_finished_date = DBController::selectOne('select * from c_finished_date where c_staff_id = ' . $c_staff_id);
$c_target_date = DBController::selectOne('select * from c_target_date where c_staff_id = ' . $c_staff_id);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>カリキュラム管理</title>
    <link rel="stylesheet" type="text/css" href="/assets/stylesheets/reset.css">
    <link rel="stylesheet" type="text/css" href="/assets/stylesheets/curriculum_form.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  </head>
  <!-- <body> -->
    <!-- <header>
    </header> -->
    <section class="p-curriculumForm-wrapper">
      <div class="p-curriculumForm-box">
        <form class="p-curriculumForm" action="/action/save.php" method="post">
          <div class="p-curriculumForm-top">
            <div class="p-curriculumForm-switch">
              <div class="p-curriculumForm-switch__btn--beginner js-itemBeginner selected">初級</div><div class="p-curriculumForm-switch__btn--intermediate js-itemIntermediate">中級</div>
            </div>
            <ul class="p-curriculumForm-top-list">
              <li class="p-curriculumForm-top-list__item">未着手：<span class="p-curriculumForm-top-list__color u-waitingColor"></span></li>
              <li class="p-curriculumForm-top-list__item">実施中：<span class="p-curriculumForm-top-list__color u-workingColor"></span></li>
              <li class="p-curriculumForm-top-list__item">完了：<span class="p-curriculumForm-top-list__color u-completedColor"></span></li>
            </ul>
          </div>
          <table class="p-curriculumForm-table js-beginner displayTable" border="1" style="border-collapse: collapse">
            <tr class="p-curriculumForm-table__row--header">
              <th class="p-curriculumForm-table__header">カリキュラム</th>
              <th class="p-curriculumForm-table__header">状態</th>
              <th class="p-curriculumForm-table__header">完了日</th>
              <th class="p-curriculumForm-table__header">目標</th>
            </tr>
            <?php foreach ($curriculumIntermediate as $val => $key): ?>
            <tr class="p-curriculumForm-table__row <?php echo "js-" . $val; ?>">
              <td class="p-curriculumForm-table__data"><?php echo $key; ?></td>
              <td class="p-curriculumForm-table__data">
                <select class="p-curriculumForm-table__selectStatus" name="c_status[<?php echo $val; ?>]">
                  <option value="waiting" <?php if($c_status[$val]=='waiting'){echo "selected";} ?>>未着手</option>
                  <option value="working" <?php if($c_status[$val]=='working'){echo "selected";} ?>>実施中</option>
                  <option value="completed" <?php if($c_status[$val]=='completed'){echo "selected";} ?>>完了</option>
                </select>
              </td>
              <td class="p-curriculumForm-table__data">
                <input class="p-curriculumForm-table__inputFinishedDate" name="c_finished_date[<?php echo $val; ?>]" type="date" value="<?php echo $c_finished_date[$val]; ?>">
              </td>
              <td class="p-curriculumForm-table__data">
                <input class="p-curriculumForm-table__inputTargetDate" name="c_target_date[<?php echo $val; ?>]" type="date" value="<?php echo $c_target_date[$val]; ?>">
              </td>
            </tr>
            <?php endforeach; unset($val); unset($key); ?>
          </table>

          <table class="p-curriculumForm-table js-intermediate" border="1" style="border-collapse: collapse">
            <tr class="p-curriculumForm-table__row--header">
              <th class="p-curriculumForm-table__header">カリキュラム</th>
              <th class="p-curriculumForm-table__header">状態</th>
              <th class="p-curriculumForm-table__header">完了日</th>
              <th class="p-curriculumForm-table__header">目標</th>
            </tr>
            <?php foreach ($curriculumMiddle as $val => $key): ?>
            <tr class="p-curriculumForm-table__row <?php echo "js-" . $val; ?>">
              <td class="p-curriculumForm-table__data"><?php echo $key; ?></td>
              <td class="p-curriculumForm-table__data">
                <select class="p-curriculumForm-table__selectStatus" name="c_status[<?php echo $val; ?>]">
                  <option value="waiting" <?php if($c_status[$val]=='waiting'){echo "selected";} ?>>未着手</option>
                  <option value="working" <?php if($c_status[$val]=='working'){echo "selected";} ?>>実施中</option>
                  <option value="completed" <?php if($c_status[$val]=='completed'){echo "selected";} ?>>完了</option>
                </select>
              </td>
              <td class="p-curriculumForm-table__data">
                <input class="p-curriculumForm-table__inputFinishedDate" name="c_finished_date[<?php echo $val; ?>]" type="date" value="<?php echo $c_finished_date[$val]; ?>">
              </td>
              <td class="p-curriculumForm-table__data">
                <input class="p-curriculumForm-table__inputTargetDate" name="c_target_date[<?php echo $val; ?>]" type="date" value="<?php echo $c_target_date[$val]; ?>">
              </td>
            </tr>
            <?php endforeach; unset($val, $key); ?>
          </table>
          <input class="p-curriculumForm__saveButton" type="submit" value="保存">
          <!-- <a href="" -->
        </form>
      </div>

    </section>
    <!-- <footer>
    </footer> -->
  <script>
  $(function() {
    $(".js-itemBeginner").click(function(){
      $(".js-intermediate").removeClass("displayTable");
      $(".js-beginner").addClass("displayTable");
      $(this).addClass("selected");
      $(".js-itemIntermediate").removeClass("selected");
    });

    $(".js-itemIntermediate").click(function(){
      $(".js-beginner").removeClass("displayTable");
      $(".js-intermediate").addClass("displayTable");
      $(this).addClass("selected");
      $(".js-itemBeginner").removeClass("selected");
    });


    var curriculums = [
      ".js-introduction",
      ".js-div_puzzle_pc_lesson1",
      ".js-div_puzzle_pc_lesson2",
      ".js-div_puzzle_pc_lesson3",
      ".js-div_puzzle_pc_lesson4",
      ".js-div_puzzle_sp_lesson1",
      ".js-div_puzzle_sp_lesson2",
      ".js-pc_site",
      ".js-responsive_site",
      ".js-environment",
      ".js-kadai_PC_kadai_01",
      ".js-kadai_PC_kadai_02",
      ".js-kadai_SP_kadai_01",
      ".js-jQuery1",
      ".js-jQuery2",
      ".js-jQuery3",
      ".js-jQuery4",
      ".js-jQuery5",
      ".js-jQuery6",
      ".js-jQuery7",
      ".js-jQuery8",
      ".js-jQuery9",
      ".js-jQuery10",
      ".js-kadai_LP",
      ".js-kadai_tsubo_PC",
      ".js-kadai_tsubo_SP"
    ];

    curriculums.forEach(function(value){
      switch($(value).find("select").val()) {
        case 'waiting':
          // $(value).addClass("white");
          $(value).css("background-color", "#fff");
          break;
        case 'working':
          // $(value).addClass("blue");
          $(value).css("background-color", "#4fb6ed");
          break;
        case 'completed':
          // $(value).addClass("green");
          $(value).css("background-color", "#84eb69");
          break;
        default:
      }
    });















  });
  </script>
  <!-- </body> -->
</html>