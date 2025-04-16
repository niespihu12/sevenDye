<div class="influencer-dashboard">
    <?php include_once __DIR__ . '/../templates/side-bar.php' ?>


<?php
$ventas_totales = 4235;
$clientes = 2571;

$pedidos_recientes = [
    [
        'articulo' => 'Mens Black T-Shirts',
        'fecha' => '20 Mar, 2023',
        'total' => 75.00,
        'estado' => 'procesando'
    ],
    [
        'articulo' => 'Essential Neutrals',
        'fecha' => '19 Mar, 2023',
        'total' => 22.00,
        'estado' => 'procesando'
    ],
    [
        'articulo' => 'Sleek and Cozy Black',
        'fecha' => '7 Feb, 2023',
        'total' => 57.00,
        'estado' => 'completada'
    ],
    [
        'articulo' => 'MOCKUP Black',
        'fecha' => '29 Jan, 2023',
        'total' => 30.00,
        'estado' => 'completada'
    ],
    [
        'articulo' => 'Monochromatic Wardrobe',
        'fecha' => '27 Jan, 2023',
        'total' => 27.00,
        'estado' => 'completada'
    ]
];
?>

<div class="contenido">
    <header class="header">
        <div class="header__texto">
            <h2>Dashboard</h2>
            <p>Admin</p>
        </div>
    </header>

    <div class="estadisticas">
        <div class="card">
            <div class="card__header">
                <h3>Ventas totales</h3>
                <p>ESTE MES</p>
            </div>
            <p class="card__cantidad">$<?php echo number_format($ventas_totales, 2); ?></p>
            <div class="card__grafica">
                <div class="card__grafica--barras">
                    <?php for($i = 0; $i < 30; $i++) { 
                        $height = rand(20, 100);
                    ?>
                        <div class="barra" style="height: <?php echo $height; ?>%"></div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card__header">
                <h3>Clientes</h3>
                <p>ESTE MES</p>
            </div>
            <p class="card__cantidad"><?php echo number_format($clientes); ?></p>
            <div class="card__grafica">
                <svg class="card__grafica--linea" viewBox="0 0 300 100" preserveAspectRatio="none">
                    <path d="M0,50 C50,30 100,70 150,50 C200,30 250,70 300,50" fill="none"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="pedidos">
        <div class="pedidos__header">
            <h2>Pedidos recientes</h2>
            <button class="btn-todos">Ver todos</button>
        </div>

        <div class="tabla-contenedor">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Artículo</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($pedidos_recientes as $pedido) { ?>
                        <tr>
                            <td><?php echo $pedido['articulo']; ?></td>
                            <td><?php echo $pedido['fecha']; ?></td>
                            <td>$<?php echo number_format($pedido['total'], 2); ?></td>
                            <td>
                                <span class="estado estado--<?php echo $pedido['estado']; ?>">
                                    <?php echo ucfirst($pedido['estado']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
