<?php
declare(strict_types=1);

require_once __DIR__ . '/brinquedos.php';

function escapar(string|int|float $valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$erro = null;
$brinquedo = null;
$lista = [];

try {
    if (isset($_GET['editar'])) {
        $id = filter_var($_GET['editar'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if ($id === false) {
            throw new InvalidArgumentException('Brinquedo inválido.');
        }
        $brinquedo = buscarBrinquedo($id);
        if ($brinquedo === false) {
            throw new InvalidArgumentException('Brinquedo não encontrado.');
        }
    }
    $lista = listarBrinquedos();
} catch (PDOException $e) {
    error_log($e->getMessage());
    $erro = 'Não foi possível acessar o banco de dados.';
} catch (InvalidArgumentException $e) {
    $erro = $e->getMessage();
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestão de Brinquedos</title>
</head>
<body>
    <h1>Gestão de Brinquedos</h1>

    <?php if ($erro !== null): ?>
        <p><?= escapar($erro) ?></p>
    <?php elseif (isset($_GET['salvo'])): ?>
        <p>Brinquedo salvo.</p>
    <?php elseif (isset($_GET['excluido'])): ?>
        <p>Brinquedo excluído.</p>
    <?php endif; ?>

    <h2><?= $brinquedo ? 'Editar brinquedo' : 'Cadastrar brinquedo' ?></h2>
    <form method="post" action="salvar.php">
        <?php if ($brinquedo): ?>
            <input type="hidden" name="id" value="<?= escapar($brinquedo['id']) ?>">
        <?php endif; ?>
        <p><label>Nome <input name="nome" maxlength="100" required value="<?= escapar($brinquedo['nome'] ?? '') ?>"></label></p>
        <p><label>Categoria <input name="categoria" maxlength="100" required value="<?= escapar($brinquedo['categoria'] ?? '') ?>"></label></p>
        <p><label>Faixa etária <input name="faixa_etaria" maxlength="50" required value="<?= escapar($brinquedo['faixa_etaria'] ?? '') ?>"></label></p>
        <p><label>Preço <input type="number" name="preco" min="0" max="99999999.99" step="0.01" required value="<?= escapar($brinquedo['preco'] ?? '') ?>"></label></p>
        <p><label>Quantidade em estoque <input type="number" name="quantidade_estoque" min="0" max="4294967295" step="1" required value="<?= escapar($brinquedo['quantidade_estoque'] ?? '') ?>"></label></p>
        <button type="submit">Salvar</button>
        <?php if ($brinquedo): ?><a href="index.php">Cancelar edição</a><?php endif; ?>
    </form>

    <h2>Brinquedos cadastrados</h2>
    <table border="1" cellpadding="6">
        <thead>
            <tr><th>Nome</th><th>Categoria</th><th>Faixa etária</th><th>Preço</th><th>Estoque</th><th>Ações</th></tr>
        </thead>
        <tbody>
            <?php foreach ($lista as $item): ?>
                <tr>
                    <td><?= escapar($item['nome']) ?></td>
                    <td><?= escapar($item['categoria']) ?></td>
                    <td><?= escapar($item['faixa_etaria']) ?></td>
                    <td>R$ <?= escapar(number_format((float) $item['preco'], 2, ',', '.')) ?></td>
                    <td><?= escapar($item['quantidade_estoque']) ?></td>
                    <td>
                        <a href="index.php?editar=<?= escapar($item['id']) ?>">Editar</a>
                        <form method="post" action="excluir.php" style="display:inline">
                            <input type="hidden" name="id" value="<?= escapar($item['id']) ?>">
                            <button type="submit">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$lista): ?>
                <tr><td colspan="6">Nenhum brinquedo cadastrado.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
