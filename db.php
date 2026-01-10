<?php
// Arquivo central de conexão com o banco
$DB_HOST = "127.0.0.2";
$DB_USER = "root";
$DB_PASS = "59380204Mm@";
$DB_NAME = "gestao_projetos";
$DB_PORT = 3306;

function get_db_connection() {
    global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT;
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);
    if ($conn->connect_error) {
        return null;
    }
    return $conn;
}

function respond_json_and_exit($payload) {
    header('Content-Type: application/json');
    echo json_encode($payload);
    exit;
}

?>
