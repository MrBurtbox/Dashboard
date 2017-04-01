<?php
if (isset($_COOKIE['LoginToken'])) {
    unset($_COOKIE['LoginToken']);
    unset($_COOKIE['LoginToken']);
    setcookie('LoginToken', null, -1, '/');
    setcookie('LoginToken', null, -1, '/');
    header('Location: /');
}
?>