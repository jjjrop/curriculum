<?php
include("/home/nanablog1114/jjjrop.com/public_html/header.php");

if (isset($_POST["sub1"])) {
  $_SESSION["thisPage"] = h($_POST["sub1"]);
  switch ($_SESSION["thisPage"]) {
    case "カリキュラム": include("/home/nanablog1114/jjjrop.com/public_html/staff/curriculum_form.php"); break;
    case "レポート": include("/home/nanablog1114/jjjrop.com/public_html/staff/trainingReport.php"); break;
    case "シート": include("/home/nanablog1114/jjjrop.com/public_html/sheet.php"); break;
    case "ログ": include("/home/nanablog1114/jjjrop.com/public_html/manager/log.php"); break;
    case "アカウント作成": include("/home/nanablog1114/jjjrop.com/public_html/manager/signup_form.php"); break;
    default:  echo "エラー1"; exit;
  }
} else {
  switch ($_SESSION["thisPage"]) {
    case "カリキュラム": include("/home/nanablog1114/jjjrop.com/public_html/staff/curriculum_form.php"); break;
    case "レポート": include("/home/nanablog1114/jjjrop.com/public_html/staff/trainingReport.php"); break;
    case "シート": include("/home/nanablog1114/jjjrop.com/public_html/sheet.php"); break;
    case "ログ": include("/home/nanablog1114/jjjrop.com/public_html/manager/log.php"); break;
    case "アカウント作成": include("/home/nanablog1114/jjjrop.com/public_html/manager/signup_form.php"); break;
    default:  echo "エラー2"; exit;
  }
}
include("/home/nanablog1114/jjjrop.com/public_html/modal.php");

?>

    </main>
  <script>
  $(function() {

    // モーダル
    function modal(title, text) {
      $(".p-modal-back").addClass("block");
      if (title!=="") {
        $(".c-modal__title").addClass("block");
        $(".c-modal__title").text(title);
      }
      if (text!=="") {
        $(".c-modal__text").addClass("block");
        $(".c-modal__text").html(text);
      }
      $(".c-modal__button").click(function() {
        $(".p-modal-back").removeClass("block");
      });
    }

    // エラーモーダル
    function errormodal(title, text) {
      $(".p-modal-back").addClass("block");
      $(".c-modal__icon").addClass("block");
      if (title!=="") {
        $(".c-modal__title").addClass("block");
        $(".c-modal__title").html(title);
      }
      if (text!=="") {
        $(".c-modal__text").addClass("block");
        $(".c-modal__text").html(text);
      }
      $(".c-modal__button").click(function() {
        $(".p-modal-back").removeClass("block");
      });
    }

    // アカウント設定画面のエラー表示
    var error = <?php echo $_SESSION["error"]; ?>;
    if (error["flag"]) {
      // ページが更新されてもエラーモーダルは閉じない
      if (error["modal"] == "accountSetting") {
          $("#js-accountSetting").css("display", "block");
          $("#js-accountSetting__form").css("display", "inline-block");
      } else if (error["modal"] == "rePassword") {
          $("#js-repassword").css("display", "block");
          $("#js-repassword__form").css("display", "inline-block");
      }
      // エラーの種類によってモーダルを変える
      switch (error["error"]) {
        case "nullName": errormodal("入力エラー", "氏名を入力してください"); break;
        case "overName": errormodal("入力エラー", "氏名は20文字以内で入力してください"); break;
        case "nullUserNumber": errormodal("入力エラー", "ユーザーIDを入力してください"); break;
        case "fullcharUserNumber": errormodal("入力エラー", "ユーザーIDは半角で入力してください"); break;
        case "overUserNumber": errormodal("入力エラー", "ユーザーIDは20文字以内で入力してください"); break;
        case "existUserNumber": errormodal("エラー", "入力したユーザーIDはすでに存在しています"); break;
        case "notPrevPassword": errormodal("入力エラー", "現在のパスワードが正しくありません"); break;
        case "nullPassword": errormodal("入力エラー", "新しいパスワードを入力してください"); break;
        case "lessPassword": errormodal("入力エラー", "新しいパスワードは6文字以上(半角英数)<br>で入力してください"); break;
        case "ngPassword": errormodal("入力エラー", "新しいパスワードは半角英数(6文字以上)<br>で入力してください"); break;
        case "overPassword": errormodal("入力エラー", "新しいパスワードは20文字以下(半角英数)<br>で入力してください"); break;
        case "notMatchPassword": errormodal("入力エラー", "新しいパスワード(再入力)が一致しません"); break;
        case "nullEmail": errormodal("入力エラー", "メールアドレスを入力してください"); break;
        case "overEmail": errormodal("入力エラー", "メールアドレスは100文字以下で入力してください"); break;
        case "badEmail": errormodal("入力エラー", "正しいメールアドレスを入力してください"); break;
        case "ngRole": errormodal("入力エラー", "managerまたはstaffを適切に入力してください"); break;
      }
      <?php $_SESSION["error"] = array(); ?>
    }


    // 処理成功のモーダル表示
    var success = <?php echo $_SESSION["success"]; ?>;
    if (success["flag"]) {
      // 処理成功のモーダルを変える
      switch (success["success"]) {
        case "save": modal("", "保存しました"); break;
        case "update": modal("", "パスワードを更新しました"); break;
        case "delete": modal("", "アカウントを削除しました"); break;
      }
      <?php $_SESSION["success"] = array(); ?>
    }

    

    $("#js-delete__close").click(function() {
      $("#js-delete").fadeOut(300);
      $("#js-delete__form").fadeOut(300);
    });










  });
  
  </script>
  </body>
</html>