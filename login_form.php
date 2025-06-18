<?php
// セッションの開始
session_start();

// ログイン画面でセッションの初期化
$_SESSION = [];
if (isset($_COOKIE[session_name()])) {
    $params = session_get_cookie_params();
    // setcookie(session_name(), '', time()-36000, $params['path']);
    setcookie(session_name(), '', time() - 0, $params['path']);
}
// セッションの破棄
session_destroy();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>ログイン</title>
</head>

<body>
    <div class="container">
        <div>
            <h3>ログイン</h3>
        </div>
        <form action="login_check.php" method="post">
            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="email">
            </div>
            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="password">
            </div>
            <div class="form-group">
                <input type="submit" name="send" value="ログイン" class="btn btn-primary">
            </div>
        </form>
        <div class="form-group">
            <a href="add_user_form.php">はじめての方はこちらへ</a>
        </div>
    </div>
</body>

</html>