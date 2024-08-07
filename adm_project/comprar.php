<?php
include '../db.php';  // Inclui a conexão com o banco de dados
include '../templates/header.php';  // Inclui o cabeçalho

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_produto = $_POST['nome_produto'];
    $quantidade_comprada = $_POST['quantidade'];

    try {
        // Inicia a transação
        $pdo->beginTransaction();

        // Verifica a quantidade atual do produto pelo nome
        $stmt = $pdo->prepare('SELECT quantidade FROM produtos WHERE nome = ?');
        $stmt->execute([$nome_produto]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($produto && $produto['quantidade'] >= $quantidade_comprada) {
            // Calcula a nova quantidade
            $nova_quantidade = $produto['quantidade'] - $quantidade_comprada;

            // Atualiza a quantidade do produto no banco de dados
            $stmt = $pdo->prepare('UPDATE produtos SET quantidade = ? WHERE nome = ?');
            $stmt->execute([$nova_quantidade, $nome_produto]);

            // Confirma a transação
            $pdo->commit();

            echo 'Compra realizada com sucesso. Estoque atualizado.';

            header('Location: index.php');
            exit;
        } else {
            echo 'Quantidade insuficiente no estoque.';
        }
    } catch (Exception $e) {
        // Em caso de erro, desfaz a transação
        $pdo->rollBack();
        echo 'Erro ao processar a compra: ' . $e->getMessage();
    }
}
?>

<h2>Retirada de Produto</h2>
<form method="post" action="comprar.php">
    <label for="nome_produto">Nome do Produto:</label>
    <input type="text" id="nome_produto" name="nome_produto" required><br>
    <label for="quantidade">Quantidade:</label>
    <input type="number" id="quantidade" name="quantidade" required><br>
    <input type="submit" value="Saida">
</form>

<?php include '../templates/footer.php';  // Inclui o rodapé ?>
