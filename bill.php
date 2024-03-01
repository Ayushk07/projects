<?php

?>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
    * {
        border: 0;
        box-sizing: content-box;
        color: inherit;
        font-family: inherit;
        font-size: inherit;
        font-style: inherit;
        font-weight: inherit;
        line-height: inherit;
        list-style: none;
        margin: 0;
        padding: 0;
        text-decoration: none;
        vertical-align: top;
    }



    table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        color: #4a4a4d;
        font: 14px/1.4 "Helvetica Neue", Helvetica, Arial, sans-serif;

    }

    th,
    td {
        padding: 10px 15px;
        vertical-align: middle;
    }


    thead {
        background: #395870;
        background: linear-gradient(#49708f, #293f50);
        color: #fff;
        font-size: 11px;
        text-transform: uppercase;
    }

    th:first-child {
        border-top-left-radius: 5px;
        text-align: left;
    }

    th:last-child {
        border-top-right-radius: 5px;
    }

    tbody tr:nth-child(even) {
        background: #f0f0f2;
    }

    td {
        border-bottom: 1px solid #cecfd5;
        border-right: 1px solid #cecfd5;
    }

    td:first-child {
        font-size: 14px;
        ;
        border-left: 1px solid #cecfd5;
    }

    .book-title {
        color: #395870;
        display: block;
    }

    .text-offset {
        color: #7c7c80;
        font-size: 12px;
    }

    .item-stock,
    .item-qty {
        text-align: center;
    }

    .item-price {
        text-align: right;
    }

    .item-multiple {
        display: block;
    }

    tfoot {
        text-align: right;
    }

    tfoot tr:last-child {
        background: #f0f0f2;
        color: #395870;
        font-weight: bold;
    }

    tfoot tr:last-child td:first-child {
        border-bottom-left-radius: 5px;
    }

    tfoot tr:last-child td:last-child {
        border-bottom-right-radius: 5px;
    }

    html {
        font: 16px/1 'Open Sans', sans-serif;
        overflow: auto;
        padding: 0.5in;
    }

    html {
        background: #999;
        cursor: default;
    }

    body {
        box-sizing: border-box;
        height: 11in;
        margin: 0 auto;
        overflow: hidden;
        padding: 0.5in;
        width: 8.5in;
    }

    body {
        background: #FFF;
        border-radius: 1px;
        box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
    }
    </style>

</head>

<body>
    <div class="container" id="container">
        <article id="article">
            <div class="invoice" style="gap: 44%; display: flex;">
                <img src="pdf.png" alt="Company Logo">
                <h2 style="padding-top: 4%;font-size: 28px;">STATEMENT</h2>
            </div>

            <div class="head"
                style="color: darkslategrey;border-top: 3px solid grey;padding-top: 3%; font-family: system-ui;padding-bottom: 2%;border-bottom: 3px solid grey;margin-top: 5%;font-weight: 600;">
                <h3 style="font-size:16px;"> 2257 N. Loop 336 W. Ste 140129</b></h3>
                <h3 style="font-size:16px;">Conroe, TX 77304 </b></h3>
                <h3 style="font-size:16px;">(281) 660-3656 </b></h3>
                <h3 style="font-size:16px;">John@THRealty.net </b></h3>
                <h3 style="font-size:16px;">www.THRealty.net </b></h3>
            </div>


            <div class="doublehead"
                style="padding-bottom: 2%;border-bottom: 3px solid grey;margin-top: 5%;font-weight: 600;color: darkslategrey;font-family: system-ui;">
                <h2 style="float: right; font-size:16px;margin-top: 6%;"> <b
                        style="font-weight: bold;font-size:16px;">Date:</b> 12/18/23 </h2>
                <p style="font-size:16px;font-weight: bold;"> TO:</p>
                <br />
                <p style="font-size:16px;">James Baine</p>
                <p style="font-size:16px;">nancyjaramillo@sbcglobal.net</p>
                <p style="font-size:16px;">936-662-5600 </p>
            </div>
            <div class="triplehead" style="margin-top: 2%;">
                <table style="font-size: large;">
                    <tbody>
                        <tr>
                            <th style="font-weight: bold;background: linear-gradient(#49708f, #293f50);color: white;">
                                Property:</th>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="font-size: large;font-weight: bold;">Activity</th>
                            <th style="font-size: large;font-weight: bold;">Discription</th>
                            <th style="font-size: large;font-weight: bold;">Date</th>
                            <th style="font-size: large;font-weight: bold;">Amount</th>
                            <th style="font-size: large;font-weight: bold;">Total</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center;">

                        <tr>
                            <td class="col-md-9" style="font-size: large;">Paymen</td>
                            <td class="col-md-3" style="font-size: large;">Dec 2023 Rent</td>
                            <td class="col-md-3" style="font-size: large;">12/07/2023</td>
                            <td class="col-md-3" style="font-size: large;">$1,800.00</td>
                            <td class="col-md-3" style="font-size: large;">$1,800.00</td>
                        </tr>
                    </tbody>

                    <tfoot>
                        <tr class="text-offset">
                            <td colspan="4"
                                style="font-size: 14px;font-weight: bold; color:linear-gradient(#49708f, #293f50)">
                                INCOME</td>
                            <td style="font-size: large;text-align:center;">$1,800.00</td>
                        </tr>
                        <tr class="text-offset">
                            <td colspan="4" style="color:red;font-weight: bold;">TOTAL EXPENSES </td>
                            <td style="font-size: large;color:red;text-align:center;">$0.00</td>
                        </tr>
                        <tr class="text-offset">
                            <td colspan="4" style="font-weight: bold;color:linear-gradient(#49708f, #293f50)">TOTAL
                                INCOME</td>
                            <td style="font-size:larger; text-align:center;">$1,800.00</td>
                        </tr>
                    </tfoot>
                </table>

            </div>
            <div class="fourhead" style="margin-top: 7%;">
                <h2
                    style="color: white;height: 4%;padding-top:2%; background: linear-gradient(#49708f, #293f50);letter-spacing: 0px;text-align: center;">
                    Excellence in Property Management since 1971</h2>

                <button class="btn btn-success" id="downloadButton" onclick="downloadPdf()">Download PDF</button>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
                <script>
                function downloadPdf() {

                    var button = document.getElementById('downloadButton');
                    button.style.display = 'none';


                    var element = document.body;
                    html2pdf(element, {
                        filename: 'invoice.pdf',
                        image: {
                            type: 'jpeg',
                            quality: 0.98
                        },
                        html2canvas: {
                            scale: 2
                        },
                        jsPDF: {
                            unit: 'mm',
                            format: 'a4',
                            orientation: 'portrait'
                        },
                        onAfterSave: function() {
                            button.style.display = 'block';
                        },
                        margin: 0,
                    });

                }
                </script>

            </div>
        </article>
    </div>
</body>

</html>
