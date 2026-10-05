<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

function listarBrinquedos(): array
{
    $consulta = conexao()->prepare('SELECT id, nome, categoria, faixa_etaria, preco, quantidade_estoque FROM brinquedos ORDER BY id DESC');
    $consulta->execute();
    return $consulta->fetchAll();
}

function buscarBrinquedo(int $id): array|false
{
    $consulta = conexao()->prepare('SELECT id, nome, categoria, faixa_etaria, preco, quantidade_estoque FROM brinquedos WHERE id = :id');
    $consulta->execute(['id' => $id]);
    return $consulta->fetch();
}

function cadastrarBrinquedo(array $dados): void
{
    $consulta = conexao()->prepare(
        'INSERT INTO brinquedos (nome, categoria, faixa_etaria, preco, quantidade_estoque)
         VALUES (:nome, :categoria, :faixa_etaria, :preco, :quantidade_estoque)'
    );
    $consulta->execute($dados);
}

function atualizarBrinquedo(int $id, array $dados): void
{
    $consulta = conexao()->prepare(
        'UPDATE brinquedos SET nome = :nome, categoria = :categoria,
         faixa_etaria = :faixa_etaria, preco = :preco,
         quantidade_estoque = :quantidade_estoque WHERE id = :id'
    );
    $consulta->execute($dados + ['id' => $id]);
}

function excluirBrinquedo(int $id): void
{
    $consulta = conexao()->prepare('DELETE FROM brinquedos WHERE id = :id');
    $consulta->execute(['id' => $id]);
}

function validarDados(array $entrada): array
{
    foreach (['nome', 'categoria', 'faixa_etaria', 'preco', 'quantidade_estoque'] as $campo) {
        if (!isset($entrada[$campo]) || !is_string($entrada[$campo])) {
            throw new InvalidArgumentException('Preencha todos os campos corretamente.');
        }
    }

    $nome = trim($entrada['nome']);
    $categoria = trim($entrada['categoria']);
    $faixaEtaria = trim($entrada['faixa_etaria']);
    $preco = trim($entrada['preco']);
    $quantidade = trim($entrada['quantidade_estoque']);

    if ($nome === '' || strlen($nome) > 100) {
        throw new InvalidArgumentException('O nome deve ter entre 1 e 100 caracteres.');
    }
    if ($categoria === '' || strlen($categoria) > 100) {
        throw new InvalidArgumentException('A categoria deve ter entre 1 e 100 caracteres.');
    }
    if ($faixaEtaria === '' || strlen($faixaEtaria) > 50) {
        throw new InvalidArgumentException('A faixa etária deve ter entre 1 e 50 caracteres.');
    }
    if (!preg_match('/^\d{1,8}(\.\d{1,2})?$/', $preco)) {
        throw new InvalidArgumentException('Informe um preço válido, com até duas casas decimais.');
    }
    if (!preg_match('/^\d+$/', $quantidade) || (float) $quantidade > 4294967295) {
        throw new InvalidArgumentException('Informe uma quantidade inteira não negativa.');
    }

    return [
        'nome' => $nome,
        'categoria' => $categoria,
        'faixa_etaria' => $faixaEtaria,
        'preco' => $preco,
        'quantidade_estoque' => (int) $quantidade,
    ];
}

function mostrarErro(string $mensagem, int $codigo = 400): never
{
    http_response_code($codigo);
    $texto = htmlspecialchars($mensagem, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    echo '<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><title>Erro</title></head><body>';
    echo '<p>' . $texto . '</p><a href="index.php">Voltar</a></body></html>';
    exit;
}
