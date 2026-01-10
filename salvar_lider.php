<?php
header('Content-Type: application/json');

require_once __DIR__ . '/db.php';

$conn = get_db_connection();
if (!$conn) {
    echo json_encode(["status" => "erro", "msg" => "Falha na conexão"]);
    exit;
}

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data) {
    echo json_encode(["status" => "erro", "msg" => "JSON inválido"]);
    exit;
}

$id = $data['id'] ?? null;
$name = $data['name'] ?? '';

if ($id === null) {
    echo json_encode(["status" => "erro", "msg" => "ID não encontrado"]);
    exit;
}

// REPLACE INTO: atualiza se existe, cria se não existe
$sql = "REPLACE INTO lideres_backup (id, name, dados_lider) VALUES (?, ?, ?)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(["status" => "erro", "msg" => "Erro ao preparar SQL: " . $conn->error]);
    exit;
}

$stmt->bind_param("iss", $id, $name, $json);

if ($stmt->execute()) {
    echo json_encode(["status" => "sucesso", "msg" => "Líder $name salvo com sucesso"]);
} else {
    echo json_encode(["status" => "erro", "msg" => "Erro ao salvar: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>