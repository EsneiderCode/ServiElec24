<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validar los campos
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo 'Por favor, complete todos los campos.';
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Correo electrónico no válido.';
        exit;
    }

    // Configuración del correo
    $to = "adm@servielec24.com"; // Cambia esto por el email donde quieres recibir los mensajes
    $email_subject = "Formulario de Contacto: $subject";
    $email_body = "Has recibido un nuevo mensaje.\n\n" .
                  "Nombre: $name\n" .
                  "Correo: $email\n\n" .
                  "Mensaje:\n$message\n";

    $headers = "From: $email\n";
    $headers .= "Reply-To: $email\n";

    // Enviar el correo
    if (mail($to, $email_subject, $email_body, $headers)) {
        echo 'El mensaje ha sido enviado. Gracias!';
    } else {
        echo 'Error al enviar el mensaje. Inténtalo de nuevo más tarde.';
    }
} else {
    echo 'Acceso no autorizado.';
}
?>
