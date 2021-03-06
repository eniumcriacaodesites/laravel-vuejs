<h3>{{ config('app.name') }}</h3>
<p>Olá {{ $user->name }}!</p>
<p>Parabéns, sua assinatura na plataforma já está ativa.</p>
<p>
    Data de expiração:
    <strong>{{ (new \Carbon\Carbon($subscription->expires_at))->format('d/m/Y') }}</strong>
</p>
<p>
    Clique <a href="{{ url('/') . "/app/#!/login" }}" target="_blank">aqui</a> para acessar a plataforma financeira.<br>
    Informe suas credenciais cadastradas quando o usuário foi registrado para entrar na plataforma.
</p>
<p>
    Quanto chegar na data de expiração, sua assinatura será renovada automaticamente, caso pagamento tenha sido feito
    com cartão de crédito.
</p>
<p>Obs.: Não responda este e-mail, ele é gerado automatimente.</p>
