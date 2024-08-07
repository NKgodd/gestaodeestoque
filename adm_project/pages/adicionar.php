<?php
include '../db.php';
include '../templates/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $quantidade = $_POST['quantidade'];
    $preco = $_POST['preco'];
    $data_validade = $_POST['data_validade'];

    $sql = 'INSERT INTO produtos (nome, quantidade, preco, data_validade) VALUES (?, ?, ?, ?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $quantidade, $preco, $data_validade]);

    header('Location: index.php');
    exit;
}
?>

<h2>Adicionar Novo Produto</h2>
<form method="post">
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" required><br>
    <label for="quantidade">Quantidade:</label>
    <input type="number" id="quantidade" name="quantidade" required><br>
    <label for="preco">Preço:</label>
    <input type="text" id="preco" name="preco" required><br>
    <label for="data_validade">Data de Validade:</label>
    <input type="date" id="data_validade" name="data_validade"><br>
    <input type="submit" value="Adicionar">
</form>

<?php include '../templates/footer.php'; ?>
