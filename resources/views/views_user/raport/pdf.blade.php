<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raport Belajar - {{ auth()->user() ? auth()->user()->name : 'User' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #667eea;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #667eea;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .stats {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .stat-item {
            display: table-cell;
            text-align: center;
            padding: 15px;
            border: 1px solid #ddd;
            background: #f8f9fa;
        }
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
        }
        .stat-label {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h2 {
            color: #667eea;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            font-size: 18px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #f8f9fa;
            font-weight: bold;
        }
        .achievement {
            background: #e9ecef;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 50px;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Raport Belajar</h1>
        <p>Nama: {{ auth()->user() ? auth()->user()->name : 'User' }}</p>
        <p>Email: {{ auth()->user() ? auth()->user()->email : 'user@example.com' }}</p>
        <p>Dibuat pada: {{ now()->format('d M Y H:i') }}</p>
    </div>

    @if($stats['total_tryouts'] > 0)
        <div class="stats">
            <div class="stat-item">
                <div class="stat-value">{{ $stats['total_tryouts'] }}</div>
                <div class="stat-label">Total Tryout</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $stats['average_score'] }}</div>
                <div class="stat-label">Rata-rata Skor</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $stats['best_score'] }}</div>
                <div class="stat-label">Skor Terbaik</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $stats['success_rate'] }}%</div>
                <div class="stat-label">Tingkat Keberhasilan</div>
            </div>
        </div>

        <div class="section">
            <h2>Riwayat Tryout Terbaru</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nama Ujian</th>
                        <th>Jenis</th>
                        <th>Tanggal</th>
                        <th>Durasi</th>
                        <th>Skor</th>
                        <th>Performa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentTryouts as $tryout)
                    <tr>
                        <td>{{ $tryout['ujian_name'] }}</td>
                        <td>{{ $tryout['jenis_ujian'] }}</td>
                        <td>{{ $tryout['date'] }}</td>
                        <td>{{ $tryout['duration'] }}</td>
                        <td>{{ $tryout['score'] }}</td>
                        <td>{{ $tryout['performance_level'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if(count($subjectPerformance) > 0)
        <div class="section">
            <h2>Analisis per Jenis Ujian</h2>
            <table>
                <thead>
                    <tr>
                        <th>Jenis Ujian</th>
                        <th>Rata-rata</th>
                        <th>Jumlah Tryout</th>
                        <th>Trend</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subjectPerformance as $subject => $data)
                    <tr>
                        <td>{{ $subject }}</td>
                        <td>{{ $data['average'] }}</td>
                        <td>{{ $data['count'] }}</td>
                        <td>{{ ucfirst($data['trend']) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        @if(count($achievements) > 0)
        <div class="section">
            <h2>Pencapaian</h2>
            @foreach($achievements as $achievement)
            <div class="achievement">
                <strong>{{ $achievement['title'] }}</strong><br>
                {{ $achievement['description'] }}
            </div>
            @endforeach
        </div>
        @endif

        <div class="section">
            <h2>Timeline Aktivitas Belajar</h2>
            <table>
                <thead>
                    <tr>
                        <th>Aktivitas</th>
                        <th>Tanggal</th>
                        <th>Skor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($learningTimeline as $activity)
                    <tr>
                        <td>{{ $activity['description'] }}</td>
                        <td>{{ $activity['date'] }}</td>
                        <td>{{ $activity['score'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="section">
            <h2>Belum Ada Data</h2>
            <p>Belum ada tryout yang diselesaikan. Mulai tryout pertama untuk melihat raport pembelajaran.</p>
        </div>
    @endif

    <div class="footer">
        <p>Raport ini dibuat secara otomatis oleh sistem DinasSolution</p>
        <p>&copy; {{ date('Y') }} DinasSolution. All rights reserved.</p>
    </div>
</body>
</html>