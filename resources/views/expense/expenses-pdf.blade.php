{{-- resources/views/reports/pdf.blade.php --}}
<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $title }}</title>
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            font-style: normal;
            font-weight: normal;
            src: url({{ storage_path('fonts/DejaVuSans.ttf') }}) format('truetype');
        }

        * {
            font-family: 'DejaVu Sans', sans-serif;
        }

        body {
            direction: rtl;
            text-align: right;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 10px;
        }

        .header h1 {
            color: #2c3e50;
            font-size: 24px;
            margin: 0;
        }

        .header .date {
            color: #7f8c8d;
            font-size: 14px;
            margin-top: 5px;
        }

        .company-info {
            margin-bottom: 20px;
            text-align: center;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #2980b9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
        }

        table th {
            background-color: #3498db;
            color: white;
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .total-row {
            background-color: #ecf0f1 !important;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #95a5a6;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .signature {
            margin-top: 40px;
            text-align: left;
        }

        .signature-line {
            width: 200px;
            border-top: 1px solid #333;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="company-info">
            <div class="company-name">اسم الشركة</div>
        </div>
        <h1>{{ $title }}</h1>
        <div class="date">تاريخ التصدير: {{ $date }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="25%">الاسم</th>
                <th width="20%">القسم</th>
                <th width="20%">القيمة</th>
                <th width="20%">التاريخ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $report)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $report->name }}</td>
                    <td>{{ $report->department }}</td>
                    <td>{{ number_format($report->value, 2) }}</td>
                    <td>{{ $report->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3" style="text-align: left;">الإجمالي</td>
                <td colspan="2" style="text-align: right;">{{ number_format($total, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        تم إنشاء هذا التقرير تلقائياً بتاريخ {{ $date }}
        <br>
        صفحة <span class="page"></span> من <span class="topage"></span>
    </div>

    <script type="text/php">
        if (isset($pdf)) {
            $text = "صفحة {PAGE_NUM} من {PAGE_COUNT}";
            $size = 10;
            $font = $fontMetrics->getFont("DejaVu Sans");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) / 2;
            $y = $pdf->get_height() - 35;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>
</body>

</html>
