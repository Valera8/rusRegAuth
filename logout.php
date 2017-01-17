<?php
/* Выход из авторизации */
session_start();
/* Чтобы авторизация слетела */
unset($_SESSION["login"]);
unset($_SESSION["password"]);
/* Редирект обратно */
header("Location: " . $_SERVER["HTTP_REFERER"]);
exit;