<?php
declare(strict_types=1);

require_once __DIR__ . '/brinquedos.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    mostrarErro('Método não permitido.', 405);
}

try {
    $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if ($id === false || buscarBrinquedo($id) === false) {
        throw new InvalidArgumentException('Brinquedo não encontrado.');
    }

    excluirBrinquedo($id);
    header('Location: index.php?excluido=1', true, 303);
    exit;
} catch (InvalidArgumentException $e) {
    mostrarErro($e->getMessage());
} catch (PDOException $e) {
    error_log($e->getMessage());
    mostrarErro('Não foi possível excluir o brinquedo.', 500);
}
