<!DOCTYPE html>
<html>
<head>
    <title>CV DOWNLOAD</title>
<style type="text/css">
    body {
        width: 100% !important;
        font-size: 12px;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif !important;
    }

    * {
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif !important;
    }

    .container {
        width: 700px;
    }

    .outer_border {
        border: 1px solid #999999 !important;
        padding: 4% !important;
        margin-bottom: 2% !important;
    }

    .top_box {
        width: 47%;
        padding: 0%
    }

    .table_pad {
        padding: 0% 2%;
    }

    .border {
        border: 1px solid #CCCCCC !important;
    }

    .small_text {
        font-size: 10px !important;
    }

    .bg_color1 {
        background: #3a5082;
        color: #fff;
    }

    .text_color1 {
        color: #3a5082;
    }

    td {
        padding: 4px;
    }
</style>
</head>
<body>
    <div class="container">
        <div class="outer_border">
            <div class="row">
                <div class=" pull-left top_box   p-4">
                    <h2 class="text_color1" style="font-size:30px">jaipur</h2>
                    Phone : 9024437477
                    Email : surej@gmail.com
                    Website : cdg.com
                </div>
                <div style="" class=" pull-right top_box   p-4">
                    <h2 style="color:#101523;font-weight: bold;font-size:30px; text-align:right; padding-right: 30px;"
                        style="color:#687cbf;font-weight: bold;font-size:30px; text-align:right; padding-right: 30px;"
                        id="CV DOWNLOAD">CV DOWNLOAD</h2>
                    <table width="100%" height="70" border="0" class="table_pad">
                        <tr>
                            <td> Date</td>
                            <td> <?php 20-202-323;
                            ?> </td>
                        </tr>
                        <tr>
                            <td width="50%">CV DOWNLOAD #</td>
                            <td width="50%">{{ $candidate->id }}</td>
                        </tr>
                        <tr>
                            <td>Customer ID</td>
                            <td>{{ $candidate->id }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="">
                    <table width="100%" border="0">
                        <tr>
                            <td colspan="2">
                                <div class="bg_color1"
                                    style="text-indent:10px;font-size: 14px;width: 50%;height: 26px;line-height: 24px; ">
                                    BILL TO </div>
                                <table width="100%" border="0">
                                    <tr>
                                        <td width="18%">Name</td>
                                        <td width="82%"> {{ $candidate->first_name }} </td>
                                    </tr>
                                    <tr>
                                        <td>Phone</td>
                                        <td>{{ $candidate->first_name }}</td>
                                    </tr>
                                    <tr>
                                        <td> Address</td>
                                        <td> {{ $candidate->first_name }} ,
                                            {{ $candidate->first_name }},
                                            {{ $candidate->first_name }},
                                            {{ $candidate->first_name }}, </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"> </td>
                        </tr>
                    </table>
                </div>
            </div>
            <dd style="clear:both;"></dd>
            <div class="row">
                <table height="82" class=" " style=" width:100%;">
                    <tr class="bg_color1">
                        <td width="58%" height="12" style="padding-left: 10px;">DESCRIPTION</td>
                        <td width="13%"> </td>
                        <td style="padding-right: 10px;" width="15%" align="right">AMOUNT</td>
                    </tr>
                    <tr class=" ">
                        <td> </td>
                        <td> <strong>Total</strong> </td>
                        <td align="right">Rs. {{ $candidate->first_name }}</td>
                    </tr>
                </table>
            </div>
            <div class="row">
                <div style="text-align:center"> If you have any question about this CV DOWNLOAD, please contact <br />
                    {{ $candidate->first_name }}, {{ $candidate->first_name }}, {{ $candidate->first_name }}<br /> <b>Thank You For Your
                        Business!</b> </div>
            </div>
        </div>
    </div>
</body>
</html>