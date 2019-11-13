<?php
    header('Content-Type: text/html; charset=UTF-8');
    /* Baixe os arquivos do PHPMailer, utilizado aqui o que está na Branch (já está no repositório no diretório src): https://github.com/PHPMailer/PHPMailer/tree/6.0 */
    require "./src/Exception.php";
    require "./src/OAuth.php";
    require "./src/PHPMailer.php";
    require "./src/POP3.php";
    require "./src/SMTP.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    //print_r('ver dados que estão sendo enviados pelo post: '.$_POST);
    //o print_r($_POST); é para ver os dados se foram enviados ou não no array
    class Mensagem{
        //private $para = null;
        private $assunto = null;      
        private $nome = null;
        private $email = null;             
        private $telefone = null;
        private $dddtelefone = null;
        private $celular = null;     
        private $dddcelular = null;
        private $mensagem = null;       

        //public $status = array('codigo_status' => null, 'descricao_status' => '');

        public function __get($atributo) {
            return $this->$atributo;
        }
        public function __set($atributo, $valor) {
            return $this->$atributo = $valor;
        }
            public function mensagemValida(){
                if(empty($this->assunto) || empty($this->mensagem) || empty($this->email)){
                    return false;
                }
                return true;            
            }
           
    }

    $mensagem = new Mensagem();

    //$mensagem->__set('para', $_POST['para']);
    $mensagem->__set('assunto', $_POST['assunto']);
    $mensagem->__set('nome', $_POST['nome']);
    $mensagem->__set('email', $_POST['email']);
    $mensagem->__set('telefone', $_POST['telefone']);
    $mensagem->__set('dddtelefone', $_POST['dddtelefone']);
    $mensagem->__set('celular', $_POST['celular']);
    $mensagem->__set('dddcelular', $_POST['dddcelular']);
    $mensagem->__set('mensagem', $_POST['mensagem']);
    

    //print_r('conteúdo da mensagem 2: '.$mensagem);
    /*Caso a mensagem não seja válida ele irá voltar para a página inicial, checar regras de validade na função mensagemValida() que está acima */
    if(!$mensagem->mensagemValida()){
        // echo 'Mensagem não enviada';
         //o header('location') é usado para redirecionar a página, aqui caso não tenha alimentado com os dados necessários.
        header('Location: erro_page.html');
        die();       
    } 

    $mail = new PHPMailer(true);
    try {
        //Server settings
            //informa o debug na página com o 2 de valor, deixar false;
        $mail->SMTPDebug = false;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                 // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = '';         // SMTP username
        $mail->Password = '';         // SMTP password     

        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('', 'Interessado'); //e-mail do interessado
        $mail->addAddress('', 'Destinatário');     // Add a recipient 
        //$mail->addAddress($mensagem->__get('email'));         // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        /*$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name */

        //Content
        $mail->isHTML(true);   // Set email format to HTML        
        $mail->Subject = $mensagem->__get('assunto');
        //para aceitar acentos colocar: header('Content-Type: text/html; charset=UTF-8'); 
        $mail->CharSet = 'UTF-8';  //para aceitar acentuação nas mensagens.
        $mail->Body .= '<b>Cota</b>: '     .$mensagem->__get('assunto').      '<br>';    
        $mail->Body .= '<b>Nome</b>: '     .$mensagem->__get('nome').         '<br>';
        $mail->Body .= '<b>Email</b>: '    .$mensagem->__get('email').        '<br>';
        $mail->Body .= '<b>Telefone</b>: ' .$mensagem->__get('dddtelefone').'-'     ;
        $mail->Body .=                      $mensagem->__get('telefone').     '<br>';
        $mail->Body .= '<b>Celular</b>: '  .$mensagem->__get('dddcelular').'-'      ;
        $mail->Body .=                      $mensagem->__get('celular').      '<br>';
        $mail->Body .= '<b>Mensagem</b>: ' .$mensagem->__get('mensagem').     '<br>';
        //o altbody é para caso o cliente de email não suporte HTML, a maioria aceitam.
        $mail->AltBody = 'Necessário cliente  que suporte HTML.';

        $mail->send();
        //echo 'Mensagem foi enviada com sucesso';
        /* //implementar melhor mensagem ao usuário caso não dê erro aqui
        $mensagem->status['codigo_status'] = 1;
        $mensagem->status['codigo_status'] = 'Email enviado com sucesso';*/
    
    } catch (Exception $e) {
        echo 'Não foi possível enviar o e-mail.<br>Por favor tente novamente mais tarde ou entre em contato conosco';
        //print_r('o que está no mail até aqui: '.$mail);
        //echo 'Detalhes do erro: ' . $mail->ErrorInfo;

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
            <h2>Envio de E-mail Realizado com sucesso</h2>
            <a href="index.php" class="btn btn-success btn-lg mt-5">Voltar para página inicial</a>
        </div>        
    </div>
</body>
</html>
