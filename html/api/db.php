<?php
$dsn = "pgsql:host=db;port=5432;dbname=scoutdb;user=scout;password=scout123";
try {
    $pdo = new PDO($dsn, options:[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    http_response_code(500);
    exit(json_encode(['erro'=>'BD fora']));
}

function dbExec($sql, $params=[]){
    global $pdo;
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
}

function dbQuery($sql, $params=[]){
    global $pdo;
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
