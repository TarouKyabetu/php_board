<?php

session_start();

// DB設定
$dsn = "mysql:host=localhost; dbname=twitter; charset=utf8";
$username = "root";
$db_pass = "";

// 初期値
$error_msg = "";
$link = "";

// ログイン時のメールアドレスの受け取り
$user_email = $_SESSION['email'];
// ログイン時のパスワードの受け取り
$user_password = $_SESSION['password'];

try { // PDO接続
    $pdo = new PDO($dsn, $username, $db_pass);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL実行
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':email', $user_email);
    $stmt->execute();
    $user = $stmt->fetch();
    
} catch (PDOException $e) { // DB接続エラー
    $e->getMessage();
    echo '<span class="error">エラーがありました。</span><br>';
    exit();
}


// 全てのフォームの入力チェック
if (empty($_POST['update_first_name']) && empty($_POST['update_last_name']) && empty($_POST['update_email']) && empty($_POST['update_password']) && empty($_POST['new_password'])) {
    $error_msg = '入力がありません' . '<br>';
    $link = '<a href="regist_form.php">戻る</a>';

} else {
    // 値があるならユーザー情報を更新する
    if (!empty($_POST['update_first_name'])) { //　もし値が入っているなら変数へ格納する
        // 更新フォームから値の受け取り
        $update_first_name = $_POST['update_first_name']; // 名前
        // SQL　名前の更新 //ログインしたユーザーのメールアドレスを元にユーザー情報を更新する
        $sql = "UPDATE users SET first_name = :first_name  WHERE email = '$user_email'";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':first_name', $update_first_name);
        $stmt->execute();

        $error_msg = '更新しました' . '<br>';
        $link = '<a href="regist_form.php">戻る</a>';
    }

    if (!empty($_POST['update_last_name'])) {
        $update_last_name = $_POST['update_last_name']; // 苗字

        $sql = "UPDATE users SET last_name = :last_name  WHERE email = '$user_email'";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':last_name', $update_last_name);
        $stmt->execute();

        $error_msg = '更新しました' . '<br>';
        $link = '<a href="regist_form.php">戻る</a>';
    }

    if (!empty($_POST['update_email'])) {
        $update_email = $_POST['update_email']; // メールアドレス

        $sql = "UPDATE users SET email = :email  WHERE email = '$user_email'";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $update_email);
        $stmt->execute();

        $error_msg = '更新しました' . '<br>';
        $link = '<a href="regist_form.php">戻る</a>';
    }

    if (!empty($_POST['update_password']) && !empty($_POST['new_password'])) {
        $update_password = hash('sha256', $_POST['update_password']); //現パスワード
        $new_password = hash('sha256', $_POST['new_password']); //新パスワード

        // ログイン時のパスワードと現パスワードが一致するなら更新を実行する
        if ($user_password === $update_password) {
            $sql = "UPDATE users SET password = :password  WHERE email = '$user_email'";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':password', $new_password);
            $stmt->execute();

            $error_msg = '更新しました' . '<br>';
            $link = '<a href="regist_form.php">戻る</a>';
        }
    } else {
        $error_msg = 'パスワードを入力してください'. '<br>';
        $link = '<a href="regist_form.php">戻る</a>';
    }
}

?>

<!--メッセージの出力-->
<?php echo $error_msg; ?>
<?php echo $link; ?>