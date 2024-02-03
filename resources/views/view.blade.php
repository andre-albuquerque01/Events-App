<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Email</title>
</head>
<body style="text-align: center; font-family: Arial, sans-serif;">

    <h2>Olá,</h2>
    <p>Recebemos uma solicitação para verificar o seu e-mail. Para garantir a segurança da sua conta, estamos enviando este e-mail de verificação.</p>
    <p>Por favor, clique no botão abaixo para confirmar a validade do seu endereço de e-mail:</p>
    
    <a href="http://localhost:3000/api/user/verifyEmail/{{$data['message']}}" style="display: inline-block; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Verificar E-mail</a>

    <p>Se você não solicitou esta verificação, pode ignorar este e-mail.</p>

    <p>Obrigado,<br>Equipe de Suporte</p>

</body>
</html>
