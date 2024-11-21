<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recoger y sanitizar los datos del formulario
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    // Validar los campos
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo 'Por favor, complete todos los campos.';
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Correo electrónico no válido.';
        exit;
    }

    // Prevenir cabeceras maliciosas en el email
    if (preg_match('/[\r\n]/', $name) || preg_match('/[\r\n]/', $email) || preg_match('/[\r\n]/', $subject)) {
        echo 'Entrada no válida detectada.';
        exit;
    }

    // Configuración del correo
    $to = "adm@servielec24.com"; // Cambia esto por el email donde quieres recibir los mensajes
    $email_subject = "Formulario de Contacto: " . htmlspecialchars($subject, ENT_QUOTES, 'UTF-8');
    $email_body = "Has recibido un nuevo mensaje.\n\n" .
                  "Nombre: " . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . "\n" .
                  "Correo: " . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "\n\n" .
                  "Mensaje:\n" . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . "\n";

    $headers = "From: noreply@yourdomain.com\n"; // Asegúrate de usar un correo válido en tu dominio
    $headers .= "Reply-To: " . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8";

    // Enviar el correo
    if (mail($to, $email_subject, $email_body, $headers)) {
        echo 'El mensaje ha sido enviado. ¡Gracias!';
    } else {
        echo 'Error al enviar el mensaje. Inténtalo de nuevo más tarde.';
    }
} else {
    echo 'Acceso no autorizado.';
}
?>
