<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/debug.log');

header('Content-Type: application/json');

require_once __DIR__ . '/db.php';

@file_put_contents(__DIR__ . '/debug.log', "[".date('Y-m-d H:i:s')."] salvar_projeto.php START".PHP_EOL, FILE_APPEND);

$conn = get_db_connection();
if (!$conn) {
    @file_put_contents(__DIR__ . '/debug.log', "[".date('Y-m-d H:i:s')."] salvar_projeto.php ERRO_CONEXAO".PHP_EOL, FILE_APPEND);
    echo json_encode(["status" => "erro", "msg" => "Falha na conexão"]);
    exit;
}

// Recebe o projeto do JavaScript
// leitura do body e log para depuração
$raw = file_get_contents('php://input');
@file_put_contents(__DIR__ . '/debug.log', "[".date('Y-m-d H:i:s')."] salvar_projeto.php REQUEST: ". $raw . PHP_EOL, FILE_APPEND);
$data = json_decode($raw, true);

// Aceita dois formatos: { "project": { ... } } ou o próprio objeto do projeto
$project = null;
if (is_array($data) && array_key_exists('project', $data) && is_array($data['project'])) {
    $project = $data['project'];
} elseif (is_array($data)) {
    $project = $data;
}

if (!$project) {
    $msg = "JSON de projeto inválido";
    @file_put_contents(__DIR__ . '/debug.log', "[".date('Y-m-d H:i:s')."] salvar_projeto.php ERROR: " . $msg . PHP_EOL, FILE_APPEND);
    echo json_encode(["status" => "erro", "msg" => $msg]);
    $conn->close();
    exit;
}

$id      = $project['id'] ?? null;
$cliente = $project['cliente'] ?? ($project['client'] ?? '');
$projeto = $project['projectName'] ?? ($project['nome_projeto'] ?? '');

if ($id === null) {
    @file_put_contents(__DIR__ . '/debug.log', "[".date('Y-m-d H:i:s')."] salvar_projeto.php ERROR: ID do projeto não fornecido".PHP_EOL, FILE_APPEND);
    echo json_encode(["status" => "erro", "msg" => "ID do projeto não fornecido"]);
    $conn->close();
    exit;
}

// Armazenar apenas o objeto do projeto (não o wrapper)
$jsonToStore = json_encode($project, JSON_UNESCAPED_UNICODE);

$sql = "REPLACE INTO projetos_backup (id, cliente, nome_projeto, dados_completos) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(["status" => "erro", "msg" => "Erro ao preparar SQL: " . $conn->error]);
    $conn->close();
    exit;
}

$stmt->bind_param("isss", $id, $cliente, $projeto, $jsonToStore);

if ($stmt->execute()) {
    @file_put_contents(__DIR__ . '/debug.log', "[".date('Y-m-d H:i:s')."] salvar_projeto.php SUCESSO: Projeto $id salvo".PHP_EOL, FILE_APPEND);
    echo json_encode(["status" => "sucesso", "msg" => "Projeto $id sincronizado"]);
} else {
    $err = $stmt->error;
    @file_put_contents(__DIR__ . '/debug.log', "[".date('Y-m-d H:i:s')."] salvar_projeto.php SQL_ERROR: " . $err . PHP_EOL, FILE_APPEND);
    echo json_encode(["status" => "erro", "msg" => $err]);
}

$stmt->close();
$conn->close();
?>