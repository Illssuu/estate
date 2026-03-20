<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Напоминание о просмотре</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .email-header {
            background: #1a3b2e;
            padding: 30px 20px;
            text-align: center;
        }
        .email-header h1 {
            color: white;
            margin: 0;
            font-size: 24px;
        }
        .email-header p {
            color: rgba(255,255,255,0.9);
            margin: 10px 0 0;
        }
        .email-body {
            padding: 30px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #1a3b2e;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
        }
        .info-row {
            margin-bottom: 12px;
        }
        .info-label {
            font-weight: 600;
            color: #1a3b2e;
            display: inline-block;
            width: 100px;
        }
        .info-value {
            color: #555;
        }
        .btn {
            display: inline-block;
            background: #1a3b2e;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
            font-weight: 500;
        }
        .btn:hover {
            background: #0f2b21;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #eee;
        }
        .footer p {
            margin: 5px 0;
        }
        @media (max-width: 600px) {
            .email-body {
                padding: 20px;
            }
            .info-label {
                display: block;
                width: auto;
                margin-bottom: 4px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>🔔 Напоминание о просмотре</h1>
            <p>Жилой комплекс «Академик»</p>
        </div>
        
        <div class="email-body">
            <div class="greeting">
                Здравствуйте, <strong>{{ $appointment->user->name }}</strong>!
            </div>
            
            <p>Напоминаем, что <strong>через час</strong> у вас запланирован просмотр квартиры.</p>
            
            <div class="info-box">
                <div class="info-row">
                    <span class="info-label">📅 Дата:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($appointment->date)->format('d.m.Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">⏰ Время:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">🏢 Квартира:</span>
                    <span class="info-value">{{ $appointment->flat->title }}</span>
                </div>
                @if($appointment->flat->address ?? false)
                <div class="info-row">
                    <span class="info-label">📍 Адрес:</span>
                    <span class="info-value">{{ $appointment->flat->address }}</span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">📞 Контакты:</span>
                    <span class="info-value">+7 (495) 123-45-67</span>
                </div>
            </div>
            
            <div style="text-align: center;">
                <a href="{{ route('flats.show', $appointment->flat_id) }}" class="btn">
                    Посмотреть квартиру
                </a>
            </div>
        </div>
        
        <div class="footer">
            <p>Это письмо отправлено автоматически, пожалуйста, не отвечайте на него.</p>
            <p>© {{ date('Y') }} Жилой комплекс «Академик»</p>
        </div>
    </div>
</body>
</html>