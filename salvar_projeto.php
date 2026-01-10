<?php
header('Content-Type: application/json');

require_once __DIR__ . '/db.php';

$conn = get_db_connection();
if (!$conn) {
    echo json_encode(["status" => "erro", "msg" => "Falha na conexão"]);
    exit;
}

// Recebe o projeto do JavaScript
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Pegamos as informações principais para as colunas do banco
$id      = $data['id'] ?? null;
$cliente = $data['cliente'] ?? '';
$projeto = $data['projectName'] ?? '';

if ($id === null) {
    echo json_encode(["status" => "erro", "msg" => "ID do projeto não fornecido"]);
    exit;
}

// O REPLACE INTO é perfeito aqui: se o ID já existir (edição), ele atualiza.
// Se não existir (novo), ele cria. Isso evita duplicatas.
$sql = "REPLACE INTO projetos_backup (id, cliente, nome_projeto, dados_completos) VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
// "isss" -> id (inteiro), cliente (texto), projeto (texto), json (texto)
$stmt->bind_param("isss", $id, $cliente, $projeto, $json);

if ($stmt->execute()) {
    echo json_encode(["status" => "sucesso", "msg" => "Projeto $id sincronizado"]);
} else {
    echo json_encode(["status" => "erro", "msg" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>