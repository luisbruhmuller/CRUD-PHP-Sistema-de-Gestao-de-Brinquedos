<?php
declare(strict_types=1);

require_once __DIR__ . '/brinquedos.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    mostrarErro('Método não permitido.', 405);
}

try {
    $dados = validarDados($_POST);

    if (isset($_POST['id'])) {
        $id = filter_var($_POST['id'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if ($id === false || buscarBrinquedo($id) === false) {
            throw new InvalidArgumentException('Brinquedo não encontrado.');
        }
        atualizarBrinquedo($id, $dados);
    } else {
        cadastrarBrinquedo($dados);
    }

    header('Location: index.php?salvo=1', true, 303);
    exit;
} catch (InvalidArgumentException $e) {
    mostrarErro($e->getMessage());
} catch (PDOException $e) {
    error_log($e->getMessage());
    mostrarErro('Não foi possível salvar o brinquedo.', 500);
}
