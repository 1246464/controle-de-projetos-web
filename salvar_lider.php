<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/debug.log');

header('Content-Type: application/json');

require_once __DIR__ . '/db.php';

@file_put_contents(__DIR__ . '/debug.log', "[".date('Y-m-d H:i:s')."] salvar_lider.php START".PHP_EOL, FILE_APPEND);

$conn = get_db_connection();
if (!$conn) {
    @file_put_contents(__DIR__ . '/debug.log', "[".date('Y-m-d H:i:s')."] salvar_lider.php ERRO_CONEXAO".PHP_EOL, FILE_APPEND);
    echo json_encode(["status" => "erro", "msg" => "Falha na conexão"]);
    exit;
}

// leitura do body e log para depuração
$raw = file_get_contents('php://input');
@file_put_contents(__DIR__ . '/debug.log', "[".date('Y-m-d H:i:s')."] salvar_lider.php REQUEST: ". $raw . PHP_EOL, FILE_APPEND);
$data = json_decode($raw, true);

// Aceita { "leader": { ... } } ou o próprio objeto líder
$leader = null;
if (is_array($data) && array_key_exists('leader', $data) && is_array($data['leader'])) {
    $leader = $data['leader'];
} elseif (is_array($data)) {
    $leader = $data;
}

if (!$leader) {
    $msg = "JSON de líder inválido";
    @file_put_contents(__DIR__ . '/debug.log', "[".date('Y-m-d H:i:s')."] salvar_lider.php ERROR: " . $msg . PHP_EOL, FILE_APPEND);
    echo json_encode(["status" => "erro", "msg" => $msg]);
    $conn->close();
    exit;
}

$id = $leader['id'] ?? null;
$name = $leader['name'] ?? ($leader['nome'] ?? '');

if ($id === null) {
    @file_put_contents(__DIR__ . '/debug.log', "[".date('Y-m-d H:i:s')."] salvar_lider.php ERROR: ID não encontrado".PHP_EOL, FILE_APPEND);
    echo json_encode(["status" => "erro", "msg" => "ID não encontrado"]);
    $conn->close();
    exit;
}

$jsonToStore = json_encode($leader, JSON_UNESCAPED_UNICODE);

// A tabela lideres_backup tem apenas colunas: id, dados_lider (sem coluna 'name')
$sql = "REPLACE INTO lideres_backup (id, dados_lider) VALUES (?, ?)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    @file_put_contents(__DIR__ . '/debug.log', "[".date('Y-m-d H:i:s')."] salvar_lider.php ERROR_PREPARE: " . $conn->error . PHP_EOL, FILE_APPEND);
    echo json_encode(["status" => "erro", "msg" => "Erro ao preparar SQL: " . $conn->error]);
    $conn->close();
    exit;
}

$stmt->bind_param("is", $id, $jsonToStore);

if ($stmt->execute()) {
    @file_put_contents(__DIR__ . '/debug.log', "[".date('Y-m-d H:i:s')."] salvar_lider.php SUCESSO: Líder id=$id salvo".PHP_EOL, FILE_APPEND);
    echo json_encode(["status" => "sucesso", "msg" => "Líder salvo com sucesso"]);
} else {
    $err = $stmt->error;
    @file_put_contents(__DIR__ . '/debug.log', "[".date('Y-m-d H:i:s')."] salvar_lider.php SQL_ERROR: " . $err . PHP_EOL, FILE_APPEND);
    echo json_encode(["status" => "erro", "msg" => "Erro ao salvar: " . $err]);
}

$stmt->close();
$conn->close();
?>