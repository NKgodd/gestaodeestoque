<?php
include '../db.php';
include '../templates/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $quantidade = $_POST['quantidade'];
    $preco = $_POST['preco'];
    $data_validade = $_POST['data_validade'];

    $sql = 'UPDATE produtos SET nome = ?, quantidade = ?, preco = ?, data_validade = ? WHERE id = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $quantidade, $preco, $data_validade, $id]);

    header('Location: index.php');
    exit;
}

$id = $_GET['id'];
$sql = 'SELECT * FROM produtos WHERE id = ?';
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<h2>Editar Produto</h2>
<form method="post">
    <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" value="<?php echo $produto['nome']; ?>" required><br>
    <label for="quantidade">Quantidade:</label>
    <input type="number" id="quantidade" name="quantidade" value="<?php echo $produto['quantidade']; ?>" required><br>
    <label for="preco">Preço:</label>
    <input type="text" id="preco" name="preco" value="<?php echo $produto['preco']; ?>" required><br>
    <label for="data_validade">Data de Validade:</label>
    <input type="date" id="data_validade" name="data_validade" value="<?php echo $produto['data_validade']; ?>"><br>
    <input type="submit" value="Atualizar">
</form>

<?php include '../templates/footer.php'; ?>
