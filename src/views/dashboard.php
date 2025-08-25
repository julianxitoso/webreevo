<?php
// Este archivo es la vista para el dashboard. 
// Las variables $userName y $ssoToken son proporcionadas por el método dashboard() en HomeController.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - RE·EVO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/styles.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #e4e9ea;
            color: #333;
            padding-top: 110px; 
        }
        .navbar-brand img {
            height: 95px;
        }
        .service-card {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease-in-out;
            text-decoration: none;
            color: inherit;
            display: block;
            height: 100%;
        }
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .service-card .card-body {
            padding: 2rem;
            text-align: center;
        }
        .service-card .card-icon {
            font-size: 4rem;
            color: #0D1B2A;
            margin-bottom: 1.5rem;
            display: block;
        }
        .service-card .card-title {
            font-weight: 600;
            color: #2c3e50;
        }
        .service-card .card-text {
            color: #6c757d;
        }
        .welcome-header {
            background: url('/public/images/reevo-01.png') no-repeat center center;
            background-size: cover;
            padding: 4rem 2rem;
            border-radius: .5rem;
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/#">
                <img src="/public/images/logo.png" alt="RE·EVO 2030 Logo">
            </a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/logout">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <main class="container mt-5">
        <header class="p-5 mb-4 bg-light rounded-3 welcome-header">
            <div class="container-fluid py-5 text-center">
                <h1 class="display-5 fw-bold">Bienvenido, <?php echo htmlspecialchars($userName); ?></h1>
                <p class="fs-4">Desde aquí puedes acceder a los servicios conectados de forma segura.</p>
            </div>
        </header>

        <section id="services" class="py-5">
            <div class="container text-center">
                <h2 class="section-title mb-5">Nuestros Servicios</h2>
                <div class="row justify-content-center">
                    <div class="col-md-5 mb-4">
                        <a href="http://mesadeayuda.electrocreditosdelcauca.com/sso-login.php?token=<?php echo urlencode($ssoToken); ?>" class="service-card" target="_blank">
                            <div class="card-body">
                                <i class="bi bi-headset card-icon"></i>
                                <h5 class="card-title">Mesa de Ayuda</h5>
                                <p class="card-text">Acceder al sistema de tickets y soporte (usa el email).</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-5 mb-4">
                        <a href="http://otro-servicio.com/sso-login.php?token=<?php echo urlencode($ssoToken); ?>" class="service-card" target="_blank">
                             <div class="card-body">
                                <i class="bi bi-person-badge card-icon"></i>
                                <h5 class="card-title">Servicio por Cédula</h5>
                                <p class="card-text">Acceder al otro servicio (usa la cédula).</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="py-4 mt-auto">
        <div class="container text-center">
            <p>© 2025 RE·EVO 2030. Todos los derechos reservados.</p>
            <small class="d-block text-muted mt-3">Desarrollado por Departamento de Sistemas - Arpesod Asociados SAS</small>
        </div>
    </footer>

</body>
</html>