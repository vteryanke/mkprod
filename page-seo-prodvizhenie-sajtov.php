<?php
/*
Template Name: SEO Promotion Landing
*/
get_header();
$home_url   = esc_url( home_url('/') );
$page_id    = get_queried_object_id();

$hero_kicker_raw = get_post_meta( $page_id, 'mkp_hero_kicker', true );
$hero_title_raw  = get_post_meta( $page_id, 'mkp_hero_title', true );
$hero_lead_raw   = get_post_meta( $page_id, 'mkp_hero_lead', true );
$hero_badges_raw = get_post_meta( $page_id, 'mkp_hero_badges', true );
$hero_cta_text   = get_post_meta( $page_id, 'mkp_hero_cta_text', true );
$hero_cta_link   = get_post_meta( $page_id, 'mkp_hero_cta_link', true );
$hero_video_raw  = get_post_meta( $page_id, 'mkp_hero_video_embed', true );

$hero_kicker = $hero_kicker_raw !== '' ? esc_html( $hero_kicker_raw ) : sprintf( 'MKProd · %s', esc_html( get_theme_mod( 'mkprod_name', 'Михаил Киселёв' ) ) );

$hero_title_default = 'SEO-продвижение сайтов<br><span class="hero-accent">для сложных отраслей и ниш</span>';
$allowed_title_tags = array(
  'span'   => array( 'class' => true ),
  'strong' => array(),
  'em'     => array(),
  'br'     => array(),
);
$hero_title = wp_kses( $hero_title_raw !== '' ? $hero_title_raw : ( get_the_title( $page_id ) ?: $hero_title_default ), $allowed_title_tags );
if ( '' === trim( wp_strip_all_tags( $hero_title ) ) ) {
  $hero_title = wp_kses( $hero_title_default, $allowed_title_tags );
}

$hero_lead = $hero_lead_raw !== ''
  ? wp_kses_post( $hero_lead_raw )
  : 'Поднимаю органический трафик и заявки у каталогов, маркетплейсов и сервисов с длинным циклом сделки. Сильная семантика, техоптимизация и рост конверсии без шаблонных решений.';
$hero_lead_html = $hero_lead ? wpautop( $hero_lead ) : '';

$badge_lines = array();
if ( $hero_badges_raw !== '' ) {
  $badge_lines = array_filter( array_map( 'trim', preg_split( "/\r\n|\n|\r/", $hero_badges_raw ) ) );
}
if ( empty( $badge_lines ) ) {
  $badge_lines = array(
    'Сайты-каталоги',
    'Автодилеры',
    'Спецтехника',
    'Аренда техники',
    'Промоборудование',
    'Производители',
    'Спецодежда',
    'Алкомаркеты',
    'Онлайн-игры',
    'Онлайн-кинотеатры',
    'Онлайн-школы',
    'Онлайн-библиотеки',
  );
}

$hero_cta_text = $hero_cta_text !== '' ? esc_html( $hero_cta_text ) : 'Обсудить проект';
$hero_cta_link = $hero_cta_link !== '' ? esc_url( $hero_cta_link ) : '#contact';

$allowed_video_tags = array(
  'iframe' => array(
    'src'                => true,
    'width'              => true,
    'height'             => true,
    'title'              => true,
    'allow'              => true,
    'allowfullscreen'    => true,
    'frameborder'        => true,
    'loading'            => true,
    'referrerpolicy'     => true,
    'sandbox'            => true,
    'style'              => true,
    'name'               => true,
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
    'href'   => true,
    'target' => true,
    'rel'    => true,
    'class'  => true,
    'style'  => true,
  ),
  'img' => array(
    'src'    => true,
    'alt'    => true,
    'class'  => true,
    'width'  => true,
    'height' => true,
    'style'  => true,
  ),
);
$hero_video = $hero_video_raw !== '' ? wp_kses( $hero_video_raw, $allowed_video_tags ) : '';
$hero_video_placeholder = current_user_can( 'edit_post', $page_id )
  ? 'Добавьте код плеера YouTube или RuTube в поле «Видеоплеер героя», чтобы показать ролик.'
  : 'Здесь появится видео после обновления страницы.';
?>
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
      <a href="<?php echo $home_url; ?>#services">Услуги</a>
      <a href="<?php echo $home_url; ?>#process">Процесс</a>
      <a href="<?php echo $home_url; ?>#pricing">Тарифы</a>
      <a href="<?php echo $home_url; ?>#calc">Калькулятор</a>
      <a href="#contact" class="btn cta">Связаться</a>
    </nav>
  </div>
</header>
<main>
  <section class="hero section">
    <div class="grid" data-parallax-speed="0.15"></div>
    <div class="decor"><div class="orb"></div><div class="orb alt"></div><div class="line"></div></div>
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
      <path d="M0,120 C240,60 480,180 720,110 C960,40 1200,140 1440,70 L1440,200 L0,200 Z" fill="url(#seoGradient)" opacity="0.15"></path>
      <path class="wave-line" d="M0,120 C240,60 480,180 720,110 C960,40 1200,140 1440,70" stroke="url(#seoGradient)" stroke-width="3" fill="none" filter="url(#seoGlow)" />
    </svg>
    <div class="container hero-wrap">
      <div>
        <div class="kicker"><?php echo $hero_kicker; ?></div>
        <h1><?php echo $hero_title; ?></h1>
        <?php if ( $hero_lead_html ) : ?>
          <div class="lead lead-rich"><?php echo $hero_lead_html; ?></div>
        <?php endif; ?>
        <?php if ( ! empty( $badge_lines ) ) : ?>
          <div class="badges">
            <?php foreach ( $badge_lines as $badge ) : ?>
              <span class="badge"><?php echo esc_html( $badge ); ?></span>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
        <?php if ( $hero_cta_text ) : ?>
          <p style="margin-top:18px">
            <a href="<?php echo $hero_cta_link; ?>" class="btn cta"><?php echo $hero_cta_text; ?></a>
          </p>
        <?php endif; ?>
      </div>
      <div class="hero-card" data-parallax-speed="0.08">
        <?php if ( $hero_video ) : ?>
          <div class="video-slot video-slot--embed"><?php echo $hero_video; ?></div>
        <?php else : ?>
          <div class="video-slot video-slot--placeholder" aria-hidden="true">
            <div class="video-placeholder">
              <span class="video-placeholder__icon" aria-hidden="true">▶</span>
              <p class="video-placeholder__text"><?php echo esc_html( $hero_video_placeholder ); ?></p>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>
  <section id="contact" class="section">
    <div class="container contact">
      <div>
        <h2><?php echo esc_html( get_theme_mod('mkprod_contact_title','Готов обсудить проект') ); ?></h2>
        <p><?php echo esc_html( get_theme_mod('mkprod_contact_subtitle','Оставьте контакты — вернусь с первичными идеями и оценкой.') ); ?></p>
        <form id="contactForm" class="input" enctype="multipart/form-data" novalidate>
          <input type="text" name="contact" placeholder="Телефон или Telegram" required>
          <textarea name="message" placeholder="Коротко о проекте..."></textarea>
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
          .progress-wrap{margin-top:10px;height:4px;width:100%;background:rgba(255,255,255,.08);border-radius:999px;overflow:hidden;display:none}
          .progress-bar{height:100%;width:0%;background:linear-gradient(90deg,#00f0ff,#7a5cff);background-size:200% 100%;animation:gradientFlow 3s linear infinite;box-shadow:0 0 8px rgba(0,240,255,.6);transition:width .25s ease;}
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
          const allowedExtensions = ['jpg','jpeg','png','webp','gif','pdf','doc','docx','txt','rtf','odt','ppt','pptx','xls','xlsx','csv','zip','rar','7z','gz','tar','mp3','wav','ogg','m4a','aac','mp4','mov','avi','mkv'];
          const allowedExtSet = new Set(allowedExtensions);
          const getSelectedFiles = ()=>{
            if (typeof window.mkpGetFiles === 'function') {
              const buf = window.mkpGetFiles();
              return Array.isArray(buf) ? buf.slice() : [];
            }
            if (!inputFiles || !inputFiles.files) return [];
            return Array.from(inputFiles.files);
          };
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
          const progressWrap = document.createElement('div');
          progressWrap.className = 'progress-wrap';
          const progressBar = document.createElement('div');
          progressBar.className = 'progress-bar';
          progressWrap.appendChild(progressBar);
          btn.insertAdjacentElement('afterend', progressWrap);
          dzBtn.addEventListener('click', e=>{
            inputFiles.value = '';
            inputFiles.click();
          });
          if (inputFiles){
            inputFiles.addEventListener('change', ()=>{
              if (typeof window.mkpGetFiles === 'function') return;
              dzList.innerHTML = '';
              for (const f of inputFiles.files){
                const li = document.createElement('li');
                li.textContent = f.name;
                dzList.appendChild(li);
              }
            });
          }
          form.addEventListener('submit', async e=>{
            e.preventDefault();
            msgBox.textContent = '';
            msgBox.className = 'form-msg';
            if (document.getElementById('website').value.trim() !== '') return;
            const filesToCheck = getSelectedFiles();
            for (const f of filesToCheck) {
              if (f.size > 20 * 1024 * 1024) {
                msgBox.textContent = '❌ Файл ' + f.name + ' превышает 20 МБ';
                msgBox.classList.add('error');
                return;
              }
              const parts = f.name.split('.');
              const ext = parts.length > 1 ? parts.pop().toLowerCase() : '';
              if (ext && !allowedExtSet.has(ext)) {
                msgBox.textContent = '❌ Файл ' + f.name + ' имеет неподдерживаемый формат';
                msgBox.classList.add('error');
                return;
              }
            }
            btn.disabled = true;
            btnText.style.display='none';
            loader.style.display='inline-block';
            progressWrap.style.display='block';
            progressBar.style.width='0%';
            const data = new FormData(form);
            if (typeof window.mkpGetFiles === 'function') {
              const buffered = getSelectedFiles();
              data.delete('files[]');
              buffered.forEach(file => {
                data.append('files[]', file, file.name);
              });
            }
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
        <div class="mkp-contacts-grid"></div>
      </div>
    </div>
  </section>
  <section class="section article-section">
    <div class="container">
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <article <?php post_class('seo-article'); ?>>
          <?php the_content(); ?>
        </article>
      <?php endwhile; endif; ?>
    </div>
  </section>
</main>
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
<?php get_footer(); ?>
