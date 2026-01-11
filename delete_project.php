<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/debug.log');

// Log IMEDIATO - primeira coisa
file_put_contents(__DIR__ . '/debug.log', "[".date('Y-m-d H:i:s')."] delete_project.php CHEGOU NA FUNÇÃO (método: " . $_SERVER['REQUEST_METHOD'] . ")".PHP_EOL, FILE_APPEND);

header('Content-Type: application/json');

require_once __DIR__ . '/db.php';

@file_put_contents(__DIR__ . '/debug.log', "[".date('Y-m-d H:i:s')."] delete_project.php START".PHP_EOL, FILE_APPEND);

$conn = get_db_connection();
if (!$conn) {
    @file_put_contents(__DIR__ . '/debug.log', "[".date('Y-m-d H:i:s')."] delete_project.php ERRO_CONEXAO".PHP_EOL, FILE_APPEND);
    echo json_encode(["status" => "erro", "msg" => "Falha na conexão"]);
    exit;
}

// leitura do body e log para depuração
$raw = file_get_contents('php://input');
@file_put_contents(__DIR__ . '/debug.log', "[".date('Y-m-d H:i:s')."] delete_project.php REQUEST: ". $raw . PHP_EOL, FILE_APPEND);
$data = json_decode($raw, true);
$id = $data['id'] ?? null;

if ($id) {
    @file_put_contents(__DIR__ . '/debug.log', "[".date('Y-m-d H:i:s')."] delete_project.php Tentando deletar ID: $id".PHP_EOL, FILE_APPEND);
    
    // Prepara a query para deletar da tabela projetos_backup
    $stmt = $conn->prepare("DELETE FROM projetos_backup WHERE id = ?");
    if (!$stmt) {
        @file_put_contents(__DIR__ . '/debug.log', "[".date('Y-m-d H:i:s')."] delete_project.php ERROR_PREPARE: " . $conn->error . PHP_EOL, FILE_APPEND);
        echo json_encode(["status" => "erro", "msg" => "Erro ao preparar SQL: " . $conn->error]);
        $conn->close();
        exit;
    }
    
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $affected = $stmt->affected_rows;
        @file_put_contents(__DIR__ . '/debug.log', "[".date('Y-m-d H:i:s')."] delete_project.php SUCESSO: Deletado ID=$id (linhas afetadas: $affected)".PHP_EOL, FILE_APPEND);
        echo json_encode(["status" => "sucesso", "msg" => "Projeto excluído"]);
    } else {
        $err = $stmt->error;
        @file_put_contents(__DIR__ . '/debug.log', "[".date('Y-m-d H:i:s')."] delete_project.php SQL_ERROR: " . $err . PHP_EOL, FILE_APPEND);
        echo json_encode(["status" => "erro", "msg" => $err]);
    }
    $stmt->close();
} else {
    @file_put_contents(__DIR__ . '/debug.log', "[".date('Y-m-d H:i:s')."] delete_project.php ERROR: ID não fornecido".PHP_EOL, FILE_APPEND);
    echo json_encode(["status" => "erro", "msg" => "ID não fornecido"]);
}

$conn->close();
?>