@extends('layouts.app')

@section('title', 'Программа обратного выкупа')

@section('content')
<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    }
    .nav-menu a,
    .nav-right span,
    .nav-right button{color: #d9d9d9;
    }
    /* Общие стили страницы */
    body {
        font-family: 'Arimo', sans-serif;
        background-color: #000000 !important;
    }
    .container {
        max-width: 1700px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    .buyback-page {
        background-color: #000000;
        min-height: 100vh;
        color: #d9d9d9;
    }
    
    /* Hero секция */
    .buyback-hero {
        background: url('https://static.tildacdn.com/tild3261-3339-4662-a461-376533323066/_1.jpg');
        background-size: cover;
        background-position: center;
 height: 600px;
        display: flex;
        align-items: flex-end;
        color: white;
        margin-bottom: 50px;
    }
    
    .buyback-hero h1 {
        font-size: 48px;
        font-weight: 300;
        margin-bottom: 20px;
    }

    .buyback-hero p {
        font-size: 18px;
        opacity: 0.9;
    }
    
    /* Карточки преимуществ */
    .guarantee-card {
        background: #1d1b18;
        border: 1px solid #313131;
        padding: 30px 20px;
        border-radius: 10px;
        margin-bottom: 30px;
        transition: transform 0.3s ease, border-color 0.3s ease;
        height: 100%;
    }
    
    .guarantee-card:hover {
        transform: translateY(-5px);
        border-color: #7b5141;
    }
    
    .guarantee-card i {
        color: #7b5141;
        margin-bottom: 15px;
    }
    
    .guarantee-card h4 {
        font-size: 24px;
        font-weight: 400;
        margin: 15px 0 10px;
        color: #ffffff;
    }
    
    .guarantee-card p {
        font-size: 14px;
        color: #a0a0a0;
        margin: 0;
    }
    
    /* Заголовки секций */
    h2 {
        font-size: 36px;
        font-weight: 300;
        color: #ffffff;
        margin-bottom: 40px;
        position: relative;
        padding-bottom: 15px;
    }
    
    h2:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 2px;
        background: #7b5141;
    }
    
    /* Шаги */
    .step-item {
        display: flex;
        gap: 25px;
        margin-bottom: 35px;
        align-items: flex-start;
        background: #1d1b18;
        padding: 25px;
        border-radius: 10px;
        border: 1px solid #313131;
    }
    
    .step-number {
        width: 60px;
        height: 60px;
        background: #7b5141;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: bold;
        flex-shrink: 0;
    }
    
    .step-item h4 {
        font-size: 22px;
        font-weight: 400;
        color: #ffffff;
        margin-bottom: 10px;
    }
    
    .step-item p {
        font-size: 15px;
        color: #a0a0a0;
        margin: 0;
        line-height: 1.6;
    }
    
    /* Условия */
    .condition-item {
        padding: 18px 15px;
        border-bottom: 1px solid #313131;
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 16px;
    }
    
    .condition-item:last-child {
        border-bottom: none;
    }
    
    .condition-item i {
        font-size: 20px;
        flex-shrink: 0;
    }
    
    .condition-item i.text-success {
        color: #4caf50 !important;
    }
    
    .condition-item i.text-warning {
        color: #ff9800 !important;
    }
    
    .condition-item strong {
        color: #ffffff;
        font-weight: 500;
        min-width: 140px;
    }
    
    /* Форма */
    .form-section {
        background: #1d1b18;
        border: 1px solid #313131;
        padding: 50px;
        border-radius: 15px;
        margin: 60px 0;
    }
    
    .form-section h2 {
        margin-top: 0;
        margin-bottom: 30px;
    }
    
    .form-section h2:after {
        left: 0;
    }
    
    .form-label {
        color: #ffffff;
        font-weight: 400;
        font-size: 15px;
        margin-bottom: 8px;
    }
    
    .form-label .text-danger {
        color: #ff6b6b !important;
    }
    
    .form-control, .form-select {
        background: #000000;
        border: 1px solid #313131;
        color: #d9d9d9;
        padding: 12px 15px;
        border-radius: 8px;
        font-size: 15px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        background: #000000;
        border-color: #7b5141;
        color: #d9d9d9;
        box-shadow: 0 0 0 3px rgba(123, 81, 65, 0.2);
        outline: none;
    }
    
    .form-control::placeholder {
        color: #666;
        font-size: 14px;
    }
    
    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #ff6b6b;
        background-image: none;
    }
    
    .invalid-feedback {
        color: #ff6b6b;
        font-size: 13px;
        margin-top: 5px;
    }
    
    .text-muted {
        color: #888 !important;
        font-size: 13px;
        margin-top: 5px;
        display: block;
    }
    
    .btn-primary {
        background: #7b5141;
        border: none;
        padding: 16px 40px;
        font-size: 16px;
        font-weight: 500;
        border-radius: 50px;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .btn-primary:hover {
        background: #9b6b55;
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(123, 81, 65, 0.4);
    }
    
    .btn-primary:active {
        transform: translateY(0);
    }
    
    .alert-success {
        background: #1d3d2a;
        border-color: #2d5a3a;
        color: #d9d9d9;
        padding: 15px 20px;
        border-radius: 8px;
        font-size: 15px;
    }
    
    .alert-secondary {
        background: #1d1b18;
        border: 1px solid #313131;
        color: #a0a0a0;
        padding: 15px 20px;
        border-radius: 8px;
        font-size: 14px;
    }
    
    .alert-secondary i {
        color: #7b5141;
        margin-right: 8px;
    }
    
    /* Accordion (FAQ) */
    .accordion-item {
        background: #1d1b18;
        border-color: #313131;
        margin-bottom: 10px;
        border-radius: 8px !important;
        overflow: hidden;
    }
    
    .accordion-button {
        background: #1d1b18;
        color: #ffffff;
        font-size: 16px;
        font-weight: 400;
        padding: 18px 20px;
    }
    
    .accordion-button:not(.collapsed) {
        background: #1d1b18;
        color: #ffffff;
        box-shadow: none;
    }
    
    .accordion-button:focus {
        box-shadow: none;
        border-color: #7b5141;
    }
    
    .accordion-button::after {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ffffff'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    }
    
    .accordion-body {
        color: #a0a0a0;
        background: #000000;
        padding: 20px;
        font-size: 15px;
        line-height: 1.6;
        border-top: 1px solid #313131;
    }
    
    /* Адаптивность */
    @media (max-width: 768px) {
        .buyback-hero {
            height: 300px;
        }
        
        .buyback-hero h1 {
            font-size: 32px;
        }
        
        h2 {
            font-size: 28px;
        }
        
        .step-item {
            flex-direction: column;
            gap: 15px;
            padding: 20px;
        }
        
        .condition-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        
        .condition-item strong {
            min-width: auto;
        }
        
        .form-section {
            padding: 30px 20px;
        }
        
        .btn-primary {
            width: 100%;
        }
    }
    
    /* Для очень маленьких экранов */
    @media (max-width: 480px) {
        .buyback-hero h1 {
            font-size: 28px;
        }
        
        .guarantee-card {
            padding: 20px 15px;
        }
        
        .guarantee-card h4 {
            font-size: 20px;
        }
    }
    
    /* Стили для файлового инпута */
    input[type="file"]::file-selector-button {
        background: #7b5141;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        margin-right: 15px;
        font-size: 14px;
        cursor: pointer;
        transition: background 0.3s ease;
    }
    
    input[type="file"]::file-selector-button:hover {
        background: #9b6b55;
    }
</style>

<div class="buyback-page">
    <!-- Hero секция -->
    <section class="buyback-hero">
        <div class="container">
            <h1 class="display-3">Гарантия обратного выкупа</h1>
            <p class="lead">3 месяца на размышление. Передумали? Мы выкупим квартиру!</p>
        </div>
    </section>
    
    <div class="container">
        <!-- Основные преимущества -->
        <div class="row mb-5">
            <div class="col-md-4 mb-3">
                <div class="guarantee-card text-center">
                    <i class="bi bi-calendar-check" style="font-size: 48px;"></i>
                    <h4>3 месяца</h4>
                    <p>Срок для принятия решения</p>
                </div>
            </div>
            
            <div class="col-md-4 mb-3">
                <div class="guarantee-card text-center">
                    <i class="bi bi-arrow-return-left" style="font-size: 48px;"></i>
                    <h4>Обратный выкуп</h4>
                    <p>Определяем справедливую цену</p>
                </div>
            </div>
            
            <div class="col-md-4 mb-3">
                <div class="guarantee-card text-center">
                    <i class="bi bi-shield-check" style="font-size: 48px;"></i>
                    <h4>С ремонтом или без</h4>
                    <p>Можете делать ремонт</p>
                </div>
            </div>
        </div>
        
        <!-- Как это работает -->
        <h2>Как это работает</h2>
        <div class="row mb-5">
            <div class="col-lg-12">
                <div class="step-item">
                    <div class="step-number">1</div>
                    <div>
                        <h4>Вы покупаете квартиру</h4>
                        <p>Заключаете договор купли-продажи и получаете ключи</p>
                    </div>
                </div>
                
                <div class="step-item">
                    <div class="step-number">2</div>
                    <div>
                        <h4>3 месяца на размышление</h4>
                        <p>Живете, делаете ремонт, принимаете решение. Мы не ограничиваем вас в ремонте!</p>
                    </div>
                </div>
                
                <div class="step-item">
                    <div class="step-number">3</div>
                    <div>
                        <h4>Если решили вернуть</h4>
                        <p>Подаете заявку на возврат. Наш специалист приходит для осмотра квартиры</p>
                    </div>
                </div>
                
                <div class="step-item">
                    <div class="step-number">4</div>
                    <div>
                        <h4>Оценка и выкуп</h4>
                        <p>Мы оцениваем квартиру с учетом ремонта и договариваемся о справедливой цене</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Условия программы -->
        <h2>Условия программы</h2>
        <div class="guarantee-card mb-5">
            <div class="condition-item">
                <i class="bi bi-check-circle-fill text-success"></i>
                <strong>Срок:</strong> 3 месяца с момента подписания договора
            </div>
            <div class="condition-item">
                <i class="bi bi-check-circle-fill text-success"></i>
                <strong>Ремонт:</strong> Можно делать любые улучшения (это повысит стоимость)
            </div>
            <div class="condition-item">
                <i class="bi bi-check-circle-fill text-success"></i>
                <strong>Процедура:</strong> Выезд специалиста для осмотра и оценки
            </div>
            <div class="condition-item">
                <i class="bi bi-info-circle-fill text-warning"></i>
                <strong>Цена выкупа:</strong> Определяется индивидуально с учетом ремонта и рыночной ситуации
            </div>
            <div class="condition-item">
                <i class="bi bi-info-circle-fill text-warning"></i>
                <strong>Выплата:</strong> В течение 10 рабочих дней после подписания договора
            </div>
        </div>
        
        <!-- Форма заявки -->
        <!-- Форма заявки -->
<section class="form-section">
    <h2>Оставить заявку на обратный выкуп</h2>
    
    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger mb-4">
            {{ session('error') }}
        </div>
    @endif
    
    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('buyback.request') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
            <!-- Номер договора -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Номер договора <span class="text-danger">*</span></label>
                <input type="text" 
                       name="contract_number" 
                       class="form-control @error('contract_number') is-invalid @enderror" 
                       value="{{ old('contract_number') }}" 
                       placeholder="ДКП-2024-001"
                       required>
                @error('contract_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="field-hint">Формат: ДКП-2024-001 (только буквы, цифры и дефис)</small>
            </div>
            
            <!-- Дата договора -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Дата договора <span class="text-danger">*</span></label>
                <input type="date" 
                       name="contract_date" 
                       class="form-control @error('contract_date') is-invalid @enderror" 
                       value="{{ old('contract_date') }}" 
                       required>
                @error('contract_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="field-hint">Дата не может быть позже сегодняшнего дня</small>
            </div>
            
            <!-- ФИО -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Ваше ФИО <span class="text-danger">*</span></label>
                <input type="text" 
                       name="name" 
                       class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name') }}" 
                       placeholder="Иванов Иван Иванович"
                       required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="field-hint">Только русские буквы, пробелы и дефис</small>
            </div>
            
            <!-- Телефон -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Телефон <span class="text-danger">*</span></label>
                <input type="tel" 
                       name="phone" 
                       class="form-control @error('phone') is-invalid @enderror" 
                       value="{{ old('phone') }}" 
                       placeholder="+7 (999) 123-45-67"
                       required>
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="field-hint">Формат: +7XXXXXXXXXX</small>
            </div>
            
            <!-- Скан договора -->
            <div class="col-md-12 mb-3">
                <label class="form-label">Скан/фото договора  <span class="text-danger">*</span></label>
                <input type="file" 
                       name="contract_scan" 
                       class="form-control @error('contract_scan') is-invalid @enderror" 
                       accept=".pdf,.jpg,.jpeg,.png"
                       required>
                @error('contract_scan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Максимальный размер: 5 МБ. Форматы: PDF, JPG, PNG</small>
            </div>
            
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    Отправить заявку
                </button>
            </div>
            
            <div class="col-12 mt-3">
                <div class="alert alert-secondary">
                    <i class="bi bi-shield-lock"></i>
                    Ваши данные защищены. После проверки с вами свяжется менеджер для согласования осмотра.
                </div>
            </div>
        </div>
    </form>
</section>
        
        <!-- Часто задаваемые вопросы -->
        <section class="my-5">
            <h2>Часто задаваемые вопросы</h2>
            
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            В течение какого времени можно вернуть квартиру?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            У вас есть 3 месяца с момента подписания договора купли-продажи, чтобы принять решение.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            Можно ли делать ремонт?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Да, можно делать любой ремонт. При выкупе мы оценим квартиру с учетом всех улучшений.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                            Как определяется цена выкупа?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Наш специалист приедет, оценит состояние квартиры, сделанный ремонт, и мы предложим справедливую рыночную цену.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                            Как быстро вы вернете деньги?
                        </button>
                    </h2>
                    <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            В течение 10 рабочих дней после подписания договора обратного выкупа.
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection