<?php
session_start();
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: login.php');
    exit;
}

include '../db.php';
include '../templates/header.php';


// Obter produtos do banco de dados
$sql = 'SELECT * FROM produtos';
$stmt = $pdo->query($sql);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obter totais
$totals = getTotals($pdo);

// Determinar o comprimento do ID com base no maior ID no banco de dados
$max_id_length = 3; // Número de dígitos desejado
?>

<h2 class="lista-produtos">Lista de Produtos</h2>
<table>
    <thead>
        <tr>
            <th class="ides-table">ID</th>
            <th class="ides-table">Nome</th>
            <th class="ides-table">Quantidade</th>
            <th class="ides-table">Preço</th>
            <th class="ides-table">Data de Validade</th>
            <th class="ides-table">Ações</th> <!-- Adicionei coluna de ações -->
        </tr>
    </thead>
    <tbody>
        <?php foreach ($produtos as $produto): ?>
            <tr class="tr-forms">
                <?php
                // Verifique o valor do ID antes de formatar
                $id = $produto['id'];
                echo "<!-- ID: $id -->"; // Para depuração
                // Formata o ID com zeros à esquerda
                $id_formatado = str_pad($id, $max_id_length, '0', STR_PAD_LEFT);
                ?>
                <td class="td-forms"><?php echo htmlspecialchars($id_formatado); ?></td>
                <td class="td-forms"><?php echo htmlspecialchars($produto['nome']); ?></td>
                <td class="td-forms"><?php echo htmlspecialchars($produto['quantidade']); ?></td>
                <td class="td-forms"><?php echo htmlspecialchars($produto['preco']); ?></td>
                <td class="td-forms"><?php echo htmlspecialchars($produto['data_validade']); ?></td>
                <td>
                    <a href="editar.php?id=<?php echo $produto['id']; ?>">Editar</a>
                    <a href="excluir.php?id=<?php echo $produto['id']; ?>">Excluir</a>
                    <a href="adicionar_estoque.php?nome=<?php echo htmlspecialchars($produto['nome']); ?>">Adicionar ao Estoque</a>
                    <a s href="../pages/comprar.php">Retirar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="container-totais">
    <h4>Totais</h4>
    <p class="text-total">Quantidade Total: <?php echo htmlspecialchars($totals['total_quantidade']); ?></p>
    <p class="text-total">Valor Total: R$ <?php echo number_format($totals['total_valor'], 2, ',', '.'); ?></p>
    
</div>

<?php include '../templates/footer.php'; ?>
