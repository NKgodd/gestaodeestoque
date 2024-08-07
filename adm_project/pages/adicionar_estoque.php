<?php
include '../db.php';
include '../templates/header.php';

$nome_produto = isset($_GET['nome']) ? $_GET['nome'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_produto = $_POST['nome_produto'];
    $quantidade_adicionada = $_POST['quantidade'];

    try {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare('SELECT quantidade FROM produtos WHERE nome = ?');
        $stmt->execute([$nome_produto]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($produto) {
            $nova_quantidade = $produto['quantidade'] + $quantidade_adicionada;
            $stmt = $pdo->prepare('UPDATE produtos SET quantidade = ? WHERE nome = ?');
            $stmt->execute([$nova_quantidade, $nome_produto]);
            $pdo->commit();

            header('Location: index.php');
            exit;

            echo 'Quantidade adicionada ao estoque com sucesso.';
        } else {
            echo 'Produto não encontrado.';
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        echo 'Erro ao adicionar quantidade ao estoque: ' . $e->getMessage();
    }
}
?>

<h2>Adicionar ao Estoque</h2>
<form method="post" action="adicionar_estoque.php">
    <label for="nome_produto">Nome do Produto:</label>
    <input type="text" id="nome_produto" name="nome_produto" value="<?php echo htmlspecialchars($nome_produto); ?>" required><br>
    <label for="quantidade">Quantidade:</label>
    <input type="number" id="quantidade" name="quantidade" required><br>
    <input type="submit" value="Adicionar ao Estoque">
</form>

<?php include '../templates/footer.php'; ?>
