<?php

class GeneralController
{
  /**
   * 現在の日時からの差分を表示
   * 
   * @param string $ymdhis 対象の日時
   */
  public static function beforeTimeAction($ymdhis)
  {
    $date = date("Y-m-d H:i:s");
    $diff = strtotime($date) - strtotime($ymdhis);

    $s = floor($diff);
    $i = floor($diff/60);
    $H = floor($diff/3600);
    $d = floor($diff/86400);
    $m = floor($diff/2678400);
    $Y = floor($diff/31536000);

    if ($diff<60) {
      return "たった今";
    } else if ($diff < 3600) {
      return $i . "分前";
    } else if ($diff < 86400) {
      return $H . "時間前";
    } else if ($diff < 2678400) {
      return $d . "日前";
    } else if (diff < 31536000) {
      return $m . "ヶ月前";
    } else {
      echo $Y . "年前";
    }
  }

  /**
   * ディベロッパーツールに季節によって表示させる絵
   */
  public static function seasonAction()
  {
    $aaa = "
      　　　[三]
      　　 ／ ■ ＼
      　　｜´∀｀｜
      ★　 ＼＿＿／　 ★
      　＼／ミ三彡＼／
      　 ｜　　巛　｜
      　 ｜　　　　｜
      　　＼＿＿＿／
      　　⌒⌒⌒⌒⌒⌒⌒⌒⌒⌒
      ";

    return $aaa;
  }
}

