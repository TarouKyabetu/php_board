<?php

session_start();

// DB設定
$dsn = "mysql:host=localhost; dbname=twitter; charset=utf8";
$username = "root";
$db_pass = "";

// 初期値
$error_msg = "";
$link = "";

// フォームから値の受け取り
$email = $_POST['email'];
$_SESSION['email'] = $email;

try { //PDO接続
    $pdo = new PDO($dsn, $username, $db_pass);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL実行 emailと一致するユーザーを取得
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch();

} catch (PDOException $e) { // DB接続エラー
    $e->getMessage();
    echo '<span class="error">接続エラーがありました。</span><br>';
    exit();
}

//指定したハッシュがパスワードにマッチしているかチェック
if ($user['password'] === hash('sha256', $_POST['password'])) {
    //DBのユーザー情報をセッションに保存
    $_SESSION['id'] = $user['id'];
    $_SESSION['first_name'] = $user['first_name'];
    $_SESSION['last_name'] = $user['last_name'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['password'] = $user['password'];
    // ツイート一覧画面へ飛ぶ
    header("Location: tweet_form.php");
    exit();

} else {
    $error_msg = 'メールアドレスもしくはパスワードが間違っています。' . '<br>';
    $link = '<a href="login_form.php">戻る</a>';
}

?>

<!--メッセージの出力-->
<?php echo $error_msg ?>
<?php echo $link ?>