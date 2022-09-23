<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <style>
        @page {
            margin: 0cm 0cm;
        }
        @font-face {
            font-family: 'Helvetica';
            font-weight: normal;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 1cm;
            margin-left: 1cm;
            margin-right: 1cm;
            /* margin-bottom: 5.1cm; */
            font-family: Helvetica, sans-serif;
            font-size: 11px;
        }

        .tbl-list {
            border-top: 1px solid black;
            border-bottom: 0;
            border-left: 1px solid black;
            border-right: 0;
            border-spacing: 0px;
            border-collapse: separate;
            margin-top: 10px;
        }

        .tbl-list td, .tbl-list th {
            border-bottom: 1px solid black;
            border-right: 1px solid black;
            border-top: 0;
            border-left: 0;
        }
        .tbl-list tr td:last-child {
            border-right: 1px solid black;
        }

        .tbl-list tr td:first-child {
            border-left: 0;
        }

        .tbl-list tr:first-child {
            border-top: 0;
        }
        .tbl-header { background-color: #fff; color: black; }
        .heading-detail{
            text-align: left;
            font-size: 14px;
        }
        .top-section p{
            margin: 0px;
            padding: 0px;
            font-size: 11px;
            padding-left: 11%;
        }
    </style>

    <body>
        <table style="width: 100%">
            <tr class="top-section">
                <td><img height="30" src="{{ asset('assets/images/logo/Azura_sma_logo.png') }}" /></td>
                <td style="text-align: center;font-weight: 500;font-size: 29px;width: 60%;">Top Sell</td>
            </tr>
            <tr class="heading-detail">
                <td style="width: 20%;"></td>
                <td>

                </td>
                <td style="width:;"></td>
            </tr>
        </table>

        <table width="100%" style="margin-top: 5%" cellpadding="5" cellspacing="0">

            <tr>
            </tr>
        </table>

        <main>
            <table width="100%" class="tbl-list" style="margin-bottom: 30px;" cellpadding="3" cellspacing="0">
                <thead>
                    <tr>
                        <th class="tbl-header">S.L</th>
                        <th class="tbl-header">Product Name</th>
                        <th class="tbl-header" align="center">Qty</th>
                        <th class="tbl-header" align="center">Sell Amount</th>
                        <th class="tbl-header" align="center">Avg Sell Price</th>
                        <th class="tbl-header" align="center">Order Id</th>
                    </tr>
                </thead>
                @foreach ($topSell as $item)
                <tr>
                    <td width="9%" align="center">{{ $loop->index+1 }}</td>
                    <td>{{ $item->VARIANT_NAME }}</td>
                    <td width="7%" align="center">{{ $item->QTY }}</td>
                    <td width="11%" align="center">{{ $item->SELL_AMOUNT }}</td>
                    <td width="11%" align="center">{{ $item->ORDER_ID }}</td>
                    <td width="9%" align="center">{{ $item->ORDER_ID }}</td>
                </tr>
                @endforeach
            </table>
        </main>

    </body>
</head>
</html>
