<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/db.php';

$conn = get_db_connection();
if (!$conn) {
    echo json_encode(["status" => "erro", "msg" => "Falha na conexão"]);
    exit;
}

// Verificar estrutura de projetos_backup
echo "=== TABELA: projetos_backup ===\n";
$result = $conn->query("DESCRIBE projetos_backup");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo "Campo: " . $row['Field'] . " | Tipo: " . $row['Type'] . " | Null: " . $row['Null'] . "\n";
    }
} else {
    echo "Erro ao descrever projetos_backup: " . $conn->error . "\n";
}

echo "\n=== TABELA: lideres_backup ===\n";
$result = $conn->query("DESCRIBE lideres_backup");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo "Campo: " . $row['Field'] . " | Tipo: " . $row['Type'] . " | Null: " . $row['Null'] . "\n";
    }
} else {
    echo "Erro ao descrever lideres_backup: " . $conn->error . "\n";
}

$conn->close();
?>
