<?php

require_once __DIR__ . '/functions/user.php';

session_start();

$errorMessage = [];

$email = '';



if (isset($_SESSION['id'])) {
    header('Location: ./my-page.php');
    exit();
}


if (isset($_POST['submit-button'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $isRememberMe = isset($_POST['remember-me']);

    if (empty($email)) {
        $errorMessage['email'] = 'メールアドレスを入力してください';
    }

    if (empty($password) || strlen($password) < 8) {
        $errorMessage['password'] = 'パスワードは8文字以上で入力してください';
    }



    if (empty($errorMessages)) { //only run if have email + pw data
        $user = login($email, $password);

        if (!is_null($user)) {  //login in success

            // セッションにIDを保存
            $_SESSION['id'] = $user['id'];

            if ($isRememberMe) {
                setcookie('id', $user['id'], time() + 60 * 60, '/');
            }

            header('Location: ./my-page.php');
            exit();
        }

        $errorMessage['result'] = '一致するユーザーが見つかりませんでした';
    }

}


?>

<html>

    <head>
        <meta charset="utf-8">
        <title>FORM</title>
        <link rel="stylesheet" type="text/css" href="css/style2.css">
    </head>

    <body>
        <div class="main_wrapper">
            <h1>ログイン</h1>


            <div class="input_area">


                <!-- action: フォームの送信先 -->
                <!-- method: 送信方法（GET/POST  GET>検索　POST>登録） -->
                <form action="./login.php" method="POST">
                    <div>
                        <h2>メールアドレス</h2>
                        <input type="email" name="email" value="<?php echo $email //keep the email data in the site?>" >
                        <?php if (isset($errorMessage['email'] )): ?>
                            <p class='error'><?php echo $errorMessage['email']  ?></p>
                        <?php endif ?>
                    </div>


                    <div>
                        <h2>パスワード</h2>
                        <input type="password" name="password">
                        <?php if (isset($errorMessage['password'] )): ?>
                            <p class='error'><?php echo $errorMessage['password']  ?></p>
                        <?php endif ?>
                    </div>

                    <div>
                        <label>
                            <input type="checkbox" name="remember-me">
                            ログイン状態を保存する
                        </label>
                    </div>
                    <?php if (isset($errorMessage['result'] )): ?>
                        <p class='error'><?php echo $errorMessage['result']  ?></p>
                    <?php endif ?>

                    <div>
                        <br>
                        <input type="submit" value="ログイン" name="submit-button">
                    </div>

                </form>

                <div class="textlink">
                    <a href="./register.php">新規登録はこちらへ</a>
                </div>
            </div>
        </div>
        <?php include __DIR__ . '/includes/footer.php' ?>
    </body>

</html>
