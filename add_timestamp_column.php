<?php
// Script para adicionar campos de timestamp nas tabelas
require_once __DIR__ . '/db.php';

$conn = get_db_connection();
if (!$conn) {
    die("Falha na conexão");
}

echo "Adicionando campos de timestamp...\n\n";

// Adicionar campo updated_at na tabela projetos_backup
$sql1 = "ALTER TABLE projetos_backup ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
if ($conn->query($sql1)) {
    echo "✓ Campo updated_at adicionado em projetos_backup\n";
} else {
    if (strpos($conn->error, 'Duplicate column') !== false) {
        echo "✓ Campo updated_at já existe em projetos_backup\n";
    } else {
        echo "Erro em projetos_backup: " . $conn->error . "\n";
    }
}

// Adicionar campo updated_at na tabela lideres
$sql2 = "ALTER TABLE lideres ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
if ($conn->query($sql2)) {
    echo "✓ Campo updated_at adicionado em lideres\n";
} else {
    if (strpos($conn->error, 'Duplicate column') !== false) {
        echo "✓ Campo updated_at já existe em lideres\n";
    } else {
        echo "Erro em lideres: " . $conn->error . "\n";
    }
}

// Adicionar campo updated_at na tabela lideres_backup
$sql3 = "ALTER TABLE lideres_backup ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
if ($conn->query($sql3)) {
    echo "✓ Campo updated_at adicionado em lideres_backup\n";
} else {
    if (strpos($conn->error, 'Duplicate column') !== false) {
        echo "✓ Campo updated_at já existe em lideres_backup\n";
    } else {
        echo "Erro em lideres_backup: " . $conn->error . "\n";
    }
}

$conn->close();
echo "\n✓ Processo concluído!\n";
?>
