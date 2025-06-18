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
$user_tweet = [];
$tweet_msg = "";
$link = "";
$error_msg = "";

// ログインユーザーのID受け取り
$user_id = $_SESSION['id'];


try { // MySQL　PDO接続
    $pdo = new PDO($dsn, $username, $db_pass);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL ツイート読込クエリ
    $sql = "SELECT users.first_name, users.last_name, tweets.tweet, tweets.id FROM tweets LEFT OUTER JOIN users ON tweets.user_id = users.id ORDER BY tweets.id DESC";
    // レコード抽出した仮のレコード置き場
    $stm = $pdo->prepare($sql);
    // SQL文を実行
    $stm->execute();
    // 結果取得（連想配列）
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($_POST['tweet'])) { // ツイートフォームに値があるなら追加クエリ実行
        $user_tweet = $_POST['tweet'];
        // SQL ツイート追加クエリ ユーザーIDを元にツイーツテーブルへ書き込み
        $insert_sql = "INSERT INTO tweets(user_id, tweet) VALUES(:user_id, :tweet)";
        $insert_stmt = $pdo->prepare($insert_sql);
        $insert_stmt->bindValue(':user_id', $user_id);
        $insert_stmt->bindValue(':tweet', $user_tweet);
        $insert_stmt->execute();
        // ツイート一覧画面へ飛ぶ
        header("Location: tweet_form.php");
        exit();
    }
} catch (Exception $e) { // エラー検出
    echo '<span class="error">エラーがありました。</span><br>';
    echo '<a href="tweet_form.php">戻る</a>';
    echo $e->getMessage();
    exit();
}

?>

<!--メッセージの出力-->
<?php echo $tweet_msg; ?>
<?php echo $link; ?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=raven" />
    <title>ツイート投稿</title>
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
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active ml-auto">
                        <a class="nav-link" href="tweet_form.php">ツイート一覧</a>
                    </li>
                    <li class="nav-item ml-auto">
                        <a class="nav-link" href="regist_form.php">ユーザー情報更新</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <div class="container">
        <form action="tweet_form.php" method="post">
            <div class="form-group mb-3">
                <label for="tweet">ツイートしよう！</label>
                <input type="text" id="tweet" name="tweet" class="form-control" placeholder="tweet">
            </div>
            <div class="btn-group mb-3">
                <input type="submit" name="send" value="投稿" class="btn btn-primary">
            </div>
        </form>

        <div>
            <h3>ツイート一覧</h3>
        </div>
        <!-- ツイートデータの表示 -->
        <?php foreach ($result as $row) { ?>
            <a href="reply_form.php?id=<?php echo $row['id']; ?>">
                <div class="card mb-3">
                    <div class="card-body">
                        <p class="card-title"><?php echo es($row['first_name']) . " " . es($row['last_name']); ?></p><br>
                        <?php echo es($row['tweet']); ?><br>
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