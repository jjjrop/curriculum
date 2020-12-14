<?php
require_once '/home/nanablog1114/jjjrop.com/lib/DBController.php';
require_once '/home/nanablog1114/jjjrop.com/lib/GeneralController.php';
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

$c_staff_ids = DBController::selectOne("select id from c_staff where deleted = 0 and status = 'active' and role = 'staff'");

// $c_staff_ids = [1];
// echo $c_staff_ids[0];
$company_id = 1;
$i = 0;

// $log_staff_condition = ">=0";

if (isset($_POST["log_condition"])) {
  $_SESSION["log_condition"] = $_POST["log_condition"];
}

if (!isset($_SESSION["log_condition"]) || $_SESSION["log_condition"] == "all") {
  $log_staff_condition = ">=0";
} else {
  $log_staff_condition = "= " . $_SESSION["log_condition"];
}


?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Practice</title>
    <link rel="stylesheet" href="/assets/stylesheets/log.css" type="text/css">
    <link rel="stylesheet" href="/assets/stylesheets/reset.css" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  </head>
    
  <?php
  $s_log_message = DBController::selectArray("select s_log.message as message, s_log.created_at as created_at, c_staff.name as c_staff_name 
                                              from s_log 
                                              left join c_staff 
                                              on s_log.c_staff_id = c_staff.id 
                                              where c_staff.company_id =" . $company_id . 
                                              " and c_staff.deleted = 0 
                                              and s_log.deleted = 0 
                                              and c_staff.role = 'staff' 
                                              and c_staff.status = 'active' 
                                              and s_log.c_staff_id " . $log_staff_condition . 
                                              " order by s_log.created_at desc 
                                              limit 20"
                                            );
  ?>

  <?php
  $s_log_message_staff_ids = DBController::selectArray("select c_staff.name as c_staff_name, s_log.c_staff_id as c_staff_id 
                                                        from s_log 
                                                        left join c_staff 
                                                        on s_log.c_staff_id = c_staff.id 
                                                        where c_staff.company_id =" . $company_id . 
                                                        " and c_staff.deleted = 0 
                                                        and s_log.deleted = 0 
                                                        and c_staff.role = 'staff' 
                                                        and c_staff.status = 'active' 
                                                        group  by c_staff_id 
                                                        order by c_staff_id asc"
                                                      );
  ?>

  <section class="l-log-wrapper">
    <div class="p-log-box">
      <form class="p-log-searchForm" action="" method="post">
        <select class="p-log-searchForm__selection" name="log_condition">
          <option value="all" <?php if ($_SESSION["log_condition"]=="all") echo "selected"; ?>>全て表示</option>
          <?php foreach ($s_log_message_staff_ids as $s_log_message_staff_id): ?>
          <option value="<?php echo $s_log_message_staff_id["c_staff_id"]; ?>" <?php if ($_SESSION["log_condition"]==$s_log_message_staff_id["c_staff_id"]) echo "selected"; ?>><?php echo $s_log_message_staff_id["c_staff_name"]; ?></option>
          <?php endforeach; ?>
        </select>
        <input class="p-log-searchForm__searchButton" type="submit" value="絞る">
      </form>

      <ul class="p-log-list">
        <?php foreach ($s_log_message as $aa):  ?>
        <?php
        $ymdhis = $aa["created_at"];
        $ymd = date("Y/m/d", strtotime($ymdhis));
        $ymdjs = date("Y-m-d", strtotime($ymdhis));
        $ymdBefore = date("Y-m-d H:i:s", strtotime($ymdhis));
        ?>
        <?php if ($ymd !== $ymdf): ?>
        <li class="p-log-list__item--ymd u-border">
          <div class="p-log-list__ymd"><?php echo $ymd; ?></div>
          <img class="p-log-list__icon" src="/assets/images/open.png" data-ymd="<?php echo $ymdjs; ?>">
        </li>
        <?php $ymdf = $ymd; ?>
        <?php endif; ?>
        <li class="p-log-list__item <?php echo "js-" . $ymdjs; ?> u-border">
          <div class="p-log-list__message"><?php echo $aa["message"]; ?></div>
          <div class="p-log-list__beforeTime"><?php echo GeneralController::beforeTimeAction($ymdBefore); ?></div>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>

  <script>
  $(function() {
    $(".p-log-list__icon").click(function() {
      var ymd = $(this).data("ymd");
      var js_ymd = ".js-" + ymd;
      if (!$(js_ymd).hasClass("displayNone")) {
      $(js_ymd).addClass("displayNone");
      } else {
        $(js_ymd).removeClass("displayNone");
      }
    });

  });
  </script>
</html>