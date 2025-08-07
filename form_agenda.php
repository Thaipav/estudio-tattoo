<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'estudio';

$conn = new mysqli($host, $user, $pass, $dbname);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$mensagem = '';

$result = $conn->query("SELECT id, nome FROM clientes");
if ($result) {
    $clientes = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $clientes = [];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_do_cliente = trim($_POST['nome_do_cliente'] ?? '');
    $tipo_de_servico = trim($_POST['tipo_de_servico'] ?? '');
    $local = trim($_POST['local'] ?? '');
    $data_hora = trim($_POST['data_hora'] ?? '');
    $status = trim($_POST['status'] ?? '');
    $observacoes = trim($_POST['observacoes'] ?? '');
    $id_cliente = intval($_POST['id_cliente'] ?? 0);

    if ($nome_do_cliente && $tipo_de_servico && $local && $data_hora && $status && $id_cliente > 0) {
        $stmt = $conn->prepare("
            INSERT INTO agenda (nome_do_cliente, tipo_de_servico, local, data_hora, status, `observações`, id_cliente) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        if ($stmt === false) {
            die("Erro na preparação da query: " . $conn->error);
        }

        $stmt->bind_param("ssssssi", $nome_do_cliente, $tipo_de_servico, $local, $data_hora, $status, $observacoes, $id_cliente);

        if ($stmt->execute()) {
            $mensagem = "✅ Agendamento inserido com sucesso!";
        } else {
            $mensagem = "❌ Erro ao inserir agendamento: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $mensagem = "⚠️ Preencha todos os campos obrigatórios corretamente.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Agendamento</title>
    <style>
        :root {
            --preto: #111;
            --cinza-page: #bfbfbf;
            --cinza-card: #2a2a2a;
            --cinza-input: #3a3a3a;
            --rosa: #ff66b2;
        }
        * { box-sizing: border-box; }
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
        header h1 { margin: 0; font-size: 32px; }
        main {
            display: flex;
            justify-content: center;
            padding: 32px 16px;
            min-height: 100vh;
            align-items: center;
            flex-direction: column;
        }
        form {
            background: var(--cinza-card);
            color: white;
            width: 100%;
            max-width: 520px;
            padding: 28px;
            border-radius: 12px;
            box-shadow: 0 0 14px rgba(0,0,0,0.25);
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
        .mensagem {
            margin-bottom: 20px;
            font-weight: bold;
            color: var(--rosa);
            text-align: center;
        }
    </style>
</head>
<body>
<header>
    <img src="https://icons.iconarchive.com/icons/iconarchive/incognito-animal-2/128/Bat-icon.png" width="128" height="128" alt="Logo" />
    <h1>Agendamento</h1>
</header>
<main>
    <?php if ($mensagem): ?>
        <div class="mensagem"><?= htmlspecialchars($mensagem) ?></div>
    <?php endif; ?>

    <form action="" method="post">
        <h2>Novo Agendamento</h2>

        <label for="nome_do_cliente">Nome do Cliente</label>
        <input type="text" id="nome_do_cliente" name="nome_do_cliente" required />

        <label for="tipo_de_servico">Tipo de Serviço</label>
        <select id="tipo_de_servico" name="tipo_de_servico" required>
            <option value="">Selecione...</option>
            <option value="Tatuagem">Tatuagem</option>
            <option value="Piercing">Piercing</option>
        </select>

        <label for="local">Local</label>
        <input type="text" id="local" name="local" required />

        <label for="data_hora">Data e Hora</label>
        <input type="datetime-local" id="data_hora" name="data_hora" required />

        <label for="status">Status</label>
        <select id="status" name="status" required>
            <option value="">Selecione...</option>
            <option value="Pendente">Pendente</option>
            <option value="Confirmado">Confirmado</option>
            <option value="Cancelado">Cancelado</option>
        </select>

        <label for="observacoes">Observações</label>
        <textarea id="observacoes" name="observacoes" placeholder="Detalhes do agendamento..."></textarea>

        <label for="id_cliente">Cliente</label>
        <select name="id_cliente" id="id_cliente" required>
            <option value="">Selecione...</option>
            <?php foreach ($clientes as $cliente): ?>
                <option value="<?= $cliente['id'] ?>"><?= htmlspecialchars($cliente['nome']) ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Agendar</button>
    </form>
</main>
</body>
</html>

