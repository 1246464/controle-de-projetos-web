<?php
header('Content-Type: application/json');
require_once __DIR__ . '/db.php';

$conn = get_db_connection();
if (!$conn) {
    echo json_encode(["status" => "erro", "msg" => "Falha na conexão"]);
    exit;
}

// Buscar o timestamp da última modificação
$sql = "SELECT MAX(updated_at) as last_update FROM projetos_backup";

$result = $conn->query($sql);
$lastUpdate = null;

if ($result && $row = $result->fetch_assoc()) {
    $lastUpdate = $row['last_update'];
}

// Também verificar lideres
$sqlLideres = "SELECT MAX(updated_at) as last_update_lideres FROM lideres";
$resultLideres = $conn->query($sqlLideres);

if ($resultLideres && $row = $resultLideres->fetch_assoc()) {
    $lastUpdateLideres = $row['last_update_lideres'];
    if ($lastUpdateLideres && (!$lastUpdate || $lastUpdateLideres > $lastUpdate)) {
        $lastUpdate = $lastUpdateLideres;
    }
}

$conn->close();

echo json_encode([
    "status" => "sucesso",
    "last_update" => $lastUpdate,
    "timestamp" => time()
]);
?>
