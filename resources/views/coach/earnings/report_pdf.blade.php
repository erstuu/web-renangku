<h2 style="text-align:center;">Laporan Pendapatan Bulanan</h2>
<p>Bulan: {{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}</p>
<table width="100%" border="1" cellspacing="0" cellpadding="4">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Sesi</th>
            <th>Harga</th>
        </tr>
    </thead>
    <tbody>
        @forelse($registrations as $reg)
        <tr>
            <td>{{ $reg->registered_at->format('d M Y') }}</td>
            <td>{{ $reg->trainingSession->session_name }}</td>
            <td>Rp {{ number_format($reg->trainingSession->price,0,',','.') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="3" align="center">Tidak ada data</td>
        </tr>
        @endforelse
    </tbody>
</table>
<p style="text-align:right;font-weight:bold;">Total: Rp {{ number_format($total,0,',','.') }}</p>