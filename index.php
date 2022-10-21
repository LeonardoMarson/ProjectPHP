<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar</title>
</head>
    <body>
        <script src="https://accounts.google.com/gsi/client" async defer></script>

        <div>
            <h1>Title</h1>
        </div>
        
        <form action="">
            <div>
                <label for="">Usuário</label>
                <input type="text">
            </div>
            <div>
                <label for="">Senha</label>
                <input type="password">
            </div>
            <div>
                <a href="">Esqueceu sua senha?</a>
                <button type="submit">Enviar</button>
            </div>   
        </form>

        <div>
            <p>Não tem uma conta?</p>
            <a href="">Inscrever-se no</a>
        </div>

        <div id="g_id_onload"
            data-client_id="164457916901-nlipobm2ts76l5v2cnjkk0lmg3sm562s.apps.googleusercontent.com"
            data-login_uri="http://localhost/php-project-apis/ProjectPHP/login.php"
            data-auto_prompt="false">
        </div>
        <div class="g_id_signin"
            data-type="standard"
            data-size="large"
            data-theme="filled_blue"
            data-text="continue_with"
            data-shape="circle"
            data-logo_alignment="center"
            data-width>
        </div>
    </body>
</html>