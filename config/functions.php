<?php
include 'config.inc.php';

function getBaseUrl($environment) {
  switch ($environment) {
    case 'T':
      return BASE_URL_TEST;
     
    case 'P':
      return BASE_URL_PROD;
    default:
  }
}

function generateToken($environment, $user, $password) {
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => getBaseUrl($environment).URL_SECURITY,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_HTTPHEADER => array(
      "Accept: */*",
      'Authorization: ' . 'Basic ' . base64_encode($user . ":" . $password)
    ),
  ));
  $response = curl_exec($curl);
  curl_close($curl);
  return array(
    "url" => getBaseUrl($environment).URL_SECURITY,
    "request" => "",
    "response" => $response
  );
}

function generateSesion($environment, $amount, $token, $merchantId, $tipodepagolink,
                        $externalId, $fecha, $descripcion, $lastname, $name, $email,
                        $documentType, $phone, $documentNumber, $factura, $direccion ,$numbatch) {
    // Obtiene la URL base según el entorno y la concatena con la ruta de la sesión
    $url = getBaseUrl($environment) . URL_PAGOLINK . $merchantId;

    $PAGOLINK = array(
        'externalId' => $externalId[0],
        'orderType' => 'SINGLEPAY',
        'description' => $descripcion,
        'expirationDate' => $fecha,
        'amount' => $amount[0],
        'customer' => array(
            'firstName' => $name[0],
            'lastName' => $lastname[0],
            'email' => $email,
            'phoneNumber' => $phone,
            'documentType' => $documentType,
            'documentNumber' => $documentNumber
        ),
        'customData' => array(
            'nroFactura' => $factura[0],
            'direccion' => $direccion[0],
        )
    );

    if ($tipodepagolink == 'BATCH') {
      $PAGOLINK = []; // Inicializa el array $PAGOLINK antes del bucle
      foreach ($factura as $index => $nroFactura) {
          $externalIdbatch = $externalId[$index];
          $amountdbatch = $amount[$index];
          $namebatch = $name[$index];
          $lastnamebatch = $lastname[$index];
          $direccionbatch = $direccion[$index];
          $transaction = [
              'externalId' => $externalIdbatch,
              'orderType' => 'SINGLEPAY',
              'description' => $descripcion,
              'expirationDate' => $fecha,
              'amount' => $amountdbatch,
              'customer' => [
                  'firstName' => $namebatch,
                  'lastName' => $lastnamebatch,
                  'email' => $email,
                  'phoneNumber' => $phone,
                  'documentType' => $documentType,
                  'documentNumber' => $documentNumber
              ],
              'customData' => [
                  'nroFactura' => $nroFactura,
                  'direccion' => $direccionbatch,
              ]
          ];
          $PAGOLINK[] = $transaction;
      }

    // Si es BATCH, ajusta la URL para BATCH
    $url = getBaseUrl($environment) . URL_PAGOLINK . $merchantId . '/batch/' . $numbatch;
}

    // Convierte el objeto de sesión a formato JSON
    $json = json_encode($PAGOLINK);

    // Envía la solicitud POST a la URL especificada con los datos JSON y el token
    $response = json_decode(postRequest($url, $json, $token));

    // Retorna un array con la URL de la solicitud, los datos enviados y la respuesta recibida
    return array(
        "url" => $url,
        "request" => $json,
        "response" => $response
    );
}

function postRequest($url, $postData, $token)
{
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_HTTPHEADER => array(
      'Authorization: ' . $token,
      'Content-Type: application/json'
    ),
    CURLOPT_POSTFIELDS => $postData
  ));
  $response = curl_exec($curl);
  curl_close($curl);
  return $response;
}