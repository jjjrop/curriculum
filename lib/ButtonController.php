<?php
class ButtonController
{
  /**
   * レポート画面での矢印による日付の変更
   */
  public static function changeDateAction()
  {
    $length = 7;
    if ($_SESSION['x']=="") {
      $_SESSION['x'] = 0;
    }
    $x = $_SESSION['x'];
    
    if (isset($_POST['prev'])) {
      $x -= $length;
    } else if (isset($_POST['next'])) {
      $x += $length;
    }
    $_SESSION['x'] = $x;
    header("Location: https://jjjrop.com");
    exit;
  }
}

