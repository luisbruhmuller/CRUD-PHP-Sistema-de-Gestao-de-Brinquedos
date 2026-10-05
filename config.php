<?php
declare(strict_types=1);

function conexao(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $host = getenv('DB_HOST') ?: 'localhost';
        $nomeBanco = getenv('DB_NAME') ?: 'gestao_brinquedos';
        $usuario = getenv('DB_USER') ?: 'root';
        $senha = getenv('DB_PASSWORD') ?: '';

        $pdo = new PDO(
            "mysql:host={$host};dbname={$nomeBanco};charset=utf8mb4",
            $usuario,
            $senha,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
    }

    return $pdo;
}
