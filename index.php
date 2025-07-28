<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Estúdio de Tatuagem - Painel</title>
    <style>
        body {
            font-family: Georgia, sans-serif;
            background: #A9A9A9;
            margin: 0;
            padding: 0;
        }
        header {
            background:#1C1C1C;
            color: white;
            text-align: center;
            padding: 20px 0;
        }
        main {
            text-align: center;
            padding: 50px 20px;
        }
        h2 {
            margin-bottom: 40px;
        }
        .painel-links form {
            display: inline-block;
            margin: 10px;
        }
        .painel-links button {
            padding: 15px 30px;
            background: #1C1C1C;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: background 0.3s;
        }
        .painel-links button:hover {
            background:#1C1C1C;
             transform: scale(1.05);
        }
    </style>
</head>
<body>

    <header>
        <img src="https://icons.iconarchive.com/icons/iconarchive/incognito-animal-2/128/Bat-icon.png" width="128" height="128">
        <h1>Tattoo Ink</h1>
        <p>Painel Administrativo</p>
    </header>

    <main>
        <div class="painel-links">
            <button href="clientes.php">Clientes</button>
            <button href="agendas.php">Agendamentos</button>
            <button href="pagamentos.php">Pagamentos</button>
            <button href="add_cliente.php">➕ Novo Cliente</button>
        </div>
    </main>
</body>
</html>
