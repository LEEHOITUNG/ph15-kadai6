<?php

require_once __DIR__ . '/functions/user.php';

// これを忘れない
session_start();

// セッションとCOOKIEにIDが保存されていなければ
// ログインページに移動
if (!isset($_SESSION['id']) && !isset($_COOKIE['id'])) {
    header('Location: ./login.php');
    exit();
}

// セッションにIDが保存されていればセッション
// ない場合はCOOKIEからIDを取得
$id = $_SESSION['id'] ?? $_COOKIE['id'];


$user = getUser($id);

// ユーザーが見つからなかったらログインページへ
if (is_null($user)) {
    header('Location: ./login.php');
    exit();
}

?>

<html>
    <head>
        <meta charset="utf-8">
        <title>MYPAGE</title>
        <link rel="stylesheet" type="text/css" href="css/style2.css">
    </head>

    <body>
        <div class="main_wrapper">
            <h1>マイページ</h1>
            <div class="input_area">
                <table>
                    <tr>
                        <td>ID</td>
                        <td><?php echo $user['id']; ?></td>
                    </tr>
                    <tr>
                        <td>名前</td>
                        <td><?php echo $user['name']; ?></td>
                    </tr>
                    <tr>
                        <td>メールアドレス</td>
                        <td><?php echo $user['email']; ?></td>
                    </tr>
                    <tr>
                        <td>生年月日</td>
                        <td><?php echo $user['date']; ?></td>
                    </tr>
                    <tr>
                        <td>性別</td>
                        <td><?php echo $user['gender']; ?></td>
                    </tr>
                    <tr>
                        <td>電話番号</td>
                        <td><?php echo $user['phone']; ?></td>
                    </tr>
                    <tr>
                        <td>郵便番号</td>
                        <td><?php echo $user['addressPost']; ?></td>
                    </tr>
                    <tr>
                        <td>アドレス</td>
                        <td><?php echo $user['addressLine1']; ?></td>
                        <td><?php echo $user['addressLine2']; ?></td>
                    </tr>
                    <tr>
                        <td>月収</td>
                        <td><?php echo $user['salary']; ?></td>
                    </tr>
                    <tr>
                        <td>好きなタイプ</td>
                        <td><?php echo implode('/', $user['like']); ?></td>
                    </tr>
                </table>
                <div class="textlink">
                    <a href="./edit.php">情報変更</a>
                </div>
                <div class="textlink">
                    <a href="./logout.php">ログアウト</a>
                </div>
            </div>
        </div>
        <?php include __DIR__ . '/includes/footer.php' ?>
    </body>
</html>
