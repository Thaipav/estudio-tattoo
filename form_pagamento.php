<?php
// Conexão com o banco
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'estudio';

$conn = new mysqli($host, $user, $pass, $dbname);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Inserção de pagamento
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cliente = $_POST['id_cliente'] ?? '';
    $valor = $_POST['valor'] ?? '';
    $forma_de_pagamento = $_POST['forma_de_pagamento'] ?? '';
    $data_pagamento = $_POST['data_pagamento'] ?? '';
    $observacoes = $_POST['observacoes'] ?? '';

    $sql = "INSERT INTO pagamentos (id_cliente, valor, forma_de_pagamento, data_pagamento, observacoes) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("idsss", $id_cliente, $valor, $forma_de_pagamento, $data_pagamento, $observacoes);

    if ($stmt->execute()) {
        echo "<p>Pagamento registrado com sucesso!</p>";
    } else {
        echo "<p>Erro ao registrar pagamento: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

// Lista de clientes para o select
$clientes = $conn->query("SELECT id, nome FROM clientes ORDER BY nome ASC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Pagamentos</title>
    <style>
        :root {
            --preto: #111;
            --cinza-page: #bfbfbf;
            --cinza-card: #2a2a2a;
            --cinza-input: #3a3a3a;
            --rosa: #ff66b2;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Georgia, sans-serif;
            background: var(--cinza-page);
            color: #111;
        }

        header {
            background: var(--preto);
            color: white;
            text-align: center;
            padding: 32px 16px;
        }

        header h1 {
            margin: 0;
            font-size: 32px;
        }

        main {
            display: flex;
            justify-content: center;
            padding: 32px 16px;
            min-height: 100vh;
            align-items: center;
        }

        form {
            background: var(--cinza-card);
            color: white;
            width: 100%;
            max-width: 520px;
            padding: 28px;
            border-radius: 12px;
            box-shadow: 0 0 14px rgba(0, 0, 0, 0.25);
        }

        form h2 {
            margin: 0 0 20px;
            text-align: center;
            color: var(--rosa);
            font-weight: normal;
        }

        label {
            display: block;
            margin: 12px 0 6px;
            font-weight: 600;
            color: #e9e9e9;
        }

        input[type="text"],
        input[type="datetime-local"],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: var(--cinza-input);
            color: white;
            font-size: 14px;
            margin-bottom: 16px;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: 2px solid var(--rosa);
            background: #444;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        button {
            width: 100%;
            padding: 12px 16px;
            background: var(--preto);
            color: white;
            font-weight: bold;
            font-size: 16px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            transition: background 0.25s, color 0.25s, transform 0.3s;
        }

        button:hover {
            background: var(--rosa);
            color: var(--preto);
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<header>
    <img src="https://icons.iconarchive.com/icons/iconarchive/incognito-animal-2/128/Bat-icon.png" width="128" height="128" alt="Ícone" />
    <h1>Registrar Pagamento</h1>
</header>

<main>
    <form method="post" action="">
        <h2>Novo Pagamento</h2>

        <label for="id_cliente">Cliente</label>
        <select name="id_cliente" id="id_cliente" required>
            <option value="">Selecione um cliente</option>
            <?php foreach ($clientes as $cliente): ?>
                <option value="<?= htmlspecialchars($cliente['id']) ?>">
                    <?= htmlspecialchars($cliente['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="valor">Valor Pago</label>
        <!-- nome agora é "valor" para bater com o PHP -->
        <input type="text" id="valor" name="valor" required />

        <label for="data_pagamento">Data do Pagamento</label>
        <input type="datetime-local" id="data_pagamento" name="data_pagamento" required />

        <label for="forma_de_pagamento">Forma de Pagamento</label>
        <!-- nome agora é "forma_de_pagamento" para bater com o PHP -->
        <select id="forma_de_pagamento" name="forma_de_pagamento" required>
            <option value="">Selecione...</option>
            <option value="Débito">Débito</option>
            <option value="Crédito">Crédito</option>
            <option value="Pix ou Cédula">Pix ou Cédula</option>
        </select>

        <label for="observacoes">Observações</label>
        <textarea id="observacoes" name="observacoes" placeholder="Ex: pagamento parcial, desconto, etc."></textarea>

        <button type="submit">Registrar Pagamento</button>
    </form>
</main>

</body>
</html>
