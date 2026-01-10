<?php
header('Content-Type: application/json');

require_once __DIR__ . '/db.php';

$conn = get_db_connection();
if (!$conn) {
    echo json_encode(["status" => "erro", "msg" => "Falha na conexão"]);
    exit;
}

// Busca Projetos com tratamento de erro
$resProjetos = $conn->query("SELECT id, cliente, nome_projeto, dados_completos FROM projetos_backup");
$projetos = [];

if ($resProjetos) {
    while($row = $resProjetos->fetch_assoc()) {
        if (!empty($row['dados_completos'])) {
            $decoded = json_decode($row['dados_completos'], true);
            if ($decoded !== null) {
                $projetos[] = $decoded;
            }
        }
    }
} else {
    error_log("Erro na query de projetos: " . $conn->error);
}

// Busca Líderes com tratamento de erro
$resLideres = $conn->query("SELECT id, dados_lider FROM lideres_backup");
$lideres = [];

if ($resLideres) {
    while($row = $resLideres->fetch_assoc()) {
        if (!empty($row['dados_lider'])) {
            $decoded = json_decode($row['dados_lider'], true);
            if ($decoded !== null) {
                $lideres[] = $decoded;
            }
        }
    }
} else {
    error_log("Erro na query de líderes: " . $conn->error);
}

echo json_encode([
    "status" => "sucesso",
    "projetos" => $projetos,
    "lideres" => $lideres,
    "total_projetos" => count($projetos),
    "total_lideres" => count($lideres)
]);

$conn->close();
?>