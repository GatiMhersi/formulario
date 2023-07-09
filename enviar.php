<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $localidad = $_POST['localidad'];

  // Obtiene los detalles del archivo CV
  $cvFile = $_FILES['cv']['tmp_name'];
  $cvFileName = $_FILES['cv']['name'];

  // Dirección de correo a la que se enviará el correo electrónico
  $to = 'tucorreo@example.com';

  // Asunto del correo electrónico
  $subject = 'Nuevo CV recibido';

  // Mensaje del correo electrónico
  $message = "Nombre: $nombre\n";
  $message .= "Apellido: $apellido\n";
  $message .= "Localidad: $localidad\n";

  // Encabezados del correo electrónico
  $headers = "From: ghersinichmatias@outlook.com\r\n";
  $headers .= "Reply-To: $to\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: multipart/mixed; boundary=\"boundary\"\r\n\r\n";

  // Cuerpo del correo electrónico
  $body = "--boundary\r\n";
  $body .= "Content-Type: text/plain; charset=\"utf-8\"\r\n";
  $body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
  $body .= "$message\r\n\r\n";
  $body .= "--boundary\r\n";
  $body .= "Content-Type: application/octet-stream; name=\"$cvFileName\"\r\n";
  $body .= "Content-Transfer-Encoding: base64\r\n";
  $body .= "Content-Disposition: attachment; filename=\"$cvFileName\"\r\n\r\n";
  $body .= chunk_split(base64_encode(file_get_contents($cvFile))) . "\r\n";
  $body .= "--boundary--";

  // Envía el correo electrónico
  if (mail($to, $subject, $body, $headers)) {
    echo 'OK';
  } else {
    echo 'Error al enviar el correo electrónico.';
  }
}
?>
