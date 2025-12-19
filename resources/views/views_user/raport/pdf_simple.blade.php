<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raport Belajar</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; border-bottom: 2px solid #667eea; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { color: #667eea; margin: 0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Raport Belajar</h1>
        <p>Test PDF Export</p>
    </div>

    <p>Total Tryout: {{ $stats['total_tryouts'] ?? 0 }}</p>
    <p>Rata-rata Skor: {{ $stats['average_score'] ?? 0 }}</p>
</body>
</html>