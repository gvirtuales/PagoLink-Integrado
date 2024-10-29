<?php
// print_r($_POST);
include 'config/functions.php';
$environment = $_POST["environment"];
$merchantId = $_POST["merchantId"];
$user = $_POST["user"];
$password = $_POST["password"];
$amount = $_POST["amount"];
$externalId = $_POST["externalId"];
$fecha = $_POST["fecha"];
$descripcion = $_POST["descripcion"];
$lastname = $_POST["lastname"];
$tipodepagolink = $_POST['tipodepagolink']; 
$name = $_POST['name']; 
$email= $_POST['email'];
$documentType = $_POST['documentType'];
$phone = $_POST['phone']; 
$documentNumber = $_POST['documentNumber']; 
$factura = $_POST['factura']; 
$direccion = $_POST['direccion'];
$numbatch = $_POST['numbatch']; 

$tokenResponse = generateToken($environment, $user, $password);
$sesionResponse = generateSesion($environment, $amount, $tokenResponse['response'], $merchantId , $tipodepagolink ,
 $externalId, $fecha, $descripcion,$lastname, $name , $email ,$documentType , $phone,$documentNumber,$factura,$direccion,$numbatch);

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="shortcut icon" href="assets/img/favicon.png">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <title>Pago Link Integrado</title>
</head>

<body>
  <div class="p-3 mb-2 bg-primary text-white">
        <h1><center><b>PAGO LINK INTEGRADO</b></center></h1>
  </div>
  <br>

  <div class="container-fluid">
    <div class="row">

      <div class="col-md-12">

        <div class="form-group">
          <div class="row align-items-center">
            <div class="col-2 col-md-1">
              <label  class="label-white"><b>API SEGURIDAD:</b></label>
            </div>
            <div class="col-9 col-md-11">
              <input type="text"  name="" id="" class="form-control transparent-input" value="<?php echo $tokenResponse['url'] ?>" disabled>
            </div>
          </div>
        </div>
        <div class="form-group mt-2">
          <b> <label  class="label-white">RESPONSE</label></b>
          <textarea name="" id="" cols="30" rows="2" class="form-control transparent-textarea" disabled><?php echo $tokenResponse['response']; ?></textarea>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-12">

    <div class="form-group">
      <div class="row align-items-center">
        <div class="col-2 col-md-1">
          <label  class="label-white"><b>API Pago Link: <?php echo $tipodepagolink?></b></label>
        </div>
        <div class="col-9 col-md-11">
          <input type="text" name="" id="" class="form-control transparent-input" value="<?php echo $sesionResponse['url'] ?>" disabled>
        </div>

        <div class="col-md-6">
          <div class="form-group mt-2">
            <b> <label class="label-white">REQUEST</label></b>
            <textarea name="" id="" cols="30" rows="10" class="form-control transparent-textarea" disabled><?php echo json_encode(json_decode($sesionResponse['request']), JSON_PRETTY_PRINT); ?></textarea>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group mt-2">
            <b> <label class="label-white">RESPONSE</label></b>
            <textarea name="" id="" cols="30" rows="10" class="form-control transparent-textarea" disabled><?php echo json_encode($sesionResponse['response'], JSON_PRETTY_PRINT); ?></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
 
<?php
// Suponiendo que $sesionResponse['response'] contiene los datos que mencionaste

// Verificar si $sesionResponse['response'] es un array y no está vacío
if (is_array($sesionResponse['response']) && !empty($sesionResponse['response'])) {
    // Iterar sobre cada elemento en el array
    foreach ($sesionResponse['response'] as $item) {
        // Verificar si el elemento es un objeto stdClass
        if (is_object($item)) {
            // Verificar si existe el campo "link" en el objeto actual
            if (isset($item->link)) {
                // Imprimir el valor de "link"
                echo '<div class="col-md-6">';
                echo '<div class="form-group mt-2">';
                echo '<b> <label class="label-white">RESPONSE</label></b>';
                echo '<div><a href="' . $item->link . '" target="_blank">' . $item->link . '</a></div>';
                echo '</div>';
                echo '</div>';
            } else {
                // Si no se pudo obtener el enlace del objeto, imprimir un mensaje de error
                echo '<div class="col-md-6">';
                echo '<div class="form-group mt-2">';
                echo '<b> <label class="label-white">RESPONSE</label></b>';
                echo '<div>No se pudo obtener el enlace del objeto.</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            // Si el elemento no es un objeto stdClass, imprimir un mensaje de error
            echo '<div class="col-md-6">';
            echo '<div class="form-group mt-2">';
            echo '<b> <label class="label-white">RESPONSE</label></b>';
            echo '<div>No se pudo procesar el elemento. Se esperaba un objeto stdClass.</div>';
            echo '</div>';
            echo '</div>';
        }
    }
} elseif (is_object($sesionResponse['response'])) { // Verificar si $sesionResponse['response'] es un objeto stdClass
    // Verificar si existe el campo "link" en el objeto stdClass
    if (isset($sesionResponse['response']->link)) {
        // Imprimir el valor de "link"
        echo '<div class="col-md-6">';
        echo '<div class="form-group mt-2">';
        echo '<b> <label class="label-white">RESPONSE</label></b>';
        echo '<div><a href="' . $sesionResponse['response']->link . '" target="_blank">' . $sesionResponse['response']->link . '</a></div>';
        echo '</div>';
        echo '</div>';
    } else {
        // Si no se pudo obtener el enlace del objeto, imprimir un mensaje de error
        echo '<div class="col-md-6">';
        echo '<div class="form-group mt-2">';
        echo '<b> <label class="label-white">RESPONSE</label></b>';
        echo '<div>No se pudo obtener el enlace del objeto.</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    // Si $sesionResponse['response'] no es ni un array ni un objeto stdClass, imprimir un mensaje de error
    echo '<div class="col-md-6">';
    echo '<div class="form-group mt-2">';
    echo '<b> <label class="label-white">RESPONSE</label></b>';
    echo '<div>No se pudo procesar la respuesta. Se esperaba un array o un objeto stdClass.</div>';
    echo '</div>';
    echo '</div>';
}
?>

    <br>
    <footer><center>NIUBIZ - NECOM</center></footer>
  </body>
</html>