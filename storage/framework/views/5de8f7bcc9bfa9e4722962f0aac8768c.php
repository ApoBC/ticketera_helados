<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Heladería - Bienvenido</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f472b6, #fbbf24, #60a5fa);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 500px;
        }
        h1 {
            font-size: 3em;
            color: #ec4899;
            margin: 0;
        }
        .emoji {
            font-size: 4em;
        }
        .subtitle {
            color: #6b7280;
            font-size: 1.2em;
        }
        .btn {
            display: inline-block;
            background: #ec4899;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            margin-top: 20px;
            transition: transform 0.3s;
        }
        .btn:hover {
            transform: scale(1.05);
            background: #db2777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="emoji">🍦</div>
        <h1>Heladería</h1>
        <p class="subtitle">"El sabor que te refresca"</p>
        <a href="/dashboard" class="btn">Ir al Dashboard</a>
    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\Heladeria v1\ticketera_helados\resources\views/welcome.blade.php ENDPATH**/ ?>