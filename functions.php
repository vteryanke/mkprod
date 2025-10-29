<?php
// === Подключение стилей и скриптов ===
function mkprod_enqueue_assets() {
  wp_enqueue_style('mkprod-style', get_template_directory_uri() . '/assets/css/style.css', array(), null);
  wp_enqueue_script('mkprod-app', get_template_directory_uri() . '/assets/js/app.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'mkprod_enqueue_assets');


// === Настройки темы через кастомайзер ===
function mkprod_customize_register($wp_customize) {

  // === Секция MKProd ===
  $wp_customize->add_section('mkprod_options', array(
    'title'    => 'Настройки MKProd',
    'priority' => 30,
  ));

  // --- META TITLE ---
  $wp_customize->add_setting('mkprod_meta_title', array(
    'default' => 'MKProd — SEO, Контекст и Создание сайтов | Михаил Киселёв',
  ));
  $wp_customize->add_control('mkprod_meta_title', array(
    'label' => 'Meta Title',
    'section' => 'mkprod_options',
    'type' => 'text',
  ));

  // --- META DESCRIPTION ---
  $wp_customize->add_setting('mkprod_meta_desc', array(
    'default' => 'MKProd — студийный уровень: SEO-продвижение, настройка рекламы Яндекс Директ и разработка сайтов с нуля под бизнес-задачи.',
  ));
  $wp_customize->add_control('mkprod_meta_desc', array(
    'label' => 'Meta Description',
    'section' => 'mkprod_options',
    'type' => 'textarea',
  ));

  // --- Имя (для JSON-LD и шапки) ---
  $wp_customize->add_setting('mkprod_name', array(
    'default' => 'Михаил Киселёв',
  ));
  $wp_customize->add_control('mkprod_name', array(
    'label' => 'Имя (используется в JSON-LD и тексте)',
    'section' => 'mkprod_options',
    'type' => 'text',
  ));

  // --- Логотип ---
  $wp_customize->add_setting('mkprod_logo');
  $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'mkprod_logo', array(
    'label' => 'Логотип',
    'section' => 'mkprod_options',
    'settings' => 'mkprod_logo',
  )));

  // --- Телефон ---
  $wp_customize->add_setting('mkprod_phone', array('default' => '+7 (999) 000-00-00'));
  $wp_customize->add_control('mkprod_phone', array(
    'label' => 'Телефон',
    'section' => 'mkprod_options',
    'type' => 'text',
  ));

  // --- Telegram ---
  $wp_customize->add_setting('mkprod_telegram', array('default' => 'https://t.me/mkprod'));
  $wp_customize->add_control('mkprod_telegram', array(
    'label' => 'Ссылка на Telegram',
    'section' => 'mkprod_options',
    'type' => 'url',
  ));

  // --- ВКонтакте ---
  $wp_customize->add_setting('mkprod_vk', array('default' => 'https://vk.com/mkprod'));
  $wp_customize->add_control('mkprod_vk', array(
    'label' => 'Ссылка на ВКонтакте',
    'section' => 'mkprod_options',
    'type' => 'url',
  ));

  // --- Email ---
  $wp_customize->add_setting('mkprod_email', array('default' => 'info@mkprod.ru'));
  $wp_customize->add_control('mkprod_email', array(
    'label' => 'Email',
    'section' => 'mkprod_options',
    'type' => 'email',
  ));

  // --- Заголовок формы ---
  $wp_customize->add_setting('mkprod_contact_title', array(
    'default' => 'Готов обсудить ваш проект',
  ));
  $wp_customize->add_control('mkprod_contact_title', array(
    'label' => 'Заголовок блока контактов',
    'section' => 'mkprod_options',
    'type' => 'text',
  ));

  // --- Подзаголовок формы ---
  $wp_customize->add_setting('mkprod_contact_subtitle', array(
    'default' => 'Оставьте контакты — вернусь с первичными идеями и оценкой.',
  ));
  $wp_customize->add_control('mkprod_contact_subtitle', array(
    'label' => 'Подзаголовок блока контактов',
    'section' => 'mkprod_options',
    'type' => 'textarea',
  ));

  // --- Копирайт ---
  $wp_customize->add_setting('mkprod_copyright', array(
    'default' => '© ' . date('Y') . ' MKProd. Дизайн и разработка — Михаил Киселёв.',
  ));
  $wp_customize->add_control('mkprod_copyright', array(
    'label' => 'Копирайт (футер)',
    'section' => 'mkprod_options',
    'type' => 'text',
  ));
}
add_action('customize_register', 'mkprod_customize_register');
?>