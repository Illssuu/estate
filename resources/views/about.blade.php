@extends('layouts.app')

@section('title', 'О нас')

@section('content')
<style>
    /* Общие стили */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    .nav-menu a,
    .nav-right span,
    .nav-right button{color: #d9d9d9;
    }
        body {
        font-family: 'Arimo', sans-serif;
        background-color: #000000ff;
        color: #d9d9d9;
    }
    
    .container {
        max-width: 1700px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    /* Типографика */
    h1, h2, h3, .title-large {
        font-family: 'Piazzolla', serif;
        font-weight: 200;
        letter-spacing: -1.8px;
    }
    
    /* Hero секция */
    .hero-section {
        height: 675px;
        background-color: #000000ff;
        position: relative;
        overflow: hidden;
    }
    
    .hero-content {
        position: relative;
        z-index: 2;
        padding-top: 120px;
    }
    
    .hero-title {
        font-size: 60px;
        color: #ffffff;
        line-height: 1.2;
        margin-bottom: 20px;
    }
    
    .hero-title-line {
         margin-left: 40px;
        font-size: 60px;
        color: #ffffff;
        line-height: 1.2;
    }
    
    .hero-subtitle {
         margin-left: 40px;
        font-size: 13px;
        color: #ffffff;
        margin-top: 40px;
        font-family: 'Arimo', sans-serif;
    }
    
    .hero-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: 1;
        opacity: 0.8;
    }
    
    /* Академики (портреты внизу) */
    .academics-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 30px;
        margin-top: 50px;
        position: relative;
        z-index: 3;
    }
    
    .academic-item {
        width: 49px;
        height: 49px;
        border-radius: 50%;
        overflow: hidden;
        transition: transform 0.3s ease;
        cursor: pointer;
    }
    
    .academic-item:hover {
        transform: scale(1.16);
    }
    
    .academic-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    /* Секция "О комплексе" */
    .about-complex {
        padding: 80px 0;
        background-color: #000000;
    }
    
    .section-label {
        font-size: 13px;
        color: #d9d9d9;
        margin-bottom: 20px;
        font-family: 'Arimo', sans-serif;
    }
    
    .section-title {
        font-size: 50px;
        color: #ffffff;
        margin-bottom: 40px;
    }
    
    .features-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        margin-top: 60px;
    }
    
    .feature-card {
        background-color: #4b4b4b;
        height: 327px;
        width: 100%;
        background-size: cover;
        background-position: center;
    }
    
    .feature-card:nth-child(1) {
        background-image: url('https://static.tildacdn.com/tild3339-6430-4464-a633-353733643263/__20_09_24__-66.jpg');
    }
    
    .feature-card:nth-child(2) {
        background-image: url('https://static.tildacdn.com/tild3538-3638-4430-a136-343163663434/__050624_1-64.jpg');
    }
    
    .feature-card:nth-child(3) {
        background-image: url('https://static.tildacdn.com/tild6438-3231-4263-b637-666232636433/12edit_7.jpg');
    }
    
    .feature-card:nth-child(4) {
        background-image: url('https://static.tildacdn.com/tild3662-3833-4766-a230-653862356536/_7_9.jpg');
    }
    
    .feature-label {
        font-size: 13px;
        color: #d9d9d9;
        margin-top: 15px;
        text-align: center;
    }
    
    /* Секция с цифрами */
    .stats-section {
        padding: 80px 0;
        background-color: #000000;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        text-align: center;
    }
    
    .stat-number {
        font-size: 86px;
        color: #d9d9d9;
        font-family: 'Piazzolla', serif;
        font-weight: 200;
        line-height: 1;
        margin-bottom: 10px;
    }
    
    .stat-label {
        font-size: 13px;
        color: #d9d9d9;
        font-family: 'Arimo', sans-serif;
    }
    
    .stat-card {
        background-color: #1d1b18;
        padding: 40px 20px;
        border: 1px solid #313131;
    }
    
    /* Секция "В историческом центре" */
    .location-section {
        padding: 80px 0;
        background-color: #000000;
    }
    
    .location-title {
        font-size: 50px;
        color: #d9d9d9;
        text-align: center;
        margin-bottom: 60px;
    }
    
    .location-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
    }
    
    .location-item {
        background-color: #7b5141;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .location-number {
        font-size: 77px;
        color: #d9d9d9;
        font-family: 'Piazzolla', serif;
        font-weight: 200;

    }
    
    .location-text {
        font-size: 13px;
        color: #d9d9d9;
        font-family: 'Arimo', sans-serif;
    }
    .location-wrapper {
    display: grid;
    grid-template-columns:  3fr 7fr;
    gap: 40px;
    align-items: center;
}


.location-image img {
    width: 100%;
    height: auto;
    border-radius: 10px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
}

/* Адаптивность для мобилок */
@media (max-width: 768px) {
    .location-wrapper {
        grid-template-columns: 1fr;
    }
    
    .location-image {
        order: -1; /* картинка сверху на мобилках */
        margin-bottom: 30px;
    }
}
    /* Секция "Гармония" */
    .harmony-section {
        padding: 80px 0;
        background-color: #000000;
    }
    
    .harmony-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
    }
    
    .harmony-card {
        background-color: #e6e6e6;
        padding: 60px;
        color: #080808;
    }
    
    .harmony-card.dark {
        background-color: #7b5141;
        color: #e3dfda;
    }
    
    .harmony-title {
        font-size: 50px;
        font-weight: 200;
        margin-bottom: 30px;
    }
    
    /* Форма */
    .form-section {
        padding: 80px 0;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
    }
    
    .form-container {
        background-color: #e6e6e6;
        padding: 60px;
    }
    
    .form-title {
        font-size: 50px;
        color: #080808;
        font-weight: 200;
        margin-bottom: 30px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-input {
        width: 100%;
        padding: 15px;
        border: none;
        background-color: #ffffff;
        font-family: 'Arimo', sans-serif;
    }
    
    .form-button {
        background-color: #7b5141;
        color: #e3dfda;
        border: none;
        padding: 15px 40px;
        border-radius: 30px;
        cursor: pointer;
        font-family: 'Arimo', sans-serif;
        transition: background-color 0.3s;
    }
    
    .form-button:hover {
        background-color: #c9a27e;
        color: #543022;
    }
    
    .form-image {
        background-color: #7b5141;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Секция "Место силы" */
    .power-place {
        padding: 80px 0;
    }
    
    .power-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
    }
    
    .power-text {
        color: #d9d9d9;
        font-size: 13px;
        line-height: 1.6;
    }
    
    /* Адаптивность */
    @media (max-width: 768px) {
        .hero-title,
        .hero-title-line {
            font-size: 40px;
        }
        
        .features-grid,
        .stats-grid,
        .location-grid,
        .harmony-grid,
        .form-section,
        .power-grid {
            grid-template-columns: 1fr;
        }
        
        .section-title {
            font-size: 36px;
        }
        
        .stat-number {
            font-size: 60px;
        }
        
        .academics-grid {
            gap: 10px;
        }
    }
    .card-image {
    width: 100%;
    height: 400px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #1d1b18; /* фон на случай проблем */
}

.card-image img {
    min-width: 100%;
    min-height: 100%;
    object-fit: cover; /* магия! */
    object-position: center; /* центрируем */
}
.card-caption{
display: none;
}

.location-map {
    width: 100%;        /* Занимает всю ширину своей колонки */
    height: 500px;      /* Фиксированная высота, подберите под свой дизайн */
    border-radius: 20px; /* Если нужны скругленные углы, как у картинки */
    overflow: hidden;   /* Чтобы карта не вылезала за скругленные углы */
}

#map {
    width: 100%;
    height: 100%;
}
</style>

<div class="about-page">
    <!-- Hero секция с портретами академиков -->
    <section class="hero-section">
         <video class="hero-image" autoplay muted loop playsinline>
        <source src="{{ asset('videos/main-video.mp4') }}" type="video/mp4">
        Ваш браузер не поддерживает видео.
    </video>
        <div class="container hero-content">
        </div>
    </section>

    <!-- О комплексе -->
    <section class="about-complex">
        <div class="container">
            <div class="section-label">о комплексе</div>
            <h2 class="section-title">ЖК Поместье — это гармоничное сочетание</h2>
            
            <div class="features-grid">
                <div class="feature-card"></div>
                <div class="feature-card"></div>
                <div class="feature-card"></div>
                <div class="feature-card"></div>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px; margin-top: 20px;">
                <div class="feature-label">центрального района города</div>
                <div class="feature-label">авторской архитектуры</div>
                <div class="feature-label">особых планировок</div>
                <div class="feature-label">эксклюзивных фасадов из стеклянного кирпича</div>
            </div>
        </div>
    </section>

    <!-- Цифры и факты -->
    <section class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">9</div>
                    <div class="stat-label">домов</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">277</div>
                    <div class="stat-label">парковочных мест</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">3-7</div>
                    <div class="stat-label">этажей</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">6</div>
                    <div class="stat-label">квартир с террасами</div>
                </div>
            </div>
        </div>
    </section>

    <!-- В историческом центре -->
   <section class="location-section">
    <div class="container">
        <h2 class="location-title">В историческом центре Казани</h2>
        
        <div class="location-wrapper">
            <!-- Левая колонка с локациями -->
            <div class="location-grid">
                <div class="location-item">
                    <span class="location-number">8</span>
                    <span class="location-text">минут Кремль и Кремлевская набережная</span>
                </div>
                <div class="location-item">
                    <span class="location-number">5</span>
                    <span class="location-text">минут Набережная озера Кабан</span>
                </div>
                <div class="location-item">
                    <span class="location-number">3</span>
                    <span class="location-text">минуты Парк Горького</span>
                </div>
                <div class="location-item">
                    <span class="location-number">7</span>
                    <span class="location-text">минут Парк Урам и детский парк Елмай</span>
                </div>
                <div class="location-item">
                    <span class="location-number">7</span>
                    <span class="location-text">минут ТЦ Арт-Центр</span>
                </div>
                <div class="location-item">
                    <span class="location-number">10</span>
                    <span class="location-text">минут Международная школа Unischool</span>
                </div>
            </div>
            
            <!-- Правая колонка с картинкой -->
             <div class="location-map">
                <div id="map"></div>
            </div>
        </div>
        
    </div>
</section>

    <!-- Место силы -->
    <section class="power-place">
        <div class="container">
            <h2 class="section-title">Место силы</h2>
            
            <div class="power-grid">
                <div>
                    <img src="{{ asset('img/power1.jpg') }}" alt="История" style="width: 100%;">
                </div>
                <div>
                    <p class="power-text">Каждый город — это не просто точки на карте, а переплетение судеб великих людей. Казань по праву гордится званием города академиков, где наука и искусство обретали свое бессмертие.<br>Мы не хотели строить просто стены. Мы решили создать пространство, где воздух наполнен духом свершений. Именно поэтому каждый из девяти корпусов нашего жилого комплекса носит имя одного из тех, кто прославил наш край. Это не просто названия на фасадах — это напоминание о том, что гении жили среди нас, ходили по тем же улицам и смотрели на то же небо.</p>
                    <p class="power-text" style="margin-top: 20px;">«Поместье» — это не только территория комфорта, но и территория памяти. Здесь, среди современных зданий, мы бережно храним имена тех, кем гордится вся страна. Расскажите о них своим детям, чтобы история продолжалась.</p>
                    <img src="{{ asset('img/power2.jpg') }}" alt="История" style="width: 100%; margin-top: 10px;">
                </div>
            </div>
        </div>
    </section>
        <!-- Слайдер бутстрап -->
    <section class="harmony-section py-5">
        <div class="container">
            <h2 class="section-title text-center mb-5">Гармония – как ключевой принцип</h2>
            
            <!-- Bootstrap Carousel -->
            <div id="harmonyCarousel" class="carousel slide" data-bs-ride="carousel">
                
                <!-- Индикаторы (точки) -->
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#harmonyCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Слайд 1"></button>
                    <button type="button" data-bs-target="#harmonyCarousel" data-bs-slide-to="1" aria-label="Слайд 2"></button>
                    <button type="button" data-bs-target="#harmonyCarousel" data-bs-slide-to="2" aria-label="Слайд 3"></button>
                    <button type="button" data-bs-target="#harmonyCarousel" data-bs-slide-to="3" aria-label="Слайд 4"></button>
                    <button type="button" data-bs-target="#harmonyCarousel" data-bs-slide-to="4" aria-label="Слайд 5"></button>
                    <button type="button" data-bs-target="#harmonyCarousel" data-bs-slide-to="5" aria-label="Слайд 6"></button>
                </div>
                
                <!-- Слайды -->
                <div class="carousel-inner">
                    <!-- Слайд 1 -->
                    <div class="carousel-item active">
                        <div class="carousel-card">
                            <div class="card-image">
                                <img src="{{ asset('img/fitness.jpg') }}" class="d-block w-100" alt="Фитнес-зал">
                            </div>
                            <div class="card-caption">
                                Фитнес-зал только для резидентов ЖК
                            </div>
                        </div>
                    </div>
                    
                    <!-- Слайд 2 -->
                    <div class="carousel-item">
                        <div class="carousel-card">
                            <div class="card-image">
                                <img src="{{ asset('img/kids-zone.jpg') }}" class="d-block w-100" alt="Детские зоны">
                            </div>
                            <div class="card-caption">
                                Продуманные детские зоны
                            </div>
                        </div>
                    </div>
                    
                    <!-- Слайд 3 -->
                    <div class="carousel-item">
                        <div class="carousel-card">
                            <div class="card-image">
                                <img src="{{ asset('img/stroller-room.jpg') }}" class="d-block w-100" alt="Комната для колясок">
                            </div>
                            <div class="card-caption">
                                Комната для колясок и велосипедов
                            </div>
                        </div>
                    </div>
                    
                    <!-- Слайд 4 -->
                    <div class="carousel-item">
                        <div class="carousel-card">
                            <div class="card-image">
                                <img src="{{ asset('img/lounge.jpg') }}" class="d-block w-100" alt="Зона отдыха">
                            </div>
                            <div class="card-caption">
                                Зона отдыха
                            </div>
                        </div>
                    </div>
                    
                    <!-- Слайд 5 -->
                    <div class="carousel-item">
                        <div class="carousel-card">
                            <div class="card-image">
                                <img src="{{ asset('img/lobby.jpg') }}" class="d-block w-100" alt="Дизайнерское лобби">
                            </div>
                            <div class="card-caption">
                                Дизайнерское лобби с консьержем
                            </div>
                        </div>
                    </div>
                
                </div>
                
                <!-- Кнопки навигации (стрелки) -->
                <button class="carousel-control-prev" type="button" data-bs-target="#harmonyCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Предыдущий</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#harmonyCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Следующий</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Архитектура -->
    <section class="harmony-section">
        <div class="container">
            <h2 class="section-title">Архитектура, продуманная до мелочей</h2>
            
            <img src="https://static.tildacdn.com/tild3863-3435-4137-b565-316433386437/__2024-09-26__170215.jpg" alt="Архитектура" style="width: 100%; margin-top: 40px;">
            
            <div style="text-align: center; margin-top: 40px;">
                <a href="{{ route('flats.index') }}" class="form-button">Смотреть планировки</a>
            </div>
        </div>
    </section>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Подождем, пока загрузится DOM
document.addEventListener('DOMContentLoaded', function() {
    // Проверяем, есть ли на странице контейнер карты
    if (!document.getElementById('map')) return;
    
    // Функция инициализации карты
    function initMap() {
        // Координаты центра (например, центр Казани)
        const center = [49.1056, 55.7963]; // [долгота, широта]
        
        // Создаем карту
        const map = new ymaps3.YMap(document.getElementById('map'), {
            location: {
                center: center,
                zoom: 13, // Подберите масштаб, чтобы были видны все точки
                bounds: { // Ограничиваем область (опционально)
                    southWest: [49.0, 55.75],
                    northEast: [49.2, 55.85]
                }
            }
        });

        // Добавляем слой карты
        map.addChild(new ymaps3.YMapDefaultSchemeLayer());
        map.addChild(new ymaps3.YMapDefaultFeaturesLayer());

        // СОЗДАЕМ МАРКЕРЫ ДЛЯ ВСЕХ ВАШИХ ЛОКАЦИЙ
        const locations = [
            { text: "Кинотеатр Мир", coords: [49.147332, 55.788080] },
            { text: "Набережная озера Кабан", coords: [49.1178, 55.7821] },
            { text: "Парк Горького", coords: [49.1225, 55.7808] },
            { text: "Парк Урам", coords: [49.1315, 55.8105] },
            { text: "ТЦ Арт-Центр", coords: [49.1219, 55.8112] },
            { text: "Международная школа Unischool", coords: [49.0892, 55.7701] }
        ];
        
        // ВАЖНО: Вам нужно найти точные координаты для каждого места!
        // Как это сделать, написано ниже ⬇️

        // Добавляем маркеры
        locations.forEach(location => {
            // Создаем красивый маркер
            const markerElement = document.createElement('div');
            markerElement.className = 'custom-marker';
            
            // Можно использовать иконку или цифру
            markerElement.innerHTML = `
                <div style="
                    background-color: #ff6b6b;
                    color: white;
                    width: 36px;
                    height: 36px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-weight: bold;
                    border: 3px solid white;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.3);
                ">
                    ${location.text.match(/\d+/)?.[0] || '•'}
                </div>
            `;
            
            // Добавляем маркер на карту
            map.addChild(new ymaps3.YMapMarker({
                coordinates: location.coords,
            }, markerElement));
        });
    }

    // Подключаем API Яндекс Карт
    const script = document.createElement('script');
    
    document.head.appendChild(script);
});
</script>
@endsection