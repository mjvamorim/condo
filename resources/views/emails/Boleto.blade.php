<html>
    <body>
        <p>Prezado(a) Sr(a). {{ ucwords(mb_strtolower($nome)) }} !</p>
        <p></p>

        @switch($tipo)
            @case('Mensalidade')
                <p>Segue em anexo o Boleto referente à Taxa Condominial {{ $anomes }}
                @break
            @case('Acordo')
                <p>Segue em anexo o Boleto referente a uma prestação do Acordo Nº {{ $acordo_id }}
                @break
            @case('Multa')
                <p>Segue em anexo o Boleto referente a Multa Nº {{ $id }}
                @break
            @default
                <p>Segue em anexo o Boleto Avulso  {{ $id }}
                @break
        @endswitch
        com o valor de R$ {{ money_format('%(#10n',$valor) }} e vencimento em {{ date('d/m/Y',strtotime($dtvencto)) }}. </p>
        <p>Por favor <u> não responda a este email </u>. Certifique o endereço correto para recebimento com a administração do seu condomínio.</p>

        <p></p>
        <p>Atenciosamente </p>
        </br>{{ $rnome}}
        </br>Email: {{ $remail}}

    </body>
</html>
