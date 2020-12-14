<?php
require_once '/home/nanablog1114/jjjrop.com/lib/DBController.php';
// $server = "mysql10030.xserver.jp";
// $userName = "nanablog1114_db";
// $password = "sibrin103";
// $dbName = "nanablog1114_db";

DBController::DBConnect();
// $status = \DBController::select('select * from c_staff where id = 1');
// echo $status['status'];
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
  "completed" => "完了",
  "working" => "実施中"
);


if (isset($_POST["sheet_condition"])) {
  $_SESSION["sheet_condition"] = $_POST["sheet_condition"];
}

if (!isset($_SESSION["sheet_condition"]) || $_SESSION["sheet_condition"] == "all") {
  $staff_condition = ">=0";
} else {
  $staff_condition = "= " . $_SESSION["sheet_condition"];
}

$c_staff_ids = DBController::selectArray("select * from c_staff where deleted = 0 and role = 'staff' and id " . $staff_condition .  " order by curriculum_updated_at desc");

$c_staff_selections = DBController::selectArray("select * from c_staff where deleted = 0 and role = 'staff' order by curriculum_updated_at desc");
// $c_staff_ids = [1];
// echo $c_staff_ids[0];

$i = 0;
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>カリキュラム管理</title>
    <link rel="stylesheet" href="/assets/stylesheets/sheet.css" type="text/css">
    <link rel="stylesheet" href="/assets/stylesheets/reset.css" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  </head>
  <body>
    <div class="p-sheet">
      <div class="p-sheet-box">
        <div class="p-sheet-top">
          <form action="" method="post" class="p-sheet-selectForm">
            <select name="sheet_condition" class="p-sheet-selectForm__select">
              <option value="all" <?php if ($_SESSION["sheet_condition"]=="all") echo "selected"; ?>>全て</option>
              <?php foreach ($c_staff_selections as $c_staff_selection): ?>
              <option value="<?php echo $c_staff_selection["id"]; ?>" <?php if ($_SESSION["sheet_condition"]==$c_staff_selection["id"]) echo "selected"; ?>><?php echo $c_staff_selection["name"]; ?></option>
              <?php endforeach; ?>
            </select>
            <input type="submit" value="絞る" class="p-sheet-selectForm__submit">
          </form>
          <ul class="p-index-sheet__list">
            <li class="p-index-sheet__listItem">未着手：<span class="p-index-sheet__listColor u-waiting"></span></li>
            <li class="p-index-sheet__listItem">実施中：<span class="p-index-sheet__listColor u-working"></span></li>
            <li class="p-index-sheet__listItem">完了：<span class="p-index-sheet__listColor u-completed"></span></li>
          </ul>
        </div>

        <table class="p-sheet-table" border="1" style="border-collapse: collapse">
          <tr class="p-sheet-table__tr ">
            <th class="p-sheet-table__header u-fixed">名前</th>
            <?php foreach($curriculums as $val => $key): ?>
            <th class="p-sheet-table__header"><?php echo h($key); ?> </th>
            <?php endforeach; ?>
          </tr>
          <?php foreach($c_staff_ids as $c_staff_id): ?>
          <tr class="p-sheet-table__tr">
            <?php
            $c_staff = DBController::selectOne('select * from c_staff where id = ' . $c_staff_id["id"]);
            $c_status = DBController::selectOne('select * from c_status where c_staff_id = ' . $c_staff_id["id"]);
            $c_finished_date = DBController::selectOne('select * from c_finished_date where c_staff_id = ' . $c_staff_id["id"]);
            $c_target_date = DBController::selectOne('select * from c_target_date where c_staff_id = ' . $c_staff_id["id"]);
            ?>
            <td class="p-sheet-table__data u-fixed">
              <div class="p-sheet-table__box--name" >
                <span class="<?php if ($_SESSION["c_staff_role"]=="manager") {echo "u-deletingName";} ?>" data-deletingStaffName="<?php echo $c_staff["name"]; ?>" data-deletingStaffID="<?php echo $c_staff["user_number"]; ?>"><?php echo h($c_staff["name"]); ?></span>
              </div>
            </td>
            <?php foreach($curriculums as $val => $key): ?>
            <td class="p-sheet-table__data" id="<?php echo h("js-color__" . $i); ?>">
              <div class="p-sheet-table__box--status"><?php echo h($statuses[$c_status[$val]]); ?></div>
              <div class="p-sheet-table__box--target">
                目標：
                <?php echo h($c_target_date[$val]); ?>
                <?php if ($c_target_date[$val]=="") echo "未定" ?>
              </div>
              <div class="p-sheet-table__box--finished">
                完了日：
                <?php echo h($c_finished_date[$val]); ?>
                <?php if ($c_finished_date[$val]=="") echo "未定" ?>
              </div>
              <?php $i++; ?>
            </td>
          <?php endforeach; ?>
          </tr>
        <?php endforeach; ?>
          <tr class="p-sheet-table__tr">
            <th class="p-sheet-table__header u-fixed">名前</th>
            <?php foreach($curriculums as $val => $key): ?>
            <th class="p-sheet-table__header"><?php echo h($key); ?> </th>
            <?php endforeach; ?>
          </tr>
        </table>
      </div>

      <div class="p-sheet-scroll u-scrollLeft u-gradationLeft" id="js-scrollLeft"></div>
      <div class="p-sheet-scroll u-scrollRight u-gradationRight" id="js-scrollRight"></div>
      <div class="p-sheet-scroll__hover u-scrollLeft u-hoverLeft" id="js-hoverLeft"></div>
      <div class="p-sheet-scroll__hover u-scrollRight u-hoverRight" id="js-hoverRight"></div>

      <div class="p-sheet-zoom">
        <div class="p-sheet-zoom__button js-puls">＋</div>
        <div class="p-sheet-zoom__button js-minus">ー</div>
      </div>

    </div>
    <!-- <footer>
    </footer> -->
  <script>
  $(function() {
    for(var i=0;i<=2600;i++) {
      var value = "#js-color__" + i,
          $value = $(value),
          $text = $(value).find(".p-sheet-table__box--status").text();
      switch ($text) {
        case '未着手':
          // $value.addClass("white");
         $value.css("background-color", "#fff");
          break;
        case '実施中':
          // $value.addClass("blue");
         $value.css("background-color", "#4fb6ed");
          break;
        case '完了':
          // $value.addClass("green");
         $value.css("background-color", "#84eb69");
          break;
        default:
      }
    }

    $zoom = 100;

    $(".p-sheet-zoom").hover(
      function() {
        $(this).animate({
          opacity: 1
        }, 100);
      },
      function() {
        $(this).animate({
          opacity: 0.7
        }, 100);
      }
    );

    $(".js-puls").click(function() {
      $zoom += 30;
      $(".p-sheet-box").animate({
        zoom: $zoom + "%"
      }, 500);
    });

    $(".js-minus").click(function() {
      $zoom -= 30;
      $(".p-sheet-box").animate({
        zoom: $zoom + "%"
      }, 500);
    });


    $(".u-deletingName").click(function() {
      var c_staff_id = $(this).attr('data-deletingStaffID');
      var c_staff_name = $(this).attr('data-deletingStaffName');
      $("#js-delete").fadeIn(300);
      $("#js-delete__form").slideToggle(300);
      $(".js-delete_staffName").val(c_staff_name);
      $(".js-delete_staffId").val(c_staff_id);
    })

    function scrollLeft() {
      scrollBy(-5, 0);
    }

    var count = 0;
    var flag;
    var flags;
    var scrollLeft = function(){
      if (!flag) {
        return 0;
      }
      scrollBy(-10, 0);
      setTimeout(scrollLeft, 10);
    }

    var scrollRight = function(){
      if (!flags) {
        return 0;
      }
      scrollBy(10, 0);
      setTimeout(scrollRight, 10);
    }

    var local = 0;
    // ホバーで左にスクロール
    $("#js-hoverLeft").hover(
      function() {
        $("#js-scrollLeft").fadeIn(500);
        flag = true;
        scrollLeft();
      },
      function() {
        $("#js-scrollLeft").fadeOut(500);
        flag = false;
      }
    );

    // ホバーで右にスクロール
    $("#js-hoverRight").hover(
      function() {
        $("#js-scrollRight").fadeIn(500);
        flags = true;
        scrollRight();
      },
      function() {
        $("#js-scrollRight").fadeOut(500);
        flags = false;
      }
    );

    $(".p-sheet-table__tr").click(function() {
      $(".p-sheet-table__tr").removeClass("u-boldBorder");
      $(this).addClass("u-boldBorder");
      // $(this).css("background-color", "red");
    });








  });
  </script>
  
  </body>
</html>