<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendapatan Bulanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Laporan Pendapatan Bulanan</h1>
        <form method="GET" class="mb-6 flex gap-4 items-end">
            <div>
                <label>Bulan</label>
                <select name="month" class="border rounded px-2 py-1">
                    @for($m=1;$m<=12;$m++)
                        <option value="{{ $m }}" @if($m==$month) selected @endif>{{ DateTime::createFromFormat('!m', $m)->format('F') }}</option>
                        @endfor
                </select>
            </div>
            <div>
                <label>Tahun</label>
                <select name="year" class="border rounded px-2 py-1">
                    @for($y=date('Y')-2;$y<=date('Y');$y++)
                        <option value="{{ $y }}" @if($y==$year) selected @endif>{{ $y }}</option>
                        @endfor
                </select>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Tampilkan</button>
            <a href="{{ route('coach.earnings.report.print', ['month'=>$month,'year'=>$year]) }}" target="_blank" class="bg-green-600 text-white px-4 py-2 rounded">Cetak PDF</a>
        </form>
        <div class="bg-white rounded shadow p-4">
            <h2 class="text-lg font-semibold mb-2">Detail Pendapatan</h2>
            <table class="w-full table-auto mb-4">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-2 py-1">Tanggal</th>
                        <th class="px-2 py-1">Sesi</th>
                        <th class="px-2 py-1">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations as $reg)
                    <tr>
                        <td class="border px-2 py-1">{{ $reg->registered_at->format('d M Y') }}</td>
                        <td class="border px-2 py-1">{{ $reg->trainingSession->session_name }}</td>
                        <td class="border px-2 py-1">Rp {{ number_format($reg->trainingSession->price,0,',','.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-4">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="text-right font-bold">Total: Rp {{ number_format($total,0,',','.') }}</div>
        </div>
    </div>
</body>

</html>