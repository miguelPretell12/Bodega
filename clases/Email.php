<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    public $nombre;
    public $email;
    public $token;

    public function __construct($email, $nombre, $token)
    {
    }

    public function recuperarPassword()
    {
        $email = new PHPMailer();
        $email->isSMTP();
        $email->Host = 'smtp.gmail.com';
        $email->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $email->SMTPAuth = true;
        $email->Port = 465;
        $email->Username = 'miguelpretell59@gmail.com';
        $email->Password = 'jxqkucreezaldjpi';

        $email->setFrom('');
        $email->addAddress($email);
        $email->Subject = ' Recupera tu contraseña ';

        // HTML
        $email->isHTML(true);
        $email->CharSet = 'UTF-8';
        $contenido = '
        <html>
            <head></head>
            <body>
                <p><strong>' . $this->nombre . '</strong> </p>
            </body>
        </html>
        ';

        $email->body = $contenido;
        $email->send();
    }
}
