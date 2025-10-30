<?php
/*
Template Name: SEO Promotion Landing
*/
get_header();

$home_url = esc_url( home_url('/') );
$page_id  = get_queried_object_id();

$fetch = static function( $key, $default = '' ) use ( $page_id ) {
  $value = '';
  if ( function_exists( 'get_field' ) ) {
    $value = get_field( $key, $page_id );
  }
  if ( $value === '' || $value === null ) {
    $value = get_post_meta( $page_id, $key, true );
  }
  if ( $value === '' || $value === null ) {
    return $default;
  }
  return $value;
};

$allowed_title_tags = array(
  'span' => array( 'class' => true ),
  'strong' => array(),
  'em' => array(),
  'br' => array(),
);
$allowed_video_tags = array(
  'iframe' => array(
    'src' => true,
    'width' => true,
    'height' => true,
    'title' => true,
    'allow' => true,
    'allowfullscreen' => true,
    'frameborder' => true,
    'loading' => true,
    'referrerpolicy' => true,
    'sandbox' => true,
    'style' => true,
    'name' => true,
  ),
  'div' => array(
    'class' => true,
    'style' => true,
  ),
  'span' => array(
    'class' => true,
    'style' => true,
  ),
  'p' => array(
    'class' => true,
    'style' => true,
  ),
  'a' => array(
    'href' => true,
    'target' => true,
    'rel' => true,
    'class' => true,
    'style' => true,
  ),
  'img' => array(
    'src' => true,
    'alt' => true,
    'class' => true,
    'width' => true,
    'height' => true,
    'style' => true,
  ),
);

$theme_uri = trailingslashit( get_template_directory_uri() );

$hero_kicker_raw = (string) $fetch( 'mkp_hero_kicker', '' );
$hero_title_raw  = (string) $fetch( 'mkp_hero_title', '' );
$hero_lead_raw   = (string) $fetch( 'mkp_hero_lead', '' );
$hero_badges_raw = (string) $fetch( 'mkp_hero_badges', '' );
$hero_cta_text   = (string) $fetch( 'mkp_hero_cta_text', 'Обсудить проект' );
$hero_cta_link   = (string) $fetch( 'mkp_hero_cta_link', '#contact' );
$hero_video_raw  = (string) $fetch( 'mkp_hero_video_embed', '' );

$hero_kicker = $hero_kicker_raw !== '' ? esc_html( $hero_kicker_raw ) : 'MKProd · SEO-продвижение сайтов';
$hero_title_default = 'Продвигаю сайты в ТОП-10 Яндекса и Google<br><span class="hero-accent">с гарантией роста заявок</span>';
$hero_title = $hero_title_raw !== ''
  ? wp_kses( $hero_title_raw, $allowed_title_tags )
  : wp_kses( $hero_title_default, $allowed_title_tags );
if ( '' === trim( wp_strip_all_tags( $hero_title ) ) ) {
  $hero_title = wp_kses( $hero_title_default, $allowed_title_tags );
}
$hero_lead = $hero_lead_raw !== ''
  ? wp_kses_post( $hero_lead_raw )
  : 'Комплексное SEO: аудит, стратегия, контент, юзабилити и аналитика. Наращиваю органику в сложных нишах без рискованных схем.';
$hero_lead_html = $hero_lead ? wpautop( $hero_lead ) : '';

$badge_lines = array();
if ( $hero_badges_raw !== '' ) {
  $badge_lines = array_filter( array_map( 'trim', preg_split( "/\r\n|\n|\r/", $hero_badges_raw ) ) );
}
if ( empty( $badge_lines ) ) {
  $badge_lines = array(
    'SEO под ключ',
    'Аудит сайта',
    'ТОП-10 в Яндекс и Google',
    'Прозрачная аналитика',
  );
}

$hero_cta_text = esc_html( $hero_cta_text !== '' ? $hero_cta_text : 'Обсудить проект' );
$hero_cta_link = $hero_cta_link !== '' ? esc_url( $hero_cta_link ) : '#contact';
$hero_video    = $hero_video_raw !== '' ? wp_kses( $hero_video_raw, $allowed_video_tags ) : '';
$hero_video_placeholder = current_user_can( 'edit_post', $page_id )
  ? 'Добавьте код плеера YouTube или RuTube в поле «Видеоплеер героя», чтобы показать ролик.'
  : 'Скоро здесь появится видео-кейс MKProd.';

$top_cards = $fetch( 'mkp_top_cards', array() );
if ( ! is_array( $top_cards ) || empty( $top_cards ) ) {
  $top_cards = array(
    array(
      'title'       => 'Анализ ниши и конкурентов',
      'description' => 'Подбираем стратегию, семантику и точки роста для конкретной ниши. Составляем карту запросов и бенчмарки KPI.',
      'icon'        => $theme_uri . 'assets/images/seo-dalle-analysis.svg',
    ),
    array(
      'title'       => 'Техническое SEO',
      'description' => 'Устраняем ошибки, ускоряем загрузку, оптимизируем индексацию и сканирование. Контроль внедрения чек-листов.',
      'icon'        => $theme_uri . 'assets/images/seo-dalle-technical.svg',
    ),
    array(
      'title'       => 'Контент и структура',
      'description' => 'Создаём релевантные тексты, усиливаем перелинковку и повышаем вовлечённость. Обновляем ключевые посадочные.',
      'icon'        => $theme_uri . 'assets/images/seo-dalle-content.svg',
    ),
    array(
      'title'       => 'Поведенческие факторы и аналитика',
      'description' => 'Настраиваем цели, строим отчёты и сценарии. Сайт растёт по позициям, а клиенты остаются и покупают.',
      'icon'        => $theme_uri . 'assets/images/seo-dalle-analytics.svg',
    ),
  );
}

$calc_base_price = (float) $fetch( 'mkp_calc_base_price', 50000 );
if ( $calc_base_price <= 0 ) {
  $calc_base_price = 50000;
}

$calc_site_types = $fetch( 'mkp_calc_site_types', array() );
if ( ! is_array( $calc_site_types ) || empty( $calc_site_types ) ) {
  $calc_site_types = array(
    array( 'label' => 'Обычный', 'multiplier' => 1.0 ),
    array( 'label' => 'Молодой сайт', 'multiplier' => 1.4 ),
  );
}

$calc_complexities = $fetch( 'mkp_calc_complexities', array() );
if ( ! is_array( $calc_complexities ) || empty( $calc_complexities ) ) {
  $calc_complexities = array(
    array( 'label' => 'Стандарт', 'multiplier' => 1.0 ),
    array( 'label' => 'Региональная конкуренция', 'multiplier' => 1.3 ),
    array( 'label' => 'Сложная ниша', 'multiplier' => 1.5 ),
    array( 'label' => 'Высококонкурентный рынок', 'multiplier' => 2.0 ),
  );
}

$calc_breakdown = $fetch( 'mkp_calc_breakdown', array() );
if ( is_string( $calc_breakdown ) && $calc_breakdown !== '' ) {
  $lines = array_filter( array_map( 'trim', preg_split( "/\r\n|\n|\r/", $calc_breakdown ) ) );
  $parsed = array();
  foreach ( $lines as $line ) {
    $parts = array_map( 'trim', explode( '|', $line ) );
    if ( count( $parts ) >= 2 ) {
      $parsed[] = array( 'label' => $parts[0], 'amount' => (float) $parts[1] );
    }
  }
  if ( ! empty( $parsed ) ) {
    $calc_breakdown = $parsed;
  }
}
if ( ! is_array( $calc_breakdown ) || empty( $calc_breakdown ) ) {
  $calc_breakdown = array(
    array( 'label' => 'SEO-аудит', 'amount' => 15000 ),
    array( 'label' => 'Контент', 'amount' => 20000 ),
    array( 'label' => 'Ссылки', 'amount' => 15000 ),
  );
}

$advantages = $fetch( 'mkp_advantages_cards', array() );
if ( ! is_array( $advantages ) || empty( $advantages ) ) {
  $advantages = array(
    array(
      'title'       => 'Работаем только по белым методам',
      'description' => 'Без рискованных сеток и санкций. Соблюдаем гайды поисковых систем и юридические требования.',
      'image'       => $theme_uri . 'assets/images/seo-dalle-shield.svg',
    ),
    array(
      'title'       => 'Премиальный подход и прозрачная отчётность',
      'description' => 'Показываем в цифрах, что сделано и что даёт рост. Доступ к дашбордам 24/7 и регулярные созвоны.',
      'image'       => $theme_uri . 'assets/images/seo-dalle-dash.svg',
    ),
    array(
      'title'       => 'Личный контроль Михаила Киселёва',
      'description' => 'Все ключевые решения — лично. Команда MKProd подключается под конкретные задачи и отвечает сроком.',
      'image'       => $theme_uri . 'assets/images/seo-dalle-lead.svg',
    ),
    array(
      'title'       => 'Реальные отзывы клиентов',
      'description' => 'Показываем кейсы и открытые отзывы. Демонстрируем динамику позиций и экономический эффект.',
      'image'       => $theme_uri . 'assets/images/seo-dalle-reviews.svg',
    ),
  );
}

$privacy_url = '';
if ( function_exists( 'get_field' ) ) {
  $privacy_url = (string) get_field( 'mkp_policy_link', 'option' );
}
if ( $privacy_url === '' ) {
  $privacy_url = (string) $fetch( 'mkp_policy_link', '' );
}
if ( $privacy_url === '' && function_exists( 'get_privacy_policy_url' ) ) {
  $privacy_url = get_privacy_policy_url();
}
$privacy_url = $privacy_url ? esc_url( $privacy_url ) : '';
?>
<div class="scroll-progress" aria-hidden="true"><span class="scroll-progress__bar"></span></div>
<header class="header header--seo">
  <div class="container row">
    <div class="row logo">
      <?php if ( get_theme_mod( 'mkprod_logo' ) ) : ?>
        <img src="<?php echo esc_url( get_theme_mod( 'mkprod_logo' ) ); ?>" alt="MKProd" style="height:28px" />
      <?php else : ?>
        <div class="logo-mark" aria-hidden="true"></div>
        <span>MKProd</span>
      <?php endif; ?>
    </div>
    <nav class="nav">
      <a href="#approach">Стратегия</a>
      <a href="#calc">Калькулятор</a>
      <a href="#advantages">Почему мы</a>
      <a href="#contact" class="btn cta">Обсудить проект</a>
    </nav>
  </div>
</header>
<main class="seo-main">
  <section class="hero section seo-hero" id="top">
    <div class="grid" data-parallax-speed="0.15"></div>
    <div class="decor">
      <div class="orb"></div>
      <div class="orb alt"></div>
      <div class="line"></div>
    </div>
    <svg class="neon-wave" viewBox="0 0 1440 200" preserveAspectRatio="none" aria-hidden="true">
      <defs>
        <linearGradient id="seoGradient" x1="0" x2="1">
          <stop offset="0" stop-color="#00f0ff" />
          <stop offset="1" stop-color="#7a5cff" />
        </linearGradient>
        <filter id="seoGlow">
          <feGaussianBlur stdDeviation="4" result="blur" />
          <feMerge>
            <feMergeNode in="blur" />
            <feMergeNode in="SourceGraphic" />
          </feMerge>
        </filter>
      </defs>
      <path d="M0,120 C240,60 480,180 720,110 C960,40 1200,140 1440,70 L1440,200 L0,200 Z" fill="url(#seoGradient)" opacity="0.14"></path>
      <path class="wave-line" d="M0,120 C240,60 480,180 720,110 C960,40 1200,140 1440,70" stroke="url(#seoGradient)" stroke-width="3" fill="none" filter="url(#seoGlow)" />
    </svg>
    <div class="container hero-wrap">
      <div class="seo-hero__text" data-reveal>
        <div class="kicker"><?php echo $hero_kicker; ?></div>
        <h1 class="seo-hero__title"><?php echo $hero_title; ?></h1>
        <?php if ( $hero_lead_html ) : ?>
          <div class="lead lead-rich"><?php echo $hero_lead_html; ?></div>
        <?php endif; ?>
        <?php if ( ! empty( $badge_lines ) ) : ?>
          <div class="badges seo-badges">
            <?php foreach ( $badge_lines as $badge ) : ?>
              <span class="badge" data-reveal><?php echo esc_html( $badge ); ?></span>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
        <?php if ( $hero_cta_text ) : ?>
          <p class="seo-hero__cta">
            <a href="<?php echo $hero_cta_link; ?>" class="btn cta"><?php echo $hero_cta_text; ?></a>
          </p>
        <?php endif; ?>
      </div>
      <div class="seo-video-card" data-parallax-speed="0.08" data-reveal>
        <div class="seo-video-card__glow" aria-hidden="true"></div>
        <div class="seo-video-card__body">
          <?php if ( $hero_video ) : ?>
            <div class="video-slot video-slot--embed seo-video-card__slot"><?php echo $hero_video; ?></div>
          <?php else : ?>
            <div class="video-slot video-slot--placeholder seo-video-card__slot" aria-hidden="true">
              <div class="video-placeholder">
                <span class="video-placeholder__icon" aria-hidden="true">▶</span>
                <p class="video-placeholder__text"><?php echo esc_html( $hero_video_placeholder ); ?></p>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
  <div class="section-divider" aria-hidden="true"></div>
  <section class="section seo-approach" id="approach">
    <div class="container">
      <div class="section-head">
        <h2>Как мы выходим в ТОП</h2>
        <p class="section-subtitle">Под каждую нишу собираем стратегию: анализируем, внедряем, проверяем рост органики и продаж.</p>
      </div>
      <div class="seo-steps">
        <?php foreach ( $top_cards as $card ) :
          $title = isset( $card['title'] ) ? $card['title'] : '';
          $desc  = isset( $card['description'] ) ? $card['description'] : '';
          $icon  = isset( $card['icon'] ) ? $card['icon'] : '';
          ?>
          <article class="seo-step" data-reveal>
            <div class="seo-step__visual">
              <div class="seo-step__shine" aria-hidden="true"></div>
              <div class="seo-step__icon">
                <?php if ( $icon ) : ?>
                  <img src="<?php echo esc_url( $icon ); ?>" alt="" loading="lazy" />
                <?php else : ?>
                  <span aria-hidden="true">✦</span>
                <?php endif; ?>
              </div>
            </div>
            <?php if ( $title ) : ?>
              <h3><?php echo esc_html( $title ); ?></h3>
            <?php endif; ?>
            <?php if ( $desc ) : ?>
              <p><?php echo esc_html( $desc ); ?></p>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <div class="section-divider" aria-hidden="true"></div>
  <section class="section seo-calc" id="calc" data-seo-calc data-base-price="<?php echo esc_attr( $calc_base_price ); ?>">
    <div class="container">
      <div class="section-head">
        <h2>Калькулятор стоимости SEO</h2>
        <p class="section-subtitle">Мгновенно оцените стартовый бюджет: итог меняется от типа проекта и конкурентности ниши.</p>
      </div>
      <div class="seo-calc__grid">
        <div class="seo-calc__controls" data-reveal>
          <div class="seo-calc__base">
            <span class="seo-calc__label">Базовая цена</span>
            <span class="seo-calc__value"><?php echo number_format( $calc_base_price, 0, ',', ' ' ); ?> ₽</span>
          </div>
          <fieldset class="seo-calc__field">
            <legend>Тип сайта</legend>
            <div class="seg seg--neo" role="tablist">
              <?php foreach ( $calc_site_types as $index => $type ) :
                $label = isset( $type['label'] ) ? $type['label'] : '';
                $mult  = isset( $type['multiplier'] ) ? (float) $type['multiplier'] : 1;
                $active = 0 === $index ? ' active' : '';
                ?>
                <button type="button" class="seg-btn<?php echo $active; ?>" role="tab" data-type="site" data-multiplier="<?php echo esc_attr( $mult ); ?>"<?php echo 0 === $index ? ' aria-selected="true"' : ''; ?>><?php echo esc_html( $label ); ?></button>
              <?php endforeach; ?>
            </div>
          </fieldset>
          <fieldset class="seo-calc__field">
            <legend>Сложность ниши</legend>
            <div class="seg seg--neo" role="tablist">
              <?php foreach ( $calc_complexities as $index => $item ) :
                $label = isset( $item['label'] ) ? $item['label'] : '';
                $mult  = isset( $item['multiplier'] ) ? (float) $item['multiplier'] : 1;
                $active = 0 === $index ? ' active' : '';
                ?>
                <button type="button" class="seg-btn<?php echo $active; ?>" role="tab" data-type="complexity" data-multiplier="<?php echo esc_attr( $mult ); ?>"<?php echo 0 === $index ? ' aria-selected="true"' : ''; ?>><?php echo esc_html( $label ); ?></button>
              <?php endforeach; ?>
            </div>
          </fieldset>
          <p class="note">Финальная смета зависит от текущего состояния сайта, состояния контента и требований по аналитике.</p>
          <button type="button" class="btn cta seo-calc__cta" data-scroll-to="#contact">Получить расчёт в Telegram</button>
        </div>
        <div class="seo-calc__result" data-reveal>
          <div class="seo-calc__result-card">
            <div class="seo-calc__result-glow" aria-hidden="true"></div>
            <p class="seo-calc__hint">Прогноз бюджета</p>
            <p class="seo-calc__total" data-total><?php echo number_format( $calc_base_price, 0, ',', ' ' ); ?> ₽</p>
            <div class="seo-calc__breakdown" data-breakdown>
              <?php foreach ( $calc_breakdown as $line ) :
                $label = isset( $line['label'] ) ? $line['label'] : '';
                $amount = isset( $line['amount'] ) ? (float) $line['amount'] : 0;
                ?>
                <div class="seo-calc__breakdown-row" data-default-amount="<?php echo esc_attr( $amount ); ?>">
                  <span><?php echo esc_html( $label ); ?></span>
                  <strong><?php echo number_format( $amount, 0, ',', ' ' ); ?> ₽</strong>
                </div>
              <?php endforeach; ?>
            </div>
            <p class="seo-calc__disclaimer">Пересчёт выполняется в реальном времени: базовая цена × коэффициенты.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="section-divider" aria-hidden="true"></div>
  <section class="section seo-why" id="advantages">
    <div class="container">
      <div class="section-head">
        <h2>Почему выбирают MKProd</h2>
        <p class="section-subtitle">Каждый проект ведём как собственный: прозрачные метрики, контроль качества и вовлечённость.</p>
      </div>
      <div class="seo-advantages">
        <?php foreach ( $advantages as $adv ) :
          $title = isset( $adv['title'] ) ? $adv['title'] : '';
          $desc  = isset( $adv['description'] ) ? $adv['description'] : '';
          $image = isset( $adv['image'] ) ? $adv['image'] : ( isset( $adv['icon'] ) ? $adv['icon'] : '' );
          ?>
          <article class="seo-adv-card" data-reveal>
            <div class="seo-adv-card__visual" aria-hidden="true">
              <div class="seo-adv-card__glow"></div>
              <?php if ( $image ) : ?>
                <img src="<?php echo esc_url( $image ); ?>" alt="" loading="lazy" />
              <?php else : ?>
                <span>✶</span>
              <?php endif; ?>
            </div>
            <div class="seo-adv-card__body">
              <?php if ( $title ) : ?>
                <h3><?php echo esc_html( $title ); ?></h3>
              <?php endif; ?>
              <?php if ( $desc ) : ?>
                <p><?php echo esc_html( $desc ); ?></p>
              <?php endif; ?>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <div class="section-divider" aria-hidden="true"></div>
  <section id="contact" class="section seo-contact">
    <div class="container">
      <div class="seo-contact__grid">
        <div class="seo-contact__intro" data-reveal>
          <h2><?php echo esc_html( get_theme_mod( 'mkprod_contact_title', 'Готов обсудить ваш проект' ) ); ?></h2>
          <p><?php echo esc_html( get_theme_mod( 'mkprod_contact_subtitle', 'Оставьте контакты — вернусь с первичными идеями и оценкой.' ) ); ?></p>
          <ul class="seo-contact__benefits">
            <li>Созвон с Михаилом Киселёвым в ближайшие 24 часа</li>
            <li>Разбор текущего сайта и быстрых точек роста</li>
            <li>Пошаговый план внедрения SEO-улучшений</li>
          </ul>
        </div>
        <div class="seo-contact__panel">
          <div class="card mkp-contacts" data-reveal>
            <h3>Контакты</h3>
            <svg class="mkp-contacts-wave" viewBox="0 0 240 60" preserveAspectRatio="none" aria-hidden="true"><defs><linearGradient id="mkpG" x1="0" x2="1"><stop offset="0" stop-color="#00f0ff"/><stop offset="1" stop-color="#7a5cff"/></linearGradient><filter id="mkpGlow"><feGaussianBlur stdDeviation="3" result="b"/><feMerge><feMergeNode in="b"/><feMergeNode in="SourceGraphic"/></feMerge></filter></defs><path d="M0,38 C40,18 80,48 120,26 C160,8 200,38 240,18" fill="none" stroke="url(#mkpG)" stroke-width="3" filter="url(#mkpGlow)"/></svg>
            <p><b>MKProd</b> · Команда</p>
            <ul class="seo-contact__links">
              <?php if ( get_theme_mod( 'mkprod_vk' ) ) : ?>
                <li><a class="badge" href="<?php echo esc_url( get_theme_mod( 'mkprod_vk' ) ); ?>" target="_blank" rel="noopener"><span class="ico">🔗</span> VK — сообщество MKProd</a></li>
              <?php endif; ?>
              <?php if ( get_theme_mod( 'mkprod_telegram' ) ) : ?>
                <li><a class="badge" href="<?php echo esc_url( get_theme_mod( 'mkprod_telegram' ) ); ?>" target="_blank" rel="noopener"><span class="ico">✈</span> Telegram — @mkprod</a></li>
              <?php endif; ?>
              <?php if ( get_theme_mod( 'mkprod_email' ) ) : ?>
                <li><a class="badge" href="mailto:<?php echo antispambot( get_theme_mod( 'mkprod_email' ) ); ?>" target="_blank" rel="noopener"><span class="ico">📧</span> <?php echo antispambot( get_theme_mod( 'mkprod_email' ) ); ?></a></li>
              <?php endif; ?>
              <?php if ( get_theme_mod( 'mkprod_phone' ) ) : ?>
                <li><a class="badge" href="tel:<?php echo preg_replace( '/[^0-9+]/', '', get_theme_mod( 'mkprod_phone' ) ); ?>" target="_blank" rel="noopener"><span class="ico">📞</span> <?php echo get_theme_mod( 'mkprod_phone' ); ?></a></li>
              <?php endif; ?>
            </ul>
            <p class="note">Во время интеграции подставлю реальные ссылки и подключу форму к почте/CRM.</p>
            <div class="mkp-contacts-grid"></div>
          </div>
          <div class="seo-contact__form" data-reveal>
            <div class="seo-contact__form-glow" aria-hidden="true"></div>
            <form id="contactForm" class="input" enctype="multipart/form-data" novalidate data-global-form="1" data-endpoint="<?php echo esc_url( get_template_directory_uri() . '/send_telegram.php' ); ?>">
              <input type="text" name="name" placeholder="Имя" required>
              <input type="text" name="contact" placeholder="Телефон или Telegram" required>
              <textarea name="message" placeholder="Расскажите о проекте…"></textarea>
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
              <div class="seo-contact__submit">
                <button class="btn" type="submit" id="submitBtn">
                  <span class="btn-text">Отправить</span>
                  <span class="loader" style="display:none;width:14px;height:14px;border:2px solid rgba(255,255,255,.4);border-top-color:#00f0ff;border-radius:50%;animation:spin 0.6s linear infinite"></span>
                </button>
                <div class="progress-wrap" aria-hidden="true" hidden>
                  <div class="progress-bar"></div>
                </div>
              </div>
              <div id="formMsg" class="form-msg" style="margin-top:10px;font-size:14px;"></div>
            </form>
          </div>
        </div>
      </div>
      <div id="successOverlay" class="form-overlay" role="alertdialog" aria-modal="true" aria-hidden="true">
        <div class="form-overlay__content">
          <p class="form-overlay__text">Ваша заявка принята, с Вами свяжутся в ближайшее время. Звонок поступит с номера +79222631802.</p>
          <button type="button" class="btn form-overlay__btn" id="overlayClose">Хорошо</button>
        </div>
      </div>
    </div>
  </section>
  <?php if ( have_posts() ) : ?>
    <div class="section-divider" aria-hidden="true"></div>
    <section class="section seo-article">
      <div class="container">
        <?php while ( have_posts() ) : the_post(); ?>
          <article <?php post_class('seo-article__content'); ?>>
            <?php the_content(); ?>
          </article>
        <?php endwhile; ?>
      </div>
    </section>
  <?php endif; ?>
</main>
<footer class="footer footer--seo">
  <div class="container footer__grid">
    <div class="logo" style="gap:10px">
      <?php if ( get_theme_mod( 'mkprod_logo' ) ) : ?>
        <img src="<?php echo esc_url( get_theme_mod( 'mkprod_logo' ) ); ?>" alt="MKProd" style="width:auto;height:28px" />
      <?php else : ?>
        <div class="logo-mark" aria-hidden="true" style="width:28px;height:28px"></div>
        <span style="font-weight:700">MKProd</span>
      <?php endif; ?>
    </div>
    <div class="footer__links">
      <div class="soc">
        <?php if ( get_theme_mod( 'mkprod_vk' ) ) : ?>
          <a href="<?php echo esc_url( get_theme_mod( 'mkprod_vk' ) ); ?>" aria-label="VK" target="_blank" rel="noopener"><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/icons/vk.svg" width="18" height="18"></a>
        <?php endif; ?>
        <?php if ( get_theme_mod( 'mkprod_telegram' ) ) : ?>
          <a href="<?php echo esc_url( get_theme_mod( 'mkprod_telegram' ) ); ?>" aria-label="Telegram" target="_blank" rel="noopener"><img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/icons/telegram.svg" width="18" height="18"></a>
        <?php endif; ?>
      </div>
      <?php if ( $privacy_url ) : ?>
        <a class="footer__policy" href="<?php echo $privacy_url; ?>" target="_blank" rel="noopener">Политика конфиденциальности</a>
      <?php endif; ?>
    </div>
    <div class="note">
      <?php echo wp_kses_post( get_theme_mod( 'mkprod_copyright', '© ' . date( 'Y' ) . ' MKProd. Дизайн и разработка — Михаил Киселёв.' ) ); ?>
    </div>
  </div>
</footer>
<?php get_footer(); ?>
