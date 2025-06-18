<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=raven" />
    <title>登録更新</title>
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
        <div>
            <h3>ユーザー情報更新</h3>
        </div>
        <form action="regist_check.php" method="post">
            <div>
                <label for="first_name">名前</label>
                <input type="text" id="first_name" name="update_first_name" class="form-control" placeholder="first_name">
            </div>
            <div>
                <label for="first_name">苗字</label>
                <input type="text" id="last_name" name="update_last_name" class="form-control" placeholder="last_name">
            </div>
            <div>
                <label for="email">メールアドレス</label>
                <input type="email" id="email" name="update_email" class="form-control" placeholder="mailaddress">
            </div>
            <div>
                <label for="password">パスワード</label>
                <input type="password" id="password" name="update_password" class="form-control" placeholder="password">
                <input type="password" id="password" name="new_password" class="form-control" placeholder="new password">
            </div>
            <input type="submit" name="send" value="更新" class="btn btn-primary">
        </form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
</body>

</html>