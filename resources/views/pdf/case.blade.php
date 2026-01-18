<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 14px;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
        }

        th {
            background: #f2f2f2;
        }
    </style>
</head>

<body>

    <h2>تقرير القضية</h2>

    <p><strong>رقم القضية:</strong> {{ $case->id }}</p>
    <p><strong>عنوان القضية:</strong> {{ $case->title }}</p>
    <p><strong>المحامي:</strong> {{ $case->lawyer->name ?? '-' }}</p>
    <p><strong>الحالة:</strong> {{ $case->status }}</p>
    <p><strong>تاريخ الإنشاء:</strong> {{ $case->created_at->format('Y-m-d') }}</p>

    <hr>

    <h3>الخطوات والإجراءات</h3>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>الوصف</th>
                <th>التاريخ</th>
                <th>تم بواسطة</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($case->steps as $index => $step)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $step->description }}</td>
                    <td>{{ $step->created_at->format('Y-m-d') }}</td>
                    <td>{{ $step->user->name ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
