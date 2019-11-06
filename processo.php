<?php
    /* Baixe os arquivos do PHPMailer, utilizado aqui o que está na Branch (já está no repositório no diretório src): https://github.com/PHPMailer/PHPMailer/tree/6.0 */
    require "./src/Exception.php";
    require "./src/OAuth.php";
    require "./src/PHPMailer.php";
    require "./src/POP3.php";
    require "./src/SMTP.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    //o print_r($_POST); é para ver os dados se foram enviados ou não no array
    class Mensagem{
        private $para = null;
        private $assunto = null;
        private $mensagem = null;
        //public $status = array('codigo_status' => null, 'descricao_status' => '');

        public function __get($atributo) {
            return $this->$atributo;
        }
        public function __set($atributo, $valor) {
            return $this->$atributo = $valor;
        }
        public function mensagemValida(){
            if(empty($this->para) || empty($this->assunto) || empty($this->mensagem)){
                return false;
            }
            return true;            
        }
    }

    $mensagem = new Mensagem();

    $mensagem->__set('para', $_POST['para']);
    $mensagem->__set('assunto', $_POST['assunto']);
    $mensagem->__set('mensagem', $_POST['mensagem']);

    /*print_r($mensagem);*/
    
    if(!$mensagem->mensagemValida()){
        echo 'Mensagem não enviada';
        /*die();*/
        //usado para redirecionar a página caso não tenha alimentado com os dados necessários.
        header('Location: index.php');
    } 

    $mail = new PHPMailer(true);
try {
    //Server settings
    //informa o debug na página com o 2 de value, deixar false;
    $mail->SMTPDebug = false;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'colocar_email_smtp';                 // SMTP username
    $mail->Password = 'senha';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('email_smtp', 'Remetente');
    $mail->addAddress('email_smtp', 'Destinatário');     // Add a recipient
    $mail->addAddress($mensagem->__get('para'));         // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    /*$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name */

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $mensagem->__get('assunto');
    $mail->Body    = $mensagem->__get('mensagem');
    //o altbody é para caso o cliente de email não suporte HTML, a maioria aceitam hoje.
    $mail->AltBody = 'Necessário cliente  que suporte HTML.';

    $mail->send();
    echo 'Mensagem foi enviada com sucesso';
    /* //implementar melhor mensagem ao usuário caso não dê erro aqui
    $mensagem->status['codigo_status'] = 1;
    $mensagem->status['codigo_status'] = 'Email enviado com sucesso';*/
    
    } catch (Exception $e) {
        echo 'Não foi possível enviar o e-mail. Por favor tente novamente mais tarde.';
        echo 'Detalhes do erro: ' . $mail->ErrorInfo;

        /* //implementar melhor mensagem ao usuário caso dê erro aqui
        $mensagem->status['codigo_status'] = 2;
        $mensagem->status['codigo_status'] = 'Não foi possível enviar o e-mail: '. $mail->ErrorInfo;*/        
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Processamento de envio de E-mail</title>    

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="py-3 text-center">
            <h2>Envio de E-mail Realizado</h2>
            <a href="index.php" class="btn btn-success btn-lg mt-5">Voltar para página inicial</a>
        </div>        
    </div>
</body>
</html>