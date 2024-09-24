<?php

require_once __DIR__ . '/functions/user.php';

session_start();

$errorMessages = [];

$name = '';
$email = '';
$password = '';
$date = '';
$gender = '';
$phone = '';
$addressPost = '';
$addressLine1 = '';
$addressLine2 = '';
$salary = '';
$like = '';

if (isset($_POST['submit-button'])) {


    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $date = $_POST['date'];
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $phone = $_POST['phone'];
    $addressPost = $_POST['addressPost'];
    $addressLine1 = $_POST['addressLine1'];
    $addressLine2 = $_POST['addressLine2'];
    $salary = $_POST['salary'];
    $like = isset($_POST['like']) ? $_POST['like'] : '';

    if (empty($name)) {
        $errorMessages['name'] = 'お名前を入力してください';
    }

    if (empty($email)) {
        $errorMessages['email'] = 'メールアドレスを入力してください';
    }

    if (empty($password) || strlen($password) < 8) {
        $errorMessages['password'] = 'パスワードは8文字以上で入力してください';
    }


    if ((floor(date('Ymd') -  str_replace("-", "", $date))) < 18) {
        $errorMessages['date'] = '18歳未満の方はご利用できません';
    }

    if (empty($gender)) {
        $errorMessages['gender'] = '性別を入力してください';
    }

    if (empty($phone) || strlen($phone) < 11 || strlen($phone) > 11) {
        $errorMessages['phone'] = '電話番号は11文字で入力してください';
    }

    if (empty($addressPost)) {
        $errorMessages['addressPost'] = '郵便番号を入力してください';
    }

    if (empty($addressLine1)) {
        $errorMessages['addressLine1'] = 'アドレスを入力してください';
    }

    if (empty($like)) {
        $errorMessages['like'] = '好きなタイプを入力してください';
    }

    $sameEmail=getEmail($email);

    if (empty($errorMessages) && empty($sameEmail)) {

        $user = [
            'name' => $name,
            'email' =>$email,
            'password' => $password,
            'date'=> $date,
            'gender' => $gender,
            'phone' => $phone,
            'addressPost' => $addressPost,
            'addressLine1' => $addressLine1,
            'addressLine2' => $addressLine2,
            'salary' => $salary,
            'like' => $like,

        ];

        // 関数を呼び出す
        $user= saveUser($user);

        // セッションにIDを保存
        $_SESSION['id'] = $user['id'];

        // my-page に移動させる（リダイレクト）
        header('Location: ./success.php');
        exit();

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
        <h1>会員登録</h1>

        <div class="input_area">
            <!-- action: フォームの送信先 -->
            <!-- method: 送信方法（GET/POST  GET>検索　POST>登録） -->
            <form action="./register.php" method="POST">
                <div>
                    <h2>お名前</h2>
                    <input type="text" name="name" value="<?php echo $name ?>">
                    <?php if (isset($errorMessages['name'] )): ?>
                        <p class='error'><?php echo $errorMessages['name']  ?></p>
                    <?php endif ?>
                </div>
                <div>
                    <h2>メールアドレス</h2>
                    <input type="email" name="email">
                    <?php if (isset($errorMessages['email'] )): ?>
                        <p class='error'><?php echo $errorMessages['email']  ?></p>
                    <?php endif ?>
                    <?php if (isset($sameEmail)): ?>
                        <p class='error'><?php echo $sameEmail ?></p>
                    <?php endif ?>
                </div>
                <div>
                    <h2>パスワード</h2>
                    <input type="password" name="password">
                    <?php if (isset($errorMessages['password'] )): ?>
                        <p class='error'><?php echo $errorMessages['password']  ?></p>
                    <?php endif ?>
                </div>
                <div>
                    <h2>生年月日</h2>
                    <input type="date" name="date" value="2000-09-10">
                    <?php if (isset($errorMessages['date'] )): ?>
                        <p class='error'><?php echo $errorMessages['date']  ?></p>
                    <?php endif ?>
                </div>
                <div>
                    <h2>性別</h2>
                    <input type="radio" name="gender" value="女">女
                    <input type="radio" name="gender" value="男">男
                    <?php if (isset($errorMessages['gender'] )): ?>
                        <p class='error'><?php echo $errorMessages['gender']  ?></p>
                    <?php endif ?>
                </div>
                <div>
                    <h2>電話番号</h2>
                    <input type="tel" name="phone" pattern="[0-9]{3}[0-9]{4}[0-9]{4}" placeholder="09011112222">
                    <?php if (isset($errorMessages['phone'] )): ?>
                        <p class='error'><?php echo $errorMessages['phone'] ?></p>
                    <?php endif ?>
                </div>
                <div>
                    <h2>住所</h2>
                    <h3>郵便番号</h3>
                    <input type="text" name="addressPost" size="30" pattern="[0-9]{3}-[0-9]{4}}" placeholder="0001111"><br>
                    <?php if (isset($errorMessages['addressPost'] )): ?>
                        <p class='error'><?php echo $errorMessages['addressPost']  ?><br></p>
                    <?php endif ?>
                    <h3>アドレス</h3>
                    <input type="text" name="addressLine1" size="30" maxlength="30" value=""><br>
                    <input type="text" name="addressLine2" size="30" maxlength="30" value=""><br>
                    <?php if (isset($errorMessages['addressLine1'] )): ?>
                        <p class='error'><?php echo $errorMessages['addressLine1']  ?><br></p>
                    <?php endif ?>
                </div>
                <div>
                    <h2>月収は？</h2>
                    <select size="1" name="salary">
                        <option value="２０万円以下">２０万円以下</option>
                        <option value="２０ー３０万円">２０ー３０万円</option>
                        <option value="３０ー４０万円">３０ー４０万円</option>
                        <option value="４０－５０万円">４０－５０万円</option>
                        <option value="５０万円以上">５０万円以上</option>
                    </select>
                </div>

                <div>
                    <h2>好きなタイプは？</h2>
                    <input type="checkbox" name="like[]" value="年上"> 年上
                    <input type="checkbox" name="like[]" value="年下"> 年下
                    <input type="checkbox" name="like[]" value="かわいい系"> かわいい系
                    <input type="checkbox" name="like[]" value="格好いい系"> 格好いい系
                    <?php if (isset($errorMessages['like'] )): ?>
                        <p class='error'><?php echo $errorMessages['like']  ?><br></p>
                    <?php endif ?>
                </div>
                <div>
                    <br>
                    <!-- <button type="submit">登録</button>  でもいいです-->
                    <input type="submit" value="登録" name="submit-button">
                </div>

            </form>
        </div>
    </div>
    <?php include __DIR__ . '/includes/footer.php' ?>

    </body>

</html>
