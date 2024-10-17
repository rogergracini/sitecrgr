<?php
// Recebe o payload do GitHub
$payload = file_get_contents('php://input');
$json = json_decode($payload);

// Executa o comando git pull no diretório do seu site
if ($json->ref === 'refs/heads/main') {
    shell_exec('cd /domains/crgr.com.br/public_html && git pull origin main');
}
?>
