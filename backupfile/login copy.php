<?php
print_r("ようこそ");
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <title>Login</title>
</head>

<body>

    <div>
        <h3>掲示板</h3>
    </div>

    <div>
        <p>メールアドレス</p>
        <input type="mail" class="form-control" placeholder="email">
    </div>

    <div>
        <p>パスワード</p>
        <input type="pass" class="form-control" placeholder="password">
    </div>

    <div>
        <button type="submit" class="btn btn-primary">ログイン</button>
    </div>
</body>

</html>