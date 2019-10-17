<!DOCTYPE html>
<html>
<head>
    <title>Order Sheet</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            font-size: 10pt;
        }

        .f-bold {
            font-weight: 700;
        }

        .f-medium {
            font-weight: 600;
        }

        .no-margin {
            margin: 0;
        }

        .txt-center {
            text-align: center;
        }

        .line-dashes {
            border-bottom: 1px dashed #000;
            height: 20px;
        }

        .header {
            width: 100%;
        }

        .header img {
            width: 125px;
            position: fixed;
            display: inline;
        }

        .header h4 {
            display: flex;
        }

        table {
            table-layout: fixed;
        }

        table.bordered {
            margin-top: 15px !important;
            border-collapse: collapse;
        }

        table.bordered,
        table.bordered th,
        table.bordered td {
            border: 1px solid black;
            padding: 3px 3px;
            margin: 0.5;
            text-align: center;
        }

        table.signature {
            border-collapse: collapse;
            margin-top: 100px;
        }

        table.signature td.border {
            border: 1px solid black;
            padding: 1px 1px;
            margin: 1px 1px;
            text-align: center;
        }


        @page ordersheet {
            margin: 1cm 1cm;
        }

        .osPage {
            page: ordersheet;
            page-break-after: always;
        }

        .nobreak {
            page: ordersheet;
            page-break-after: avoid;
        }
    </style>
</head>

<body>
        <div class="header">
            <img src="data:image/png;base64,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" class="logo" alt="">
            <h1 class="no-margin txt-center">ORDER SHEET</h1>
        </div>
        <h4 class="no-margin">PT. ASKI INDONESIA</h4>
        <br><br>
        <div class="header-table">
            <table width="100%">
                <tr>
                    <td width="20%">Supplier Code</td>
                    <td width="2%">:</td>
                    <td width="20%"><?= $vendor->VendorCode ?></td>
                    <td width="16%"></td>
                    <td width="20%">Print Date</td>
                    <td width="2%">:</td>
                    <td width="20%"><?= $date ?> / <?= $time ?></td>
                </tr>
                <tr>
                    <td>Supplier Name</td>
                    <td>:</td>
                    <td><?= $vendor->VendorName ?></td>
                    <td width="5%"></td>
                    <td>Total Item(s)</td>
                    <td>:</td>
                    <td><?= count($ordersheet) ?></td>
                </tr>
                <tr>
                    <td>Delivery To</td>
                    <td>:</td>
                    <td>PT. ASKI PLANT 2 CIBITUNG</td>
                    <td width="5%"></td>
                    <td>Schedule Delivery Date</td>
                    <td>:</td>
                    <td><?= date('d-M-Y', strtotime($ordersheet[0]->os_delivery_date)) ?></td>
                </tr>
            </table>
        </div>
        <div class="data" style="margin-top: 50px">
            <table width="100%" class="bordered">
                <thead>
                    <tr>
                        <th width="4%">No</th>
                        <th width="5%">OS Number</th>
                        <!-- <th width="1">Supplier Code</th> -->
                        <th width="10%">PO Number</th>
                        <th width="15%">Material No.</th>
                        <th width="20%">Material Description</th>
                        <th width="5%">Qty</th>
                        <th width="5%">UoM</th>
                        <th width="5%">Kanban Qty</th>
                        <th width="5%">Total Qty</th>
                        <th width="10%">Delivery Date</th>
                        <th width="10%">Delivery Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach($ordersheet as $os) : ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $os->os_no ?></td>
                        <td><?= $os->os_po_number ?></td>
                        <td><?= $os->os_material ?></td>
                        <td><?= $os->os_material_desc ?></td>
                        <td><?= $os->os_schedule_qty ?></td>
                        <td><?= $os->os_bun ?></td>
                        <td><?= $os->os_kanban_qty ?></td>
                        <td><?= $os->os_sum_schedule_qty ?></td>
                        <td><?= $os->os_delivery_date ?></td>
                        <td><?= $os->os_transm ?></td>
                    </tr>
    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="signature">
            <table class="signature" width="100%">
                <tr>
                    <td width="60%"></td>
                    <td class="border" width="180">Printed By</td>
                    <td class="border" width="180">Created By</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="border" height="50"></td>
                    <td class="border" height="50"></td>
                </tr>
                <tr>
                    <td></td>
                    <!--- user vendor --->
                    <td class="border"><?= $company ?></td>
                    <!--- admin aski --->
                    <td class="border">PT ASKI PLANT 2 CIBITUNG</td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">Print Date : <?= $date . " " . $time?></td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>