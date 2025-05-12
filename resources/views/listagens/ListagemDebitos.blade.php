<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Débitos</title>
</head>
<style>
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    th {
        background-color: #f2f2f2;
        padding: 1px;
        font-size: 13px;
    }

    td {
        padding: 1px;
        font-size: 12px;
    }

    td.separador {
        padding: 1px;
        background-color: #000000;
    }

</style>
<?php
function valoratual($debito)
{
    $valor_atualizado = 0;
    $hoje = new DateTime();
    $vencto = new DateTime($debito->dtvencto);
    $dias_atraso = $hoje->diff($vencto)->format('%r%a') < 0 ? $hoje->diff($vencto)->format('%a') : 0;
    if (is_null($debito->dtpagto)) {
        $valor_atualizado = $debito->valor;
        if ($dias_atraso > 0) {
            $multa = $debito->valor * 0.02;
            $juros = $debito->valor * $dias_atraso * 0.00033333333;
            $valor_atualizado = $debito->valor + $multa + $juros;
        }
    }
    return $valor_atualizado;
}

function imprime_totais($tot_valor, $tot_valpg, $tot_valat, $titulo)
{
    echo '<tr>';
    echo '<th colspan=5 align="right" >' . $titulo . ' </th>';
    echo '<th align="right">' . money_format('%i', $tot_valor) . '</th>';
    echo '<th > </th>';
    echo '<th align="right">' . money_format('%i', $tot_valpg) . '</th>';
    echo '<th align="right"> </th>';
    echo '<th align="right">' . money_format('%i', $tot_valat) . '</th>';
    echo '</tr>';

    echo '<tr>';
    echo '<td colspan=10 class="separador" > </td>';
    echo '</tr>';
}
?>

<body>
    <table width=100% style="border: 0px solid black;">
        <tr>
            <td>
                <h1>Listagem de Débitos</h1>
            </td>
            <td><img src="http://econdominio.net/site/img/pegasus.jpg" width=200px height=70px></td>
            <td> Data: {{ date('d/m/Y') }}</td>

        </tr>
    </table>


    <table class='bordered' width=100% bordered=true>
        <thead>
            <tr>
                <th width="25%" align="left">Proprietario </th>
                <th width="15%" align="left">Unidade </th>
                <th align="left">Tipo </th>
                <th>Id </th>
                <th>Dt.Vencto </th>
                <th>Valor </th>
                <th>Dt.Pagto </th>
                <th>Val.Pago </th>
                <th>Acordo </th>
                <th>Val.Atual </th>
            </tr>
        </thead>
        <tbody>

            <?php
            $tot_valor = 0;
            $tot_valpg = 0;
            $tot_valat = 0;
            $total_valor = 0;
            $total_valpg = 0;
            $total_valat = 0;
            ?>
            @foreach ($debitos as $key => $debito)
                <tr>
                    <?php
                    if ($key == 0) {
                        $unidade = $debito->unidade_id;
                        $dtpago = $debito->dtpagto;
                        $dtvencto = $debito->dtvencto;
                    } else {
                        $quebra = false;
                        if ($ordem == 'Pagto' and $dtpago != $debito->dtpagto) {
                            $quebra = true;
                        }
                        if ($ordem == 'Vencto' and $dtvencto != $debito->dtvencto) {
                            $quebra = true;
                        }

                        if (($ordem == 'Proprietario' or $ordem == 'Unidade') and $unidade != $debito->unidade_id) {
                            $quebra = true;
                        }
                        if ($quebra) {
                            imprime_totais($tot_valor, $tot_valpg, $tot_valat, 'Subtotal:');
                            $unidade = $debito->unidade_id;
                            $dtpago = $debito->dtpagto;
                            $dtvencto = $debito->dtvencto;
                            $tot_valor = 0;
                            $tot_valpg = 0;
                            $tot_valat = 0;
                        }
                    }
                    $tot_valor += $debito->valor;
                    $tot_valpg += $debito->valorpago;
                    $tot_valat += valoratual($debito);
                    $total_valor += $debito->valor;
                    $total_valpg += $debito->valorpago;
                    $total_valat += valoratual($debito);

                    ?>
                    <td>{{ ucwords(mb_strtolower($debito->nome . '  & ' . $debito->conjuge_nome)) }} </td>
                    <td>{{ ucwords(mb_strtolower($debito->descricao)) }} </td>
                    <td>{{ $debito->tipo }} </td>
                    @switch($debito->tipo)
                        @case('Mensalidade')
                            <td align="center">{{ $debito->anomes }} </td>
                        @break

                        @case('Acordo')
                            <td align="center">{{ $debito->acordo_id }} </td>
                        @break

                        @default
                            <td align="center">{{ $debito->id }} </td>
                    @endswitch
                    <td align="center">{{ date('d/m/Y', strtotime($debito->dtvencto)) }} </td>
                    <td align="right">{{ money_format('%i', $debito->valor) }} </td>
                    @if ($debito->dtpagto)
                        <td align="center">{{ date('d/m/Y', strtotime($debito->dtpagto)) }} </td>
                        <td align="right">{{ money_format('%i', $debito->valorpago) }} </td>
                    @else
                        <td></td>
                        <td></td>
                    @endif
                    <td align="right">{{ $debito->acordo_quitacao_id }} </td>
                    <td align="right">{{ money_format('%i', valoratual($debito)) }} </td>

                </tr>
            @endforeach
            <?php
            //Imprime subtotal
            imprime_totais($tot_valor, $tot_valpg, $tot_valat, 'Subtotal:');

            //Imprime Total
            imprime_totais($total_valor, $total_valpg, $total_valat, 'TotalGeral:');

            ?>
        </tbody>
    </table>
</body>

</html>
