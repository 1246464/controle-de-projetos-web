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
$id = $data['id'] ?? null;

if ($id) {
    // Prepara a query para deletar da tabela projetos_backup
    $stmt = $conn->prepare("DELETE FROM projetos_backup WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "sucesso", "msg" => "Projeto excluído"]);
    } else {
        echo json_encode(["status" => "erro", "msg" => $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(["status" => "erro", "msg" => "ID não fornecido"]);
}

$conn->close();
?>