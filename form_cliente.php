<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $email = $_POST['email'] ?? '';
    $data_nascimento = $_POST['data_nascimento'] ?? '';
    $observacoes = $_POST['observacoes'] ?? '';

    $mysqli = new mysqli("localhost", "root", "", "estudio");

    if ($mysqli->connect_errno) {
        $mensagem = "<div class='msg err'>❌ Erro ao conectar: " . $mysqli->connect_error . "</div>";
    } else {
        $sql = "INSERT INTO clientes (nome, telefone, email, nascimento, observacoes)
                VALUES ('$nome', '$telefone', '$email', '$data_nascimento', '$observacoes')";

        if ($mysqli->query($sql) === TRUE) {
            $mensagem = "<div class='msg ok'>✅ Cliente cadastrado com sucesso!</div>";
        } else {
            $mensagem = "<div class='msg err'>❌ Erro ao cadastrar: " . $mysqli->error . "</div>";
        }

        $mysqli->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Novo Cliente - Tattoo Ink</title>
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

        header img {
            height: 90px;
        }

        header h1 {
            margin: 10px 0 4px;
            font-size: 36px;
        }

        header p {
            margin: 0;
            opacity: 0.9;
        }

        main {
            display: flex;
            justify-content: center;
            padding: 32px 16px;
        }

        form {
            background: var(--cinza-card);
            color: white;
            width: 100%;
            max-width: 520px;
            padding: 28px;
            border-radius: 12px;
            box-shadow: 0 0 14px rgba(0, 0, 0, .25);
        }

        form h2 {
            margin: 0 0 20px;
            text-align: center;
            color: var(--rosa);
        }

        label {
            display: block;
            margin: 12px 0 6px;
            font-weight: 600;
            color: #e9e9e9;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: var(--cinza-input);
            color: white;
            font-size: 14px;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        textarea::placeholder {
            color: #aaa;
        }

        .btn-submit {
            margin-top: 16px;
            width: 100%;
            padding: 12px 16px;
            border: none;
            border-radius: 10px;
            background: var(--preto);
            color: white;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: background .25s, color .25s;
        }

        .btn-submit:hover {
            background: var(--rosa);
            color: var(--preto);
        }

        .msg {
            text-align: center;
            padding: 12px 16px;
            border-radius: 8px;
            margin: 16px auto 0;
            max-width: 520px;
            font-weight: bold;
        }

        .ok {
            background: #e0f7ec;
            color: #1b5e20;
        }

        .err {
            background: #fdecea;
            color: #c62828;
        }
    </style>
</head>
<body>

<header>
    <img src="https://icons.iconarchive.com/icons/iconarchive/incognito-animal-2/128/Bat-icon.png" width="128" height="128">
    <h1>Tattoo Ink</h1>
    <p>Painel Administrativo</p>
</header>

<?php if (!empty($mensagem)) echo $mensagem; ?>

<main>
    <form method="POST">
        <h2>Cadastrar Novo Cliente</h2>

        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" required>

        <label for="telefone">Telefone</label>
        <input type="text" id="telefone" name="telefone" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email">

        <label for="data_nascimento">Data de nascimento</label>
        <input type="date" id="data_nascimento" name="data_nascimento">

        <label for="observacoes">Observações</label>
        <textarea id="observacoes" name="observacoes" placeholder="Tatuagens, estilo, preferências..."></textarea>

        <button type="submit" class="btn-submit">Cadastrar Cliente</button>
    </form>
</main>

</body>
</html>
