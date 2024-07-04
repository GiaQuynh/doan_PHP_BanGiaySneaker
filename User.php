<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=ql_bangiay", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->query("set names utf8");
} catch (PDOException $ex) {
    echo "Loi ket noi!" . $ex->getMessage();
    die();
}

function getUserInfo($username, $password)
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM user WHERE TaiKhoan = :username AND MatKhau = :password');
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}
?>