<?php

session_start();

// DB設定
$dsn = "mysql:host=localhost; dbname=twitter; charset=utf8";
$username = "root";
$db_pass = "";

// 初期値
$user = [];
$error_msg = "";
$link = "";


try { // PDO接続
    $pdo = new PDO($dsn, $username, $db_pass);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) { // DB接続エラー
    $e->getMessage();
    echo '<span class="error">接続エラーがありました。</span><br>';
    exit();
}


// 各フォームに値が入っているなら実行する。
if (!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    // フォームから値の受け取り
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = hash('sha256', $_POST['password']);

    // SQL実行 emailと一致するユーザーを取得
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch();

    // ユーザーを追加する
    $sql = "INSERT INTO users(first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':first_name', $first_name, PDO::PARAM_STR);
    $stmt->bindValue(':last_name', $last_name, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);
    $stmt->execute();
    $error_msg = '会員登録が完了しました' . '<br>';
    $link = '<a href="login_form.php">ログインページ</a>';

} else {
    $error_msg = '未入力のフォームが有ります' . '<br>';
    $link = '<a href="add_user_form.php">戻る</a>';
}

?>

<!--メッセージの出力-->
<?php echo $error_msg; ?>
<?php echo $link; ?>

