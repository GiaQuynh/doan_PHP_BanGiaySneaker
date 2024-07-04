<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>
<?php
	try{
		$pdo = new PDO ("mysql:host=localhost;dbname=ql_bangiay","root","");
		$pdo->query("set names utf8");
	}
	catch (PDOException $ex){
		echo "Loi ket noi!".$ex->getMessage();
		die();
	}
?>
<body>
</body>
</html>