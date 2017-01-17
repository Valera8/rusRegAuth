<?php
class User {
    private $db;
    private static $user = null; /* шаблон Singleton для создания только одного объекта User */
    private  function __construct()
    {
        $this->db = new mysqli("127.0.0.1", "root", "", "secondbase");
        $this->db->query("SET NAMES 'utf8'");
    }
/* Проверяем существует ли уже подключение пользователя к базе (шаблон Singleton). Конструктор вызовется гарантировано 1 раз */
    public static function getObject()
    {
        if (self::$user ===null)
        {
            self::$user = new User();
        }
        return self::$user;
    }
/* Добавление пользователя */
    public function regUser($login, $password)
    {
        if ($login == "") return false;
        if ($password == "") return false;
        $password = md5($password);
        return $this->db->query("INSERT INTO `users` (`login`, `password`, `regdate`) VALUES ('$login', '$password', '" . time() . "')");
    }
/* Проверка правильности ввода логина, пароля */
    private function checkUser($login, $password)
    {
    /* Ищем пользователя и возвращаем поле с паролем */
        $result_set = $this->db->query("SELECT `password` FROM `users` WHERE `login`='$login'");
    /* Получаем пользователя */
        $user = $result_set->fetch_assoc();
    /* Закрываем после использования */
        $result_set->close();
        if (!$user) return false;
        return $user["password"] === $password;
    }
/* Проверка на авторизацию на каждой странице */
    /**
     * @return bool
     */
    public function isAuth()
    {
       session_start();
        $login = $_SESSION["login"];
        $password = $_SESSION["password"];
    /* Возвращаем результат выполнения функции проверки нахождения в сессии */
        return $this->checkUser($login, $password);
    }
/* Реализация авторизации - добавляем в сессию */
    public function login($login, $password)
    {
        $password = md5($password);
        if ($this->checkUser($login, $password))
        {
            session_start();
        /* Если они правильные, помещаем в сессию */
            $_SESSION["login"] = $login;
            $_SESSION["password"] = $password;
            return true;
        }
        else
        {
            return false;
        }
    }

/* Закрытие соединения с базой данных */
    public function __destruct()
    {
        if ($this->db) $this->db->close();
    }
}
?>