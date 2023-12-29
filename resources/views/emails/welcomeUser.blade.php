<!DOCTYPE html>

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Bem-vindo ao nosso site!</title>
</head>
<body>

    <h1>Olá, {{ $user->name }},</h1>

    <p>Bem-vindo ao nosso site!</p>

    <p>Você se inscreveu no plano <strong>{{ $description }}

    </strong>, que oferece um limite de <strong>{{ $limit > 0 ? $limit: 'ILIMITADO' }}

    </strong> alunos.</p>

    <p>Aproveite nossos serviços!</p>

    <p>Atenciosamente,</p>
</body>
</html>