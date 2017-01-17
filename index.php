<?php
require_once "lib/user_class.php";
/* Создадим объект */
$user = User::getObject();
/* Проверяем авторизован ли */
$auth = $user->isAuth();
/* Регистрация */
if (isset($_POST["reg"]))
{
    $login = $_POST["login"];
    $password = $_POST["password"];
    /* Регистрируем пользователя. Результат регистрации в  $reg_success */
    $reg_success = $user->regUser($login, $password);
}
/* Проверяем, может была Авторизация */
elseif (isset($_POST["auth"]))
{
    $login = $_POST["login"];
    $password = $_POST["password"];
    /* Пытаемся авторизоваться */
    $auth_success = $user->login($login, $password);
    /* Если удачно*/
    if ($auth_success)
    {
        header("Location: index.php");
        exit;
    }
}
?>
<html>
<head>
    <title>Регистрация и авторизация пользователей</title>
</head>
<body>
    <?php
    if ($auth)
    {
        echo "Здравствуйте, " . $_SESSION["login"] . "! (<a href='logout.php'>Выход</a>)"; /* Эта ссылка на выход из авторизации */
    }
    else
    {
        if ($_POST["reg"])
        if ($_POST["reg"])
        {
            if ($reg_success)
            {
                echo "<span style='color: red;'>Регистрация прошла успешно!</span>";
            }
            else
            {
                echo "<span style='color: red;'>Ошибка при регистрации!</span>";
            }
        }
        elseif ($_POST["auth"])
        {
            if (!$auth_success)
            {
                echo "<span style='color: red;'>Неверные имя пользователя и/или пароль!</span>";
            }
        }

        echo ' <h1>Регистрация</h1>
    <form name="reg" action="index.php" method="post">
        <table>
            <tr>
                <td>Логин:</td>
                <td>
                    <input type="text" name="login">
                </td>
            </tr>
            <tr>
                <td>Пароль:</td>
                <td>
                    <input type="text" name="password">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" name="reg" value="Зарегистрироваться">
                </td>
            </tr>
        </table>
    </form>
    <h1>Авторизация</h1>
    <form name="auth" action="index.php" method="post">
        <table>
            <tr>
                <td>Логин:</td>
                <td>
                    <input type="text" name="login">
                </td>
            </tr>
            <tr>
                <td>Пароль:</td>
                <td>
                    <input type="text" name="password">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" name="auth" value="Войти">
                </td>
            </tr>
        </table>
    </form>';
    }
    ?>
</body>
</html>
