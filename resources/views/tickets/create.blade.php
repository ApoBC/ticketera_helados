<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Nuevo Ticket - Heladería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-4">
        <h1 class="h3 mb-4">Nuevo Ticket</h1>
        <div class="card shadow-sm" style="max-width: 500px;">
            <div class="card-body">
                <form action="{{ route('tickets.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Nombre del cliente</label>
                        <input type="text" name="customer_name" id="customer_name" 
                               class="form-control" required maxlength="100" autofocus>
                    </div>
                    <button type="submit" class="btn btn-primary">Iniciar Ticket</button>
                    <a href="{{ route('tickets.index') }}" class="btn btn-link">Volver</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>