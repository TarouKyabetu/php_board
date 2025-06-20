<?php

// HTMLエスケープ処理
require_once("util.php");

// セッションの開始
session_start();

// DB設定
$dsn = "mysql:host=localhost; dbname=twitter; charset=utf8";
$username = "root";
$db_pass = "";

// 初期値
$user_reply = "";
$reply_msg = "";
$error_msg = "";
$link = "";
$tweet_id = null;

// ログインユーザーのID受け取り
$user_id = $_SESSION['id'];

// クリックされたツイートIDの受け取り
if (isset($_GET['id'])) {
    $tweet_id = $_GET['id'];
    $_SESSION['tweet_id'] = $tweet_id;
} elseif (isset($_SESSION['tweet_id'])) {
    //セッションから復元
    $tweet_id = $_SESSION['tweet_id'];
} else {
    echo "値が有りません。";
}

try { // MySQL　PDO接続
    $pdo = new PDO($dsn, $username, $db_pass);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL ツイート読込クエリ
    $sql = "SELECT users.first_name, users.last_name, tweets.tweet, tweets.id FROM tweets LEFT OUTER JOIN users ON tweets.user_id = users.id WHERE tweets.id = '$tweet_id' ORDER BY tweets.id DESC";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $tweet_result = $stm->fetchAll(PDO::FETCH_ASSOC);

    // SQL リプライ読込クエリ
    $sql = "SELECT users.first_name, users.last_name, replys.reply FROM replys LEFT OUTER JOIN users ON replys.user_id = users.id WHERE replys.tweet_id = '$tweet_id' ORDER BY replys.id DESC";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $reply_result = $stm->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($_POST['reply'])) { // リプライフォームに値があるなら実行
        $user_reply = $_POST['reply'];
        // SQL リプライ追加クエリ ユーザーIDを元にリプライステーブルへ書き込み
        $insert_sql = "INSERT INTO replys(tweet_id, user_id, reply) VALUES(:tweet_id, :user_id, :reply)";
        $insert_stmt = $pdo->prepare($insert_sql);
        $insert_stmt->bindValue(':tweet_id', $tweet_id, PDO::PARAM_INT);
        $insert_stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $insert_stmt->bindValue(':reply', $user_reply, PDO::PARAM_STR);
        $insert_stmt->execute();
        header("Location: reply_form.php?id=" . $tweet_id);
        exit();
    }
} catch (Exception $e) { // エラー検出
    echo '<span class="error">エラーがありました。</span><br>';
    echo '<a href="reply_form.php">戻る</a>';
    echo $e->getMessage();
    exit();
}

?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=raven" />
    <title>リプライ投稿</title>
</head>

<body>
    <!-- ナビメニュー -->
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#"><span class="material-symbols-outlined">raven</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav justify-content-center">
                    <li class="nav-item active">
                        <a class="nav-link" href="tweet_form.php">ツイート一覧 </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="regist_form.php">ユーザー情報更新</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>


    <!-- ツイートデータの表示 -->
    <div class="container">
        <div>
            <h3>ツイート詳細</h3>
        </div>

        <?php foreach ($tweet_result as $row) { ?>
            <form action="reply_form.php" method="get">
                <div class="card mb-3">
                    <div class="card-body">
                        <p class="card-title"><?php echo es($row['first_name']) . " " . es($row['last_name']); ?></p><br>
                        <?php echo es($row['tweet']); ?><br>
                    </div>
                </div>
            </form>
        <?php } ?>

        <form action="reply_form.php" method="post">
            <div class="form-group mb-3">
                <label for="reply">リプライしよう！</label>
                <input type="text" id="reply" name="reply" class="form-control" placeholder="reply">
            </div>
            <div class="btn-group mb-3">
                <input type="submit" name="send" value="返信" class="btn btn-primary">
            </div>
        </form>

        <div>
            <h3>リプライ一覧</h3>
        </div>
        <!-- リプライデータの表示 -->
        <?php foreach ($reply_result as $row) { ?>
            <a href="reply_form.php">
                <div class="card mb-3">
                    <div class="card-body">
                        <p class="card-title"><?php echo es($row['first_name']) . " " . es($row['last_name']); ?></p><br>
                        <?php echo es($row['reply']); ?><br>
                    </div>
                </div>
            </a>
        <?php } ?>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>