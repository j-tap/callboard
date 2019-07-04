<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>


<p></p>
<table border="1" cellpadding="0" cellspacing="0" width="100%" style="line-height:1; border-collapse: collapse; line-height: 1;">
    <tbody>

    <tr>
        <td colspan="19" height="32" rowspan="2"
            style="font-size: 8pt; width:384px; border-bottom: none; vertical-align: top;">СЕВЕРО-ЗАПАДНЫЙ БАНК ПАО СБЕРБАНК г. Санкт-Петербург</td>
        <td style="font-size: 8pt;" colspan="4">БИК</td>
        <td colspan="23" style="border-bottom: none; font-size: 8pt;">044030653</td>
    </tr>
    <tr>
        <td style="font-size: 8pt; vertical-align: top;" colspan="4" height="30" rowspan="2">Сч. №</td>
        <td style="border-top: none; vertical-align: top;  font-size: 8pt;" colspan="23" rowspan="2">
            301018105000000000653
        </td>
    </tr>
    <tr>
        <td style="border-top: none; font-size: 8pt" colspan="19" height="15">Банк получателя</td>
    </tr>

    <tr>
        <td colspan="2" height="18" style="border-right: none; font-size: 8pt;">ИНН</td>
        <td style="border-left: none; font-size: 8pt;" colspan="8">7842166070</td>
        <td colspan="2" style="border-right: none; font-size: 9pt;">КПП&nbsp;&nbsp;</td>
        <td style="border-left: none; font-size: 8pt;" colspan="7">784201001</td>
        <td colspan="4" rowspan="4" style="vertical-align: top; font-size: 8pt;">Сч. №</td>
        <td colspan="23" rowspan="4" style="vertical-align: top; font-size: 8pt;">40702810055000038197</td>
    </tr>
    <tr>
        <td colspan="19" rowspan="2"
            style="vertical-align: top; border-bottom: none; height:30px;width:384px; font-size: 9pt">ООО Акстек</td>
    </tr>
    <tr>
    </tr>
    <tr>
        <td colspan="19" style="font-size: 9pt; border-top: none;">Получатель</td>
    </tr>






    </tbody>
</table>
<p></p>
<p></p>
<table style="line-height:1; padding: 10px 0; border-bottom: 3px solid #000" width="100%">
    <tr style="padding: 10px 0;">
        <td style="font-size: 13pt;">
            <b>Счет на оплату № {{$unique_id}} / {{$numberScore}} от {{$dt_str}} г.</b>
        </td>
    </tr>
</table>

<p></p>
<p></p>
<table style="line-height:1;" width="100%">
    <tr>
        <td style="font-size: 8pt; vertical-align: middle;">
            Поставщик
        </td>
        <td style="font-size: 8pt; font-weight: bold;">
            ООО "Акстек" ИНН 7842166070, КПП 784201001, 191124 Санкт-Петербург г,
        </td>
    </tr>
    <tr>
        <td style="font-size: 8pt; vertical-align: middle;">
            (Исполнитель
        </td>
        <td style="font-size: 8pt; font-weight: bold;">
            внутригородская территория муниципальный округ Смольнинское, Новгородская ул, дом № 19, литер  А, помещение 10
        </td>
    </tr>
    <tr>
        <td style="font-size: 8pt; vertical-align: middle;">
            Покупатель
        </td>
        <td style="font-size: 8pt; font-weight: bold;">
          {{$user->organization->org_name}}, ИНН {{$user->organization->org_inn}}, КПП {{$user->organization->org_kpp}}
        </td>
    </tr>
    <tr>
        <td style="font-size: 8pt; vertical-align: middle;">
          (Заказчик):
        </td>
        <td style="font-size: 8pt;">

        </td>
    </tr>
</table>
<p></p>
<p></p>
<table style="line-height:1;" width="100%">
    <tr>
        <td style="font-size: 8pt; vertical-align: middle;">
          Основание:
        </td>
        <td style="font-size: 8pt;">

        </td>
    </tr>
</table>
<p></p>
<p></p>
<table  class="demotable" style="line-height:1; border-collapse: collapse" cellpadding="0" cellspacing="0" width="100%">
    <tbody style="border: 2px solid;">
    <tr>
        <td align="center" colspan="2" style=" border: 1px solid; font-size: 8pt; font-weight: 700;">№</td>
        <td style=" border: 1px solid; font-size: 8pt; font-weight: 700;" align="center" colspan="17">Товар</td>
        <td style=" border: 1px solid; font-size: 8pt; font-weight: 700;" align="center" colspan="3">Кол-во</td>
        <td style=" border: 1px solid; font-size: 8pt; font-weight: 700;" align="center" colspan="3">Ед.</td>
        <td style=" border: 1px solid; font-size: 8pt; font-weight: 700;" align="center" colspan="4">Цена</td>
        <td style=" border: 1px solid; font-size: 8pt; font-weight: 700;" align="center" colspan="5">Сумма</td>
    </tr>

        <tr>
            <td style=" border: 1px solid; font-size: 7pt;" align="center" colspan="2">1</td>
            <td style=" border: 1px solid; font-size: 7pt;" align="left" colspan="17">Предоставление доступа к сервису объявлений закупок и продаж для юридических лиц TamTem</td>
            <td style=" border: 1px solid; font-size: 7pt;" align="center" colspan="3">1</td>
            <td align="center" style=" border: 1px solid; font-size: 7pt;" colspan="3">шт.</td>
            <td style=" border: 1px solid; font-size: 7pt;" align="center" colspan="4">{{$summ}}</td>
            <td style=" border: 1px solid; font-size: 7pt;" align="center" colspan="5">{{$summ}}</td>
        </tr>
    </tbody>
    <tr>
        <td style="border: none;" colspan="22">

        </td>
        <td align="right" style="border:none; font-size: 7pt; font-weight: 700;" colspan="7">Итого:</td>
        <td align="right" style="border:none; font-size: 7pt; font-weight: 700;" colspan="5">{{$summ}}</td>

    </tr>
    <tr>
        <td style="border: none;" colspan="22">

        </td>
        <td align="right" style="border:none; font-size: 7pt; font-weight: 700;" colspan="7">Без налога (НДС)</td>
        <td align="right" style="border:none; font-size: 7pt; font-weight: 700;" colspan="5">-</td>

    </tr>
    <tr>
        <td style="border: none;" colspan="22">

        </td>
        <td align="right" style="border:none; font-size: 7pt; font-weight: 700;" colspan="7">Всего к оплате:</td>
        <td align="right" style="border:none; font-size: 7pt; font-weight: 700;" colspan="5">{{$summ}}</td>

    </tr>
    {{--<tr>--}}
    {{--<td style="border: none;" colspan="25">--}}
    {{--</td>--}}
    {{--<td align="right" style="border: none; font-size: 7pt; font-weight: 700;" colspan="7">В том числе НДС:</td>--}}
    {{--<td align="right" style="border: none; font-size: 7pt; font-weight: 700;" colspan="5"></td>--}}
    {{--<td colspan="14"></td>--}}
    {{--</tr>--}}
</table>

<table width="100%">
    <tr>
        <td style="font-size: 8pt;">
            Всего наименований 1, на сумму {{$summ}} руб.
        </td>
    </tr>
    <tr>
        <td id="str_price" style="font-size: 8pt;">
            <b>{{$str_summ}}</b>
        </td>
    </tr>
</table>

<p></p>
<ul>
    <li>Срок оплаты настоящего Счета составляет 3 (три) банковских дня.</li>
    <li>Оплата данного счета означает согласие с условиями поставки товара</li>
</ul>
<p></p>
<p></p>

<table style="margin-top: 30px;">
    <tr style="position: relative;">
        <td style="font-size: 9pt;" colspan="3">
            <b>Руководитель</b>
        </td>
        <td style="font-size: 9pt; position: relative;"  style="vertical-align: bottom; "  colspan="6">
            _________________________________

            <img width="150" src="images/sign.png" style="position: absolute; left: 70px; position: absolute; top: -30px;" alt="">
            <img width="200" src="images/print.png" style="position: absolute; z-index: 2; left: 40px; position: absolute; top: -50px;" alt="">
        </td>
        <td style="font-size: 9pt;" colspan="5">
            / Ковалев А. /
        </td>

        <td style="font-size: 9pt;" colspan="3">
            <b>Бухгалтер</b>
        </td>
        <td style=" position: relative; font-size: 9pt;" style="vertical-align: bottom;" colspan="6">
            ______________________________

            <img width="150" src="images/sign_buh.png" style="position: absolute; left: 50px; position: absolute; top: -30px;" alt="">
        </td>
        <td style="font-size: 9pt;" colspan="5">

        </td>
    </tr>
</table>

<style>
    .demotable {
        counter-reset: schetchik;
    }
    ul {
        margin: 0;
        padding: 0;
    }

    li {
        padding: 0;
        list-style: none;
        font-size: 5pt;
    }

    tr {
        padding: 0;
    }

    td {

    }
</style>
</html>