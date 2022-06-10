<?php
session_start();

$_SESSION = array();    //セッション変数を削除

//cookieの削除
if(isset($_COOKIE["PHPSESSIONID"])){
    setcookie(session_name(), '' , time(), -42000, '/');
}

session_destroy();
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>ログアウト</title>
    </head>
    <body>
        <h1>ログアウトしました</h1>
        <a href="index.php">ログインページに戻る</a>
    </body>
</html>