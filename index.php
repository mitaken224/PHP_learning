<?php
session_start();
require('utils.php');
$error_message = '';    //ここにエラーメッセージを格納

if(isset($_POST['userid']) && isset($_POST['password'])){
    if(!alphanum_check($_POST['userid'])){
        $error_message = 'ユーザーIDまたはパスワードが不正です。';
    }

    if(!alphanum_check($_POST['password'])){
        $error_message = 'ユーザーIDまたはパスワードが不正です。';
    }

    if(empty($error_message)){
        $userid = $_POST['userid'];
        $password = $_POST['password'];

        try{
            //DBの接続
            $dsn = new PDO('mysql:host=localhost; dbname=login; charset=utf8', 'root', '');
        } catch (PDOException $e){
            //DB接続エラーの時エラーメッセージを出力して終了する
            exit($e->getMessage());
        }

        //クエリ　POSTされたuseridと同じIDのパスワードを取得する
        $query = $dsn->prepare('SELECT password FROM user WHERE userid = :userid');
        //SQL文をセットした後にパラメータ(:userid)に値をセットする
        $query->bindValue(':userid', $userid, PDO::PARAM_STR);
        //クエリを実行
        $query->execute();
        //結果の取得
        $result = $query->fetch();

        if($result !== FALSE && $password === $result['password']){
            //ログイン成功
            session_regenerate_id(TRUE);    //セッションの再発行
            $_SESSION['userid'] = $userid;  //セッション変数に変数useridの値を入れる
            header("Location: mypage.php");
            exit();
        }else{
            //パスワードが一致しない場合
            $error_message = 'ユーザーIDまたはパスワードが違います。';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="utf-8">
<title>ログイン</title>
</head>

<body>
<form action="" method="post">
    <p><span>ユーザーID:</span><input type="text" name="userid"></p>
    <p><span>パスワード:</span><input type="password" name="password"></p>
    
    <?php
        if(!empty($error_message))echo "<p>{$error_message}</p>"
    ?>

    <p><input type="submit" name="submit" value="ログイン"></p>
</form>
</body>
</html>