<?php
include 'config/functions.php';
?>

<?php
// Sumar 2 días a la fecha actual
$fechaIncrementada = strtotime('+2 days');

// Generar una hora aleatoria (entre 0 y 23 horas, y minutos entre 0 y 59)
$horaAleatoria = rand(0, 23);
$minutoAleatorio = rand(0, 59);

// Formatear la nueva fecha con hora aleatoria en formato ISO 8601 (YYYY-MM-DDTHH:MM:SS±0000)
$fechaConHoraAleatoria = date("Y-m-d", $fechaIncrementada) . 
                         "T" . str_pad($horaAleatoria, 2, '0', STR_PAD_LEFT) . 
                         ":" . str_pad($minutoAleatorio, 2, '0', STR_PAD_LEFT) . 
                         ":00-0000";
?>
<?php
// Ruta del archivo que guarda el último ID generado
$archivoId = 'ultimo_id.txt';

// Verificar si el archivo existe, si no, inicializarlo con 0
if (!file_exists($archivoId)) {
    file_put_contents($archivoId, '0');
}

// Leer el último número desde el archivo y convertirlo a entero
$ultimoId = (int)file_get_contents($archivoId);

// Incrementar el número en 1
$nuevoId = $ultimoId + 1;

// Guardar el nuevo ID en el archivo
file_put_contents($archivoId, $nuevoId);

// Formatear el valor con tres dígitos (por ejemplo: 001, 002, etc.)
$valueSecuencial = 'PagoDemo' . str_pad($nuevoId, 3, '0', STR_PAD_LEFT);
?>

<!DOCTYPE html>
<html lang="en">
<title>Pago Link Integrado</title>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="assets/img/favicon.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div class="p-3 mb-2 bg-primary text-white">
        <h1><center><b>PAGO LINK INTEGRADO</b></center></h1>
    </div>
    <form action="<?php echo BASE_PROJECT_URL; ?>boton.php" method="POST">
        <div class="content">
            <div class="container mt-3">

                <div class="card">
                    <div class="card-header" style="text-align: center;">Configuración General de Pago Link Integrado</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="environment" class="bold-label">Entorno (*)</label>
                                    <select name="environment" id="environment" class="form-control transparent-select"
                                        required class="bold-label">
                                        <option value="T" selected>Test</option>
                                        <option value="P">Producción</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="merchantId" class="bold-label">Código Comercio (*)</label>
                                    <input type="text" name="merchantId" id="merchantId"
                                        class="form-control transparent-input" required value="341198214">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="user" class="bold-label">Usuario (*)</label>
                                    <input type="text" name="user" id="user" class="form-control transparent-input"
                                        required value="integraciones.visanet@necomplus.com">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="password" class="bold-label">Contraseña (*)</label>
                                    <input type="text" name="password" id="password"
                                        class="form-control transparent-input" required value="d5e7nk$M">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tipodepagolink" class="bold-label">Tipo de Pago Link(*)</label>
                                    <select name="tipodepagolink" id="tipodepagolink"
                                        class="form-control transparent-select" required>
                                        <option value="UNICA">Orden Única</option>
                                        <option value="BATCH">Lote</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="numbatch" class="bold-label transparent-input">URL Batch Dinámico
                                        (*)</label>
                                    <input type="text" name="numbatch" id="numbatch" value="<?php echo uniqid(); ?>"
                                        class="form-control transparent-input" required value="prueba">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fecha" class="bold-label">Fecha (*)</label>
                                    <input type="text" name="fecha" id="fecha" class="form-control transparent-input"
                                        value="<?php echo $fechaConHoraAleatoria; ?>">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="descripcion" class="bold-label">Descripción (*)</label>
                                    <input type="text" name="descripcion" id="descripcion"
                                        class="form-control transparent-input" value="Pago de Factura">
                                </div>
                            </div>

                            <div class="container mt-3">
                                <div class="card">
                                    <div class="card-header" style="text-align: center;">Datos del Cliente</div>
                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="email" class="bold-label">Email</label>
                                                    <input type="text" name="email" id="email"
                                                        class="form-control transparent-input" value="integraciones_niubiz@gmail.com">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="phone" class="bold-label">Celular</label>
                                                    <input type="text" name="phone" id="phone"
                                                        class="form-control transparent-input" value="986322205">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="documentType" class="bold-label">Tipo de Documento(*)</label>
                                                    <select name="documentType" id="documentType"
                                                        class="form-control transparent-select" required>
                                                        <option value="NATIONAL_ID">DNI</option>
                                                        <option value="RESIDENT_ID">Carnet de Extranjería</option>
                                                        <option value="PASSPORT">Pasaporte</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="documentNumber" class="bold-label">Número de documento</label>
                                                    <input type="text" name="documentNumber" id="documentNumber"
                                                        class="form-control transparent-input" value="19096114">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="container mt-3">
                                <div class="card">
                                    <div class="card-header" style="text-align: center;">Datos personalizados 👨🏻‍💻
                                    </div>
                                    <div class="card-body">
                                    <div style="overflow-x:auto;">
    <table class="table">
        <thead>
            <tr>
                <th>ExternalId (*)</th>
                <th>Importe (*)</th>
                <th>Nombre (*)</th>
                <th>Apellido (*)</th>
                <th>NroFactura</th>
                <th>Dirección</th>
            </tr>
        </thead>
        <tbody id="customDataList">
            <!-- Aquí es donde se agregan las filas dinámicamente -->
            <tr class="custom-data-row">
                <td><input type="text" name="externalId[]" class="form-control transparent-input" placeholder="External Id" value ="<?php echo $valueSecuencial; ?>" required></td>
                <td><input type="text" name="amount[]" class="form-control transparent-input" placeholder="Importe" step=".01" value ="" required></td>
                <td><input type="text" name="name[]" class="form-control transparent-input" placeholder="Nombre" ></td>
                <td><input type="text" name="lastname[]" class="form-control transparent-input" placeholder="Apellido" ></td>
                <td><input type="text" name="factura[]" class="form-control transparent-input" placeholder="NroFactura"></td>
                <td><input type="text" name="direccion[]" class="form-control transparent-input" placeholder="Dirección"></td>
                <!-- Agrega más celdas de datos según tus necesidades -->
            </tr>
        </tbody>
    </table>
</div>
                                        <div class="text-center">
                                            <button type="button" class="btn btn-success" id="addCustomData">Agregar más</button>
                                                <button type="submit" class="btn btn-primary mr-2">Enviar >></button>
                                                <a href="https://drive.google.com/file/d/1BoH-auC_6UinweavjSlh0rSfmMmZyVvJ/view?usp=drive_link"
                                                class="btn btn-danger" target="_blank">Manual Pago Link Integrado</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        <footer><center>NIUBIZ - NECOM</center></footer>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('addCustomData').addEventListener('click', function() {
                var customDataList = document.getElementById('customDataList');
                var newRow = document.createElement('tr');
                newRow.classList.add('custom-data-row');
                newRow.innerHTML =
                    '<td><input type="text" name="externalId[]" class="form-control transparent-input" placeholder="externalId"></td>' +
                    '<td><input type="text" name="amount[]" class="form-control transparent-input" placeholder="Importe"></td>' +
                    '<td><input type="text" name="name[]" class="form-control transparent-input" placeholder="Nombre"></td>' +
                    '<td><input type="text" name="lastname[]" class="form-control transparent-input" placeholder="Apellido"></td>' +
                    '<td><input type="text" name="factura[]" class="form-control transparent-input" placeholder="NroFactura"></td>' +
                    '<td><input type="text" name="direccion[]" class="form-control transparent-input" placeholder="Dirección"></td>';
                customDataList.appendChild(newRow);
            });
        });
        </script>

    </body>
</html>