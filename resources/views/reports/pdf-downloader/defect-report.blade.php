<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Report PDF</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table td {
            border: 1px solid #e5e7eb; /* Tailwind gray-200 */
            padding: 8px 12px;
        }
        .header-cell {
            background-color: #f3f4f6; /* Tailwind gray-100 */
            font-weight: bold;
            width: 30%;
        }
    </style>
</head>
<body class="p-10">
    <h2 class="text-xl font-bold">{{$report_title}}</h2>

    @foreach ($data as $row)
        <table class="w-full border-collapse text-sm">
            @foreach ($headers as $index => $header)
                <tr>
                    <td class="px-4 py-3 font-medium text-left bg-gray-100 w-[30%]">{{ $header }}</td>
                    <td class="px-12 py-8 border border-gray-200">{{ $row[$index] ?? '' }}</td>
                </tr>
            @endforeach
        </table>
    @endforeach
</body>
</html>
