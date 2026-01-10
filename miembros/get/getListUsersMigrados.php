<?php
include '../includes/config.php';
$response = $a->queryStrapi("bilingual-users?fromwix=true&updatedAt_gte=2024-04-01T00:00:00Z");
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Usuarios migrados</title>
        <style>
            *{
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: sans-serif;
            }
            /* Estilo básico para tabla */
            table {
            width: 100%;
            border-collapse: collapse;
            }

            /* Estilo para celda de encabezado */
            th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
            text-transform:uppercase;
            font-weight: bold;
            text-align:center;
            }

            /* Estilo para celda de datos */
            td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
            }

            /* Cambio de color al pasar el ratón por encima de una fila */
            tr:hover {
            background-color: #f5f5f5;
            }
        </style>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo</th>
                    <th>Telefono</th>
                    <th>Estado</th>
                    <th>Daycare</th>
                    <th>created At</th>
                    <th>updated At</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Función para obtener solo el ID del servicio de una suscripción
                    $getId = function ($suscription) {
                        return $suscription['service'];
                    };
                for ($i=0; $i < count($response); $i++) { 
                    $user = $response[$i]; 
                    // Aplicar la función a cada suscripción
                    $serviceIds = array_map($getId, $user->suscriptions);
                    $createdAt = strtotime($user->createdAt);
                    $fecha_legible_createdAt = date('m/d/Y H:i:s', $createdAt);
                    $updatedAt = strtotime($user->updatedAt);
                    $fecha_legible_updatedAt = date('m/d/Y H:i:s', $updatedAt);
                    ?>
                    <tr>
                        <td><?=$user->id?></td>
                        <td><?=$user->name?></td>
                        <td><?=$user->lastname?></td>
                        <td><?=$user->email?></td>
                        <td><?=$user->phone?></td>
                        <td><?=$user->state?></td>
                        <td><?=$user->daycares[0]->name?></td>
                        <td><?=$user->suscriptions?></td>
                        <td><?=$fecha_legible_createdAt?></td>
                        <td><?=$fecha_legible_updatedAt?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        
    </body>
    </html>