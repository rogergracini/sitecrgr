<?php
// Importar as classes 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Carregar o autoloader do composer
require 'vendor/autoload.php';

// Instância da classe
$mail = new PHPMailer(true);

$nome = $_REQUEST['form_name'];
$email = $_REQUEST['form_email'];
$cnpj = $_REQUEST['form_cnpj'];
$fone = $_REQUEST['form_ddd'].' - '.$_REQUEST['form_phone'];
$empresa = $_REQUEST['form_empresa'];
$cep = $_REQUEST['form_cep'];
$estado = $_REQUEST['form_estado'];
$cidade = $_REQUEST['form_cidade'];
$bairro = $_REQUEST['form_bairro'];
$rua = $_REQUEST['form_rua'];
$numero = $_REQUEST['form_numero'];
$conheceu = $_REQUEST['form_conheceu'];
$vendedor = $_REQUEST['form_vendedor'];


try
{
    // Configurações do servidor
    $mail->isSMTP();        //Devine o uso de SMTP no envio
    $mail->SMTPAuth = true; //Habilita a autenticação SMTP
    $mail->Username   = 'contato@crgr.com.br';
    $mail->Password   = '#Ewdfh1k7';

    // Criptografia do envio SSL também é aceito
    $mail->SMTPSecure = 'tls';

    // Informações específicadas pelo Google
    $mail->Host = 'smtp.hostinger.com.br';
    $mail->Port = 587;

    // Define o remetente
    $mail->setFrom('contato@crgr.com.br', 'Contato');

    // Define o destinatário
    $mail->addAddress('contato@crgr.com.br', 'Veio do site');

    // Conteúdo da mensagem
    $mail->isHTML(true);  // Seta o formato do e-mail para aceitar conteúdo HTML
    $mail->Subject = 'Formulário do site';
    $mail->Body    = '
                nome: '.$nome.'<br>
                email: '.$email.'<br>
                cnpj: '.$cnpj.'<br>
                fone: '.$fone.'<br>
                empresa: '.$empresa.'<br>
                Cep: '.$cep.'<br>
                Rua: '.$rua.'<br>
                Número: '.$numero.'<br>
                Estado: '.$estado.'<br>
                Bairro: '.$bairro.'<br>
                Como nos Conheceu: '.$conheceu.'<br>
                Vendedor: '.$vendedor.'<br>

    ';
    $mail->AltBody = $mail->Body;

    // Enviar
    $mail->send();
    echo 'A mensagem foi enviada!';

    header("location: ok.php");
}
catch (Exception $e)
{
    header("location: alerta.php");
}