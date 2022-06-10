<?php
session_start();
if(!isset($_SESSION['userid'])){
    //ログインページに戻る
    header("Location: index.php");
    exit();
}

try{
    //データベースの接続
    $dsn = new PDO('mysql:host=localhost; dbname=login; charset=utf8', 'root', '');
} catch (PDOException $e){
    //データベース接続エラーの時エラーメッセージを出力して終了する
    exit($e->getMessage());
}

$error_msg = '';    //エラー情報を格納

//メッセージがPOSTされたら
if(isset($_POST['message'])){
    //SQL文の作成
    $query = $dsn->prepare('INSERT INTO message_board (userid, message) VALUES (:userid, :message)');
    //値をセットする
    $query->bindValue(':userid', $_SESSION['userid'], PDO::PARAM_STR);
    $query->bindValue(':message', $_POST['message'], PDO::PARAM_STR);
    //クエリを送信する
    $status = $query->execute();
    //送信エラー判断(エラー時false)
    if(!$status){
        $error_msg = '送信エラー';
    }
}

//
//
$query = $dsn->prepare('SELECT * FROM message_board ORDER BY date ASC');
//
$query->execute();
//結果を変数messagesに入れる
$messages = $query->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>MYPAGE</title>
    </head>
    <body>
        <h1>マイページ</h1>
        <p>ようこそ<?php echo $_SESSION['userid'];?>さん</p>
        <div>
            <?php
                //メッセージを表示する
                foreach($messages as $message){
                    echo "<p>{$message['message_id']} {$message['userid']} {$message['date']}<br>".htmlspecialchars($message['message'])."</p>";
                }
            ?>
        <form action="" method="post">
            <input type="text" name="message">
            <input type="submit" name="submit" value="書き込み">
        </form>
        </div>
        <a href="logout.php">ログアウトする</a>
    </body>
</html>