<?php get_header(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo esc_html( get_theme_mod('mkprod_meta_title','MKProd — SEO, Контекст и Создание сайтов | Михаил Киселёв') ); ?></title>
<meta name="description" content="<?php echo esc_attr( get_theme_mod('mkprod_meta_desc','MKProd — студийный уровень: SEO-продвижение, настройка рекламы Яндекс Директ и разработка сайтов с нуля под бизнес-задачи.') ); ?>">
<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon.png">
<meta property="og:title" content="<?php echo esc_html( get_theme_mod('mkprod_meta_title','MKProd — SEO, Контекст и Создание сайтов') ); ?>">
<meta property="og:description" content="<?php echo esc_attr( get_theme_mod('mkprod_meta_desc','Студийный уровень: SEO, Яндекс Директ, сайты под ключ.') ); ?>">
<meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/assets/img/mikhail-1.png">
<meta name="theme-color" content="#070a14">
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Person",
  "name": "<?php echo esc_html( get_theme_mod('mkprod_name','Михаил Киселёв') ); ?>",
  "jobTitle": "SEO / PPC / Веб-разработка",
  "brand": "MKProd",
  "url": "<?php echo esc_url( home_url('/') ); ?>",
  "image": "<?php echo get_template_directory_uri(); ?>/assets/img/mikhail-1.png",
  "sameAs": [
    "<?php echo esc_url( get_theme_mod('mkprod_vk','https://vk.com/') ); ?>",
    "<?php echo esc_url( get_theme_mod('mkprod_telegram','https://t.me/') ); ?>",
    "https://youtube.com/"
  ]
}
</script>
<link rel="preload" as="image" href="<?php echo get_template_directory_uri(); ?>/assets/img/mikhail-1.png">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/style.css">

    <style id="mkp-uploader-style">
      .mkp-dropzone{border:1px dashed rgba(0,240,255,.35);border-radius:14px;padding:14px;background:rgba(0,240,255,.03);margin:10px 0 12px}
      .mkp-dropzone .dz-cta{display:flex;align-items:center;gap:10px;color:var(--muted);flex-wrap:wrap}
      .mkp-dropzone .dz-ico{display:grid;place-items:center;width:32px;height:32px;border-radius:10px;border:1px solid rgba(0,240,255,.35);background:rgba(0,240,255,.06);font-weight:800}
      .mkp-dropzone .dz-btn{background:transparent;border:none;color:var(--txt);text-decoration:underline;cursor:pointer}
      .mkp-dropzone .dz-list{list-style:none;margin:10px 0 0;padding:0;display:flex;flex-wrap:wrap;gap:8px}
      .mkp-dropzone .dz-list li{font-size:13px;color:var(--muted);padding:6px 10px;border:1px solid rgba(0,240,255,.25);border-radius:999px;background:rgba(0,240,255,.04)}
      @media (max-width:640px){.mkp-dropzone{padding:12px}}
    </style>
    

    <style id="mkp-contacts-style">
      .mkp-contacts{position:relative;overflow:hidden}
      .mkp-contacts::before{content:"";position:absolute;right:-40px;top:-40px;width:220px;height:220px;border-radius:50%;
        background:radial-gradient(circle at 30% 30%, rgba(0,240,255,.25), rgba(122,92,255,.12) 45%, transparent 60%);
        filter:blur(8px);pointer-events:none}
      .mkp-contacts::after{content:"";position:absolute;left:-60px;bottom:-60px;width:320px;height:320px;border-radius:50%;
        background:radial-gradient(circle at 70% 70%, rgba(122,92,255,.22), rgba(0,240,255,.1) 50%, transparent 70%);
        filter:blur(10px);pointer-events:none}
      .mkp-contacts-wave{width:100%;height:38px;margin:6px 0 10px;opacity:.9;mix-blend:screen}
      .mkp-contacts .badge{display:inline-flex;align-items:center;gap:8px}
      .mkp-contacts .badge .ico{width:14px;height:14px;opacity:.9}
    </style>
    

    <style id="mkp-contacts-grid-style">
      .mkp-contacts{position:relative;overflow:hidden}
      .mkp-contacts .mkp-contacts-grid{
        position:absolute;inset:0;pointer-events:none;opacity:.25;
        background-image:
          linear-gradient(rgba(0,240,255,.12) 1px, transparent 1px),
          linear-gradient(90deg, rgba(0,240,255,.12) 1px, transparent 1px);
        background-size: 38px 38px, 38px 38px;
        transform: translate3d(0,0,0);
        transition: transform .15s ease-out;
        mix-blend:screen;
      }
      .mkp-contacts:hover .mkp-contacts-grid{opacity:.32}
      .mkp-contacts-wave{width:100%;height:38px;margin:6px 0 10px;opacity:.9;mix-blend:screen}
    </style>
   <style id="mkp-ticker-duo-style">
  .ticker-duo{padding:26px 0 6px}
  .mkp-ticker.glass.bright{
    width:min(1100px,78vw); margin:0 auto; position:relative; overflow:hidden; border-radius:20px;
    border:1px solid rgba(0,240,255,.22);
    background:linear-gradient(180deg, rgba(255,255,255,.10), rgba(255,255,255,.06));
    box-shadow: inset 0 0 22px rgba(0,240,255,.16), 0 8px 24px rgba(0,0,0,.35);
    -webkit-mask-image: linear-gradient(90deg, transparent, #000 6%, #000 94%, transparent);
            mask-image: linear-gradient(90deg, transparent, #000 6%, #000 94%, transparent);
    backdrop-filter: blur(8px) saturate(130%);
  }
  .mkp-ticker.glass.bright::before{
    content:""; position:absolute; left:10px; right:10px; top:8px; height:1px;
    background:linear-gradient(90deg, rgba(255,255,255,.35), rgba(255,255,255,.0));
    opacity:.5; border-radius:1px; pointer-events:none;
  }
  .mkp-track{display:flex; gap:42px; white-space:nowrap; padding:12px 22px; will-change:transform}
  .mkp-item{font-size:14px; letter-spacing:.2px}
  .sep{opacity:.45}
  .mkp-track .mkp-item strong, .mkp-track .mkp-item b{
    background:linear-gradient(90deg,#00f0ff,#7a5cff); -webkit-background-clip:text; background-clip:text; color:transparent
  }
  .dir-left{animation:mkp-left 22s linear infinite}
  .dir-right{animation:mkp-right 28s linear infinite}
  .slow{opacity:.95; transform:translateY(2px)}
  .mkp-ticker:hover .dir-left, .mkp-ticker:hover .dir-right{animation-play-state:paused}
  @keyframes mkp-left{from{transform:translateX(0)} to{transform:translateX(-50%)}}
  @keyframes mkp-right{from{transform:translateX(-50%)} to{transform:translateX(0)}}
  @media (max-width:760px){
    .mkp-ticker.glass.bright{width:92vw}
    .mkp-item{font-size:13px}
    .mkp-track{gap:28px; padding:10px 16px}
  }
  @media (prefers-reduced-motion: reduce){
    .dir-left,.dir-right{animation:none}
  }
</style> 
</head>
<body>
<header class="header">
  <div class="container row">
    <div class="row logo">
      <?php if ( get_theme_mod('mkprod_logo') ): ?>
        <img src="<?php echo esc_url( get_theme_mod('mkprod_logo') ); ?>" alt="MKProd" style="height:28px">
      <?php else: ?>
        <div class="logo-mark" aria-hidden="true"></div>
        <span>MKProd</span>
      <?php endif; ?>
    </div>
    <nav class="nav">
      <a href="#services">Услуги</a>
      <a href="#process">Процесс</a>
      <a href="#pricing">Тарифы</a>
      <a href="#calc">Калькулятор</a>
      <a href="#contact" class="btn cta">Связаться</a>
    </nav>
  </div>
</header>
<section class="hero section">
  <div class="grid" data-parallax-speed="0.15"></div>
  <div class="decor"><div class="orb"></div><div class="orb alt"></div><div class="line"></div></div>
<svg class="neon-wave" viewBox="0 0 1440 200" preserveAspectRatio="none" aria-hidden="true"><defs><linearGradient id="g" x1="0" x2="1"><stop offset="0" stop-color="#00f0ff"/><stop offset="1" stop-color="#7a5cff"/></linearGradient><filter id="glow"><feGaussianBlur stdDeviation="4" result="b"/><feMerge><feMergeNode in="b"/><feMergeNode in="SourceGraphic"/></feMerge></filter></defs><path d="M0,120 C240,60 480,180 720,110 C960,40 1200,140 1440,70 L1440,200 L0,200 Z" fill="url(#g)" opacity="0.15"></path><path class="wave-line" d="M0,120 C240,60 480,180 720,110 C960,40 1200,140 1440,70" stroke="url(#g)" stroke-width="3" fill="none" filter="url(#glow)"/></svg>
  <div class="container hero-wrap">
    <div>
      <div class="kicker">MKProd · <?php echo esc_html( get_theme_mod('mkprod_name','Михаил Киселёв') ); ?></div>
      <h1>Сайты, SEO и Яндекс Директ,<br><span class="hero-accent">которые приносят деньги</span></h1>
      <p class="lead">Студийное качество без бюрократии. Уникальный UX, сильная SEO-архитектура, продуманная аналитика и ответственность за результат.</p>
      <div class="badges">
        <span class="badge">SEO от 50 000 ₽/мес</span>
        <span class="badge">Сайты от 100 000 ₽</span>
        <span class="badge">PPC · Яндекс Директ</span>
        <span class="badge">UX · аналитика · конверсия</span>
      </div>
      <p style="margin-top:18px">
        <a href="#contact" class="btn cta">Обсудить проект</a>
      </p>
    </div>
    <div class="hero-card" data-parallax-speed="0.08">
      <div class="video-slot" data-youtube="https://www.youtube.com/embed/"></div>
      <div class="play"><button class="btn" aria-label="Смотреть видео">▶ Смотреть видео</button></div>
    </div>
  </div>
</section>

<section class="section ticker-duo" aria-label="MKProd highlights">
  <div class="container">
    <div class="mkp-ticker glass bright" role="marquee" aria-live="polite">
      <div class="mkp-track dir-left"><span class="mkp-item">Сайты, которые продают — не просто выглядят</span><span class="sep">✦</span><span class="mkp-item">PageSpeed 90+ без перегруза</span><span class="sep">✦</span><span class="mkp-item">Один договор — весь комплекс работ</span><span class="sep">✦</span><span class="mkp-item">Команда MKProd — вовлечены на 100%</span><span class="sep">✦</span><span class="mkp-item">CPA ↓ до 32% за 6–8 недель</span><span class="sep">✦</span><span class="mkp-item">UX, SEO, аналитика — всё под одним стеклом</span><span class="sep">✦</span><span class="mkp-item">Headless / WordPress • GA4 • GTM</span><span class="sep">✦</span><span class="mkp-item">Гарантия на баг-фиксы 30 дней</span><span class="sep">✦</span><span class="mkp-item">Аудит, стратегия, реализация — без разрывов</span><span class="sep">✦</span><span class="mkp-item">Поддержка после релиза — по договору SLA</span><span class="sep">✦</span><span class="mkp-item">SEO-структура заложена с прототипа</span><span class="sep">✦</span><span class="mkp-item">Честная аналитика: без «воды» и «отписок»</span><span class="sep">✦</span><span class="mkp-item">Клиентский кабинет с прозрачной статистикой</span><span class="sep">✦</span><span class="mkp-item">Каждый проект — как собственный бизнес</span><span class="mkp-item">Сайты, которые продают — не просто выглядят</span><span class="sep">✦</span><span class="mkp-item">PageSpeed 90+ без перегруза</span><span class="sep">✦</span><span class="mkp-item">Один договор — весь комплекс работ</span><span class="sep">✦</span><span class="mkp-item">Команда MKProd — вовлечены на 100%</span><span class="sep">✦</span><span class="mkp-item">CPA ↓ до 32% за 6–8 недель</span><span class="sep">✦</span><span class="mkp-item">UX, SEO, аналитика — всё под одним стеклом</span><span class="sep">✦</span><span class="mkp-item">Headless / WordPress • GA4 • GTM</span><span class="sep">✦</span><span class="mkp-item">Гарантия на баг-фиксы 30 дней</span><span class="sep">✦</span><span class="mkp-item">Аудит, стратегия, реализация — без разрывов</span><span class="sep">✦</span><span class="mkp-item">Поддержка после релиза — по договору SLA</span><span class="sep">✦</span><span class="mkp-item">SEO-структура заложена с прототипа</span><span class="sep">✦</span><span class="mkp-item">Честная аналитика: без «воды» и «отписок»</span><span class="sep">✦</span><span class="mkp-item">Клиентский кабинет с прозрачной статистикой</span><span class="sep">✦</span><span class="mkp-item">Каждый проект — как собственный бизнес</span></div>
      <div class="mkp-track dir-right slow"><span class="mkp-item">Диагностика → гипотезы → эксперименты → рост</span><span class="sep">✦</span><span class="mkp-item">Тонкая настройка Яндекс Директ и автоправил</span><span class="sep">✦</span><span class="mkp-item">Страницы с высокой конверсией из прототипа</span><span class="sep">✦</span><span class="mkp-item">Техдолг под контролем, чистый код</span><span class="sep">✦</span><span class="mkp-item">Lighthouse: CLS ≤ 0.1, LCP ≤ 2.5 c</span><span class="sep">✦</span><span class="mkp-item">E-commerce события и корректная атрибуция</span><span class="sep">✦</span><span class="mkp-item">Миграции без потери трафика</span><span class="sep">✦</span><span class="mkp-item">Контент-план и перелинковка по карте релевантности</span><span class="sep">✦</span><span class="mkp-item">Воркфлоу в спринтах, отчёты каждую неделю</span><span class="sep">✦</span><span class="mkp-item">CI/CD и превью-сборки для согласований</span><span class="sep">✦</span><span class="mkp-item">Доступы и безопасность — парольные менеджеры</span><span class="sep">✦</span><span class="mkп-item">Масштабируемая архитектура и кеши</span><span class="sep">✦</span><span class="mkp-item">Дизайн-система и единые токены интерфейса</span><span class="sep">✦</span><span class="mkp-item">Сквозная аналитика: от объявления до выручки</span><span class="mkp-item">Диагностика → гипотезы → эксперименты → рост</span><span class="sep">✦</span><span class="mkp-item">Тонкая настройка Яндекс Директ и автоправил</span><span class="sep">✦</span><span class="mkp-item">Страницы с высокой конверсией из прототипа</span><span class="sep">✦</span><span class="mkp-item">Техдолг под контролем, чистый код</span><span class="sep">✦</span><span class="mkp-item">Lighthouse: CLS ≤ 0.1, LCP ≤ 2.5 c</span><span class="sep">✦</span><span class="mkp-item">E-commerce события и корректная атрибуция</span><span class="sep">✦</span><span class="mkp-item">Миграции без потери трафика</span><span class="sep">✦</span><span class="mkp-item">Контент-план и перелинковка по карте релевантности</span><span class="sep">✦</span><span class="mkp-item">Воркфлоу в спринтах, отчёты каждую неделю</span><span class="sep">✦</span><span class="mkp-item">CI/CD и превью-сборки для согласований</span><span class="sep">✦</span><span class="mkp-item">Доступы и безопасность — парольные менеджеры</span><span class="sep">✦</span><span class="mkp-item">Масштабируемая архитектура и кеши</span><span class="sep">✦</span><span class="mkp-item">Дизайн-система и единые токены интерфейса</span><span class="sep">✦</span><span class="mkp-item">Сквозная аналитика: от объявления до выручки</span></div>
    </div>
  </div>
</section>

<section class="section tight section-a">
  <div class="container" style="display:grid;grid-template-columns:1.2fr .8fr;gap:24px;align-items:end">
    <div>
      <h2>Команда MKProd</h2>
      <p>Без переложений ответственности. Личный контроль сроков и качества. Включён в проект на 100%.</p>
      <div class="cards" style="margin-top:16px">
        <div class="card"><h3>Прозрачность</h3><p>Покажу, за счёт чего растёт трафик и конверсия: чек-листы, бэклоги, KPI.</p></div>
        <div class="card"><h3>Скорость</h3><p>Бёрн-даун план, недельные итерации, приоритеты — вы видите прогресс.</p></div>
        <div class="card"><h3>Качество</h3><p>Чистый код, лёгкий фронт, строгая SEO-структура, дизайн без шаблонности.</p></div>
      </div>
    </div>
    <figure class="figure" data-parallax-speed="0.12">
      <div class="frame">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/mikhail-1.png" alt="Михаил Киселёв — MKProd">
        <div class="floor-fade"></div>
      </div>
      <div class="base-glow"></div>
    </figure>
  </div>
<div class="neon-sep"></div>
</section>
<section id="services" class="section section-b">
  <div class="container">
    <h2>Услуги</h2>
    <div class="cards" style="margin-top:12px">
      <div class="card">
        <h3>SEO-продвижение</h3>
        <p>Технический аудит, семантика, кластеризация, перелинковка, контент-план, контроль индексации.</p>
      </div>
      <div class="card">
        <h3>Яндекс Директ</h3>
        <p>Стратегии, микроконверсии, отказ от мусорного трафика, правила и A/B, атрибуция.</p>
      </div>
      <div class="card">
        <h3>Сайты с нуля</h3>
        <p>Уникальный UX / UI под задачу, скорость, adaptive-first, корректная схема данных, аналитика.</p>
      </div>
    </div>
  </div>
<div class="neon-sep"></div>
</section>
<section id="process" class="section section-c">
  <div class="container">
    <h2>Как работаю</h2>
    <div class="timeline" style="margin-top:12px">
      <div class="step"><h4>Бриф</h4><p>Цели, ограничения, аудит текущего состояния.</p></div>
      <div class="step"><h4>Сетка & Прототип</h4><p>Структура, навигация, UX-паттерны.</p></div>
      <div class="step"><h4>Дизайн & Контент</h4><p>Тексты, визуал, интерактивы, microcopy.</p></div>
      <div class="step"><h4>Запуск & Рост</h4><p>SEO-процессы, PPC, A/B-тесты, масштабирование.</p></div>
    </div>
  </div>
<div class="neon-sep"></div>
</section>
<section id="pricing" class="section section-d">
  <div class="container">
    <h2>Тарифы</h2>
    <div class="pricing" style="margin-top:12px">
      <div class="price">
        <span class="tag">Старт</span>
        <h3>SEO сопровождение</h3>
        <div class="amount">от 50 000 ₽/мес</div>
        <ul><li>Тех. аудит и план работ</li><li>Семантика и контент-план</li><li>Еженедельные отчёты</li></ul>
      </div>
      <div class="price highlight">
        <span class="tag">Оптимум</span>
        <h3>SEO + PPC</h3>
        <div class="amount">от 120 000 ₽/мес</div>
        <ul><li>SEO процессы + Яндекс Директ</li><li>Сквозная аналитика</li><li>A/B-тесты и оптимизация</li></ul>
      </div>
      <div class="price">
        <span class="tag">Проект</span>
        <h3>Сайт с нуля</h3>
        <div class="amount">от 100 000 ₽</div>
        <ul><li>Уникальный UX/UI и структура</li><li>Скорость и SEO-архитектура</li><li>Подготовка к WordPress</li></ul>
      </div>
    </div>
  </div>
</section>
<section id="calc" class="section section-e">
  <div class="container">
    <h2>Калькулятор бюджета</h2>
    <div class="calc" style="margin-top:12px">
      <div>
        <div class="control">
          <label>SEO ежемесячно <span id="seoOut"></span></label>
          <input id="seoRange" type="range" min="50000" max="200000" step="5000" value="80000" oninput="seoOut.textContent=new Intl.NumberFormat('ru-RU').format(this.value)+' ₽'">
          <script>seoOut.textContent=new Intl.NumberFormat('ru-RU').format(seoRange.value)+' ₽'</script>
        </div>
        <div class="control">
          <label>Разработка сайта (единоразово) <span id="siteOut"></span></label>
          <input id="siteRange" type="range" min="100000" max="600000" step="10000" value="200000" oninput="siteOut.textContent=new Intl.NumberFormat('ru-RU').format(this.value)+' ₽'">
          <script>siteOut.textContent=new Intl.NumberFormat('ru-RU').format(siteRange.value)+' ₽'</script>
        </div>
        <div class="control">
          <label>Ведение контекста/мес <span id="adsOut"></span></label>
          <input id="adsRange" type="range" min="30000" max="150000" step="5000" value="50000" oninput="adsOut.textContent=new Intl.NumberFormat('ru-RU').format(this.value)+' ₽'">
          <script>adsOut.textContent=new Intl.NumberFormat('ru-RU').format(adsRange.value)+' ₽'</script>
        </div>
        <div class="control">
          <label>Сложность проекта</label>
          <div class="seg" id="complexitySeg" role="tablist" aria-label="Сложность проекта">
            <button class="seg-btn active" data-val="1" aria-selected="true" role="tab">Базовая ×1.0</button>
            <button class="seg-btn" data-val="1.2" role="tab">Средняя ×1.2</button>
            <button class="seg-btn" data-val="1.5" role="tab">Высокая ×1.5</button>
          </div>
        </div>
        <div class="control">
          <label>CMS / Архитектура</label>
          <div class="seg" id="cmsSeg" role="tablist" aria-label="CMS / Архитектура">
            <button class="seg-btn active" data-val="1" aria-selected="true" role="tab">WordPress ×1.0</button>
            <button class="seg-btn" data-val="1.15" role="tab">Headless ×1.15</button>
            <button class="seg-btn" data-val="1.3" role="tab">Custom ×1.3</button>
          </div>
        </div>
      </div>
      <div class="output">
        <div class="num" id="totalOut">—</div>
        <div id="breakdown" style="margin-top:8px"></div>
        <p class="note" style="margin-top:8px">Оценка не публичная оферта. Итог зависит от ТЗ, нишевой конкуренции и сроков.</p>
        <button class="btn cta" type="button" id="calcContactBtn" style="margin-top:16px">Получить точную смету</button>
      </div>
    </div>
  </div>
</section>
<section class="section section-f">
  <div class="container">
    <h2>Отзывы</h2>
    <div class="quotes" style="margin-top:12px">
      <div class="quote"><p>«Рост SEO-трафика ×3 за 6 месяцев, заявки ежедневно» — <b>e-commerce</b></p></div>
      <div class="quote"><p>«Сайт грузится за 0.7 c, лиды дешевле на 28%» — <b>услуги</b></p></div>
      <div class="quote"><p>«Сделал понятную аналитику и исправил атрибуцию» — <b>B2B</b></p></div>
    </div>
  </div>
</section>
<section class="section tight section-g">
  <div class="container" style="display:grid;grid-template-columns:.8fr 1.2fr;gap:24px;align-items:center">
    <figure class="figure" data-parallax-speed="0.12">
      <div class="frame">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/mikhail-2.png" alt="Михаил Киселёв — MKProd">
        <div class="floor-fade"></div>
      </div>
      <div class="base-glow"></div>
    </figure>
    <div>
      <h2>Почему со мной удобно</h2>
      <div class="cards" style="margin-top:10px">
        <div class="card"><h3>Один договор — весь комплекс</h3><p>Сайты, SEO, контекст, аналитика — без распыления.</p></div>
        <div class="card"><h3>Коммуникация</h3><p>Лаконично, по делу, в согласованном канале. Напоминания и отчёты по графику.</p></div>
        <div class="card"><h3>Дизайн без шаблона</h3><p>Сетки, неон-акценты, живые поверхности — премиум-ощущение без перегруза.</p></div>
      </div>
    </div>
  </div>
</section>
<section class="section section-h" id="faq">
  <div class="container">
    <h2>FAQ</h2>
    <div class="faq" style="margin-top:12px">
      <details><summary>Сколько времени занимает запуск?</summary><div><p>Прототип — 3–7 дней, дизайн — 7–14, разработка — от 1–3 недель в зависимости от ТЗ.</p></div></details>
      <details><summary>Можно без WordPress?</summary><div><p>Да, делаю Headless/Custom. В шаблоне учтены SEO-требования и высокая скорость.</p></div></details>
      <details><summary>Как формируется стоимость SEO?</summary><div><p>От конкуренции ниши, объёма контента и техработ. Нижняя планка 50 000 ₽/мес.</p></div></details>
<details><summary>Сколько длится поддержка после релиза?</summary><div><p>Гарантийный период — 30 дней на баг-фиксы. Дальше — сопровождение по договорённости (фикс/почасово).</p></div></details>
<details><summary>Можно подключить CRM, 1С или кассу?</summary><div><p>Да. Готовы интегрировать amoCRM/Bitrix24, 1С, кассы, платежи и вебхуки. Это учитывается в ТЗ и смете.</p></div></details>
<details><summary>Как передаются доступы и защищаются данные?</summary><div><p>Доступы — через шифрованные каналы (парольные менеджеры, защищённые чаты). Пароли меняются после работ.</p></div></details>
</div>
  </div>
</section>
<section id="contact" class="section">
  <div class="container contact">
    <div>
      <h2><?php echo esc_html( get_theme_mod('mkprod_contact_title','Готов обсудить ваш проект') ); ?></h2>
      <p><?php echo esc_html( get_theme_mod('mkprod_contact_subtitle','Оставьте контакты — вернусь с первичными идеями и оценкой.') ); ?></p>
      <form id="contactForm" class="input" enctype="multipart/form-data" novalidate>
  <input type="text" name="contact" placeholder="Телефон или Telegram" required>
  <textarea name="message" placeholder="Коротко о проекте..."></textarea>

  <!-- honeypot -->
  <input type="text" name="website" id="website" autocomplete="off" tabindex="-1" style="position:absolute;left:-9999px;opacity:0">

  <div id="dropzone" class="mkp-dropzone" aria-label="Прикрепите файлы">
    <input id="files" name="files[]" type="file" multiple hidden>
    <div class="dz-cta">
      <span class="dz-ico">⬆</span>
      <div>Перетащите файлы сюда или <button type="button" class="dz-btn">выберите</button></div>
      <small>PDF, DOCX, PNG, JPG — до 20 МБ</small>
    </div>
    <ul class="dz-list" id="dzList"></ul>
  </div>

  <button class="btn" type="submit" id="submitBtn">
    <span class="btn-text">Отправить</span>
    <span class="loader" style="display:none;width:14px;height:14px;border:2px solid rgba(255,255,255,.4);border-top-color:#00f0ff;border-radius:50%;animation:spin 0.6s linear infinite"></span>
  </button>
  <div id="formMsg" class="form-msg" style="margin-top:10px;font-size:14px;"></div>
</form>

<div id="successOverlay" class="form-overlay" role="alertdialog" aria-modal="true" aria-hidden="true">
  <div class="form-overlay__content">
    <p class="form-overlay__text">Ваша заявка принята, с Вами свяжутся в ближайшее время. Звонок поступит с номера +79222631802.</p>
    <button type="button" class="btn form-overlay__btn" id="overlayClose">Хорошо</button>
  </div>
</div>

<style>
@keyframes spin {to{transform:rotate(360deg)}}
@keyframes neonGlow {
  0%{filter:drop-shadow(0 0 3px #00f0ff);}
  50%{filter:drop-shadow(0 0 8px #7a5cff);}
  100%{filter:drop-shadow(0 0 3px #00f0ff);}
}
@keyframes gradientFlow {
  0%{background-position:0% 50%;}
  100%{background-position:100% 50%;}
}
.form-msg.success{color:#00f0ff}
.form-msg.error{color:#ff5c5c}

/* неоновый прогресс */
.progress-wrap{margin-top:10px;height:4px;width:100%;background:rgba(255,255,255,.08);
  border-radius:999px;overflow:hidden;display:none}
.progress-bar{height:100%;width:0%;
  background:linear-gradient(90deg,#00f0ff,#7a5cff);
  background-size:200% 100%;
  animation:gradientFlow 3s linear infinite;
  box-shadow:0 0 8px rgba(0,240,255,.6);
  transition:width .25s ease;}
.btn .btn-text{animation:neonGlow 2s ease-in-out infinite alternate;}
.form-overlay{position:fixed;inset:0;display:none;align-items:center;justify-content:center;padding:20px;background:rgba(4,8,15,.82);backdrop-filter:blur(4px);z-index:1000;}
.form-overlay.show{display:flex;}
.form-overlay__content{max-width:420px;width:100%;background:rgba(12,18,30,.95);border:1px solid rgba(0,240,255,.4);border-radius:20px;padding:32px;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,.45);}
.form-overlay__text{margin:0 0 24px;font-size:18px;line-height:1.4;color:#fff;}
.form-overlay__btn{width:100%;justify-content:center;border:none;background:linear-gradient(90deg,var(--neon),var(--neon-2));color:#020813;font-weight:700;box-shadow:0 12px 36px rgba(0,240,255,.35),0 0 0 1px rgba(0,240,255,.18) inset;}
.form-overlay__btn:hover{transform:translateY(-2px);box-shadow:0 16px 42px rgba(0,240,255,.45),0 0 0 1px rgba(0,240,255,.25) inset;}
.form-overlay__btn:focus-visible{outline:2px solid rgba(255,255,255,.6);outline-offset:3px;}
</style>

<script>
const form = document.getElementById('contactForm');
const inputFiles = document.getElementById('files');
const dzBtn = document.querySelector('.dz-btn');
const dzList = document.getElementById('dzList');
const btn = document.getElementById('submitBtn');
const btnText = btn.querySelector('.btn-text');
const loader = btn.querySelector('.loader');
const msgBox = document.getElementById('formMsg');
const successOverlay = document.getElementById('successOverlay');
const overlayClose = document.getElementById('overlayClose');

const closeOverlay = ()=>{
  successOverlay.classList.remove('show');
  successOverlay.setAttribute('aria-hidden','true');
  btn.focus();
};

const showOverlay = ()=>{
  successOverlay.classList.add('show');
  successOverlay.setAttribute('aria-hidden','false');
  overlayClose.focus();
};

overlayClose.addEventListener('click', closeOverlay);
successOverlay.addEventListener('click', e=>{
  if(e.target === successOverlay){
    closeOverlay();
  }
});
document.addEventListener('keydown', e=>{
  if(e.key === 'Escape' && successOverlay.classList.contains('show')){
    closeOverlay();
  }
});

// создаём неоновую полосу
const progressWrap = document.createElement('div');
progressWrap.className = 'progress-wrap';
const progressBar = document.createElement('div');
progressBar.className = 'progress-bar';
progressWrap.appendChild(progressBar);
btn.insertAdjacentElement('afterend', progressWrap);

// --- выбор файлов ---
dzBtn.addEventListener('click', e=>{
  inputFiles.value = '';          // сброс, чтобы повторное открытие работало
  inputFiles.click();
});

inputFiles.addEventListener('change', ()=>{
  dzList.innerHTML = '';
  for (const f of inputFiles.files){
    const li = document.createElement('li');
    li.textContent = f.name;
    dzList.appendChild(li);
  }
});

// --- отправка ---
form.addEventListener('submit', async e=>{
  e.preventDefault();
  msgBox.textContent = '';
  msgBox.className = 'form-msg';

  // honeypot
  if (document.getElementById('website').value.trim() !== '') return;

  // проверка файлов
  for (const f of inputFiles.files) {
    if (f.size > 20 * 1024 * 1024) {
      msgBox.textContent = '❌ Файл ' + f.name + ' превышает 20 МБ';
      msgBox.classList.add('error');
      return;
    }
  }

  // визуальный статус
  btn.disabled = true;
  btnText.style.display='none';
  loader.style.display='inline-block';
  progressWrap.style.display='block';
  progressBar.style.width='0%';

  const data = new FormData(form);
  const xhr = new XMLHttpRequest();
  xhr.open('POST', '<?php echo get_template_directory_uri(); ?>/send_telegram.php', true);

  xhr.upload.onprogress = e=>{
    if(e.lengthComputable){
      const percent = (e.loaded / e.total * 100).toFixed(1);
      progressBar.style.width = percent + '%';
    }
  };

  xhr.onload = ()=>{
    loader.style.display='none';
    btnText.style.display='inline';
    btn.disabled = false;
    progressBar.style.width='100%';
    setTimeout(()=>{progressWrap.style.display='none';progressBar.style.width='0%'},1000);

    try {
      const json = JSON.parse(xhr.responseText);
      if(json.ok){
        form.reset(); dzList.innerHTML='';
        msgBox.textContent = '';
        msgBox.className = 'form-msg';
        showOverlay();
      } else {
        msgBox.textContent = '❌ Ошибка: '+(json.msg || 'не удалось отправить.');
        msgBox.classList.add('error');
      }
    } catch {
      msgBox.textContent = '❌ Ошибка отправки.';
      msgBox.classList.add('error');
    }
  };

  xhr.onerror = ()=>{
    loader.style.display='none';
    btnText.style.display='inline';
    btn.disabled = false;
    msgBox.textContent = '❌ Ошибка сети.';
    msgBox.classList.add('error');
  };

  xhr.send(data);
});
</script>
    </div>
    <div class="card mkp-contacts" mkp-contacts>
      <h3>Контакты</h3>
<svg class="mkp-contacts-wave" viewBox="0 0 240 60" preserveAspectRatio="none" aria-hidden="true"><defs><linearGradient id="mkpG" x1="0" x2="1"><stop offset="0" stop-color="#00f0ff"/><stop offset="1" stop-color="#7a5cff"/></linearGradient><filter id="mkpGlow"><feGaussianBlur stdDeviation="3" result="b"/><feMerge><feMergeNode in="b"/><feMergeNode in="SourceGraphic"/></feMerge></filter></defs><path d="M0,38 C40,18 80,48 120,26 C160,8 200,38 240,18" fill="none" stroke="url(#mkpG)" stroke-width="3" filter="url(#mkpGlow)"/></svg>
      <p><b>MKProd</b> · Команда</p>
      <ul style="list-style:none;padding:0;margin:10px 0 0;display:flex;flex-direction:column;gap:8px">
        <?php if ( get_theme_mod('mkprod_vk') ): ?>
          <li><a class="badge" href="<?php echo esc_url( get_theme_mod('mkprod_vk') ); ?>" target="_blank" rel="noopener"><span class="ico">🔗</span> VK — сообщество MKProd</a></li>
        <?php endif; ?>
        <?php if ( get_theme_mod('mkprod_telegram') ): ?>
          <li><a class="badge" href="<?php echo esc_url( get_theme_mod('mkprod_telegram') ); ?>" target="_blank" rel="noopener"><span class="ico">✈</span> Telegram — @mkprod</a></li>
        <?php endif; ?>
        <?php if ( get_theme_mod('mkprod_email') ): ?>
          <li><a class="badge" href="mailto:<?php echo antispambot( get_theme_mod('mkprod_email') ); ?>" target="_blank" rel="noopener"><span class="ico">📧</span> <?php echo antispambot( get_theme_mod('mkprod_email') ); ?></a></li>
        <?php endif; ?>
        <?php if ( get_theme_mod('mkprod_phone') ): ?>
          <li><a class="badge" href="tel:<?php echo preg_replace('/[^0-9+]/','', get_theme_mod('mkprod_phone') ); ?>" target="_blank" rel="noopener"><span class="ico">📞</span> <?php echo get_theme_mod('mkprod_phone'); ?></a></li>
        <?php endif; ?>
      </ul>
      <p class="note" style="margin-top:12px">Во время интеграции подставлю реальные ссылки и подключу форму к почте/CRM.</p>
    </div>
  </div>
</section>
<footer class="footer">
  <div class="container" style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap">
    <div class="logo" style="gap:10px">
      <?php if ( get_theme_mod('mkprod_logo') ): ?>
        <img src="<?php echo esc_url( get_theme_mod('mkprod_logo') ); ?>" alt="MKProd" style="width:auto;height:28px">
      <?php else: ?>
        <div class="logo-mark" aria-hidden="true" style="width:28px;height:28px"></div>
        <span style="font-weight:700">MKProd</span>
      <?php endif; ?>
    </div>
    <div class="soc">
      <?php if ( get_theme_mod('mkprod_vk') ): ?>
        <a href="<?php echo esc_url( get_theme_mod('mkprod_vk') ); ?>" aria-label="VK" target="_blank"><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/icons/vk.svg" width="18" height="18"></a>
      <?php endif; ?>
      <a href="#" aria-label="YouTube"><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/icons/youtube.svg" width="18" height="18"></a>
      <?php if ( get_theme_mod('mkprod_telegram') ): ?>
        <a href="<?php echo esc_url( get_theme_mod('mkprod_telegram') ); ?>" aria-label="Telegram" target="_blank"><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/icons/telegram.svg" width="18" height="18"></a>
      <?php endif; ?>
    </div>
    <div class="note">
      <?php echo wp_kses_post( get_theme_mod('mkprod_copyright','© '.date('Y').' MKProd. Дизайн и разработка — Михаил Киселёв.') ); ?>
    </div>
  </div>
</footer>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/app.js"></script>
</body>
</html>

<?php get_footer(); ?>