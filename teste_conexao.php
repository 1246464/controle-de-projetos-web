<?php
header('Content-Type: application/json');
require_once __DIR__ . '/db.php';

$conn = get_db_connection();
if (!$conn) {
    echo json_encode([
        "status" => "erro_conexao",
        "msg" => "Falha ao conectar"
    ]);
    exit;
}

$tables = [];
$result = $conn->query("SHOW TABLES");
if ($result) {
    while ($row = $result->fetch_array()) {
        $tables[] = $row[0];
    }
}

echo json_encode([
    "status" => "conectado",
    "msg" => "Conexão estabelecida com sucesso",
    "tabelas" => $tables
]);

$conn->close();
?>
