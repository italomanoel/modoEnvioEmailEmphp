<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Teste de envio de e-mail</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>
    <div class="container">
        <div class="py-3 text-center">
            <h2>Envia e-mail</h2>
        </div>

        <div class="row">
            <div class="col-md-12">

                <div class="card-body font-weight-bold">
                    <form action="processo.php" method="POST">
                        <div class="form-group"> 
                            <label for="para">Para</label>
                            <input type="text" class="form-control" id="para" name="para" placeholder="para">
                        </div>
                        <div class="form-group"> 
                            <label for="assunto">assunto</label>
                            <input type="text" class="form-control" id="assunto" name="assunto" placeholder="assunto">
                        </div>
                        <div class="form-group"> 
                            <label for="mensagem">mensagem</label>
                            <input type="text" class="form-control" id="mensagem" name="mensagem" placeholder="mensagem">
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>