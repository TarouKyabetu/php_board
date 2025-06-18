<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>新規登録</title>
</head>

<body>

    <div class="container">
        <div>
            <h3>ユーザー登録</h3>
        </div>
        <form action="add_user_check.php" method="post">
            <div>
                <label for="first_name">名前</label>
                <input type="text" id="first_name" name="first_name" class="form-control" placeholder="first_name">
            </div>
            <div>
                <label for="first_name">苗字</label>
                <input type="text" id="last_name" name="last_name" class="form-control" placeholder="last_name">
            </div>
            <div>
                <label for="email">メールアドレス</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="mailaddress">
            </div>
            <div>
                <label for="password">パスワード</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="password">
            </div>
            <input type="submit" name="send" value="登録" class="btn btn-primary">
        </form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


</body>

</html>