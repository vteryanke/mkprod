<?php
// === НАСТРОЙКИ ===
$token   = "8201236017:AAFwru71xbKdoqEy_gIIxlhih2ack58b0nk";   // вставь свой токен от @BotFather
$chat_id = "-4989719342";   // ID вашей группы (со знаком минус!)


// === ФУНКЦИЯ ОТПРАВКИ В TELEGRAM ===
function tg_api($method, $params) {
  global $token;
  $url = "https://api.telegram.org/bot{$token}/{$method}";
  $ch = curl_init($url);
  curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $params,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_TIMEOUT => 10,
  ]);
  $res = curl_exec($ch);
  curl_close($ch);
  return $res;
}


// === ДАННЫЕ ИЗ ФОРМЫ ===
$contact = trim($_POST['contact'] ?? '');
$msg     = trim($_POST['message'] ?? '');

if ($contact==='') {
  echo json_encode(['ok'=>false,'msg'=>'Не указан контакт для связи']);
  exit;
}

function mkp_curl_file($path, $mime, $name) {
  if (function_exists('curl_file_create')) {
    return curl_file_create($path, $mime, $name);
  }

  return new CURLFile($path, $mime, $name);
}

// === ТЕКСТ СООБЩЕНИЯ ===
$text  = "📬 <b>Новая заявка с сайта MKProd</b>\n\n";
$text .= "☎ Контакт: {$contact}\n";
if ($msg!=='') $text .= "💬 Сообщение:\n{$msg}\n";

tg_api('sendMessage', [
  'chat_id' => $chat_id,
  'text' => $text,
  'parse_mode' => 'HTML'
]);


// === ОТПРАВКА ПРИКРЕПЛЁННЫХ ФАЙЛОВ ===
if (!empty($_FILES['files']['name'][0])) {
  $uploads = [];
  $maxSize = 20 * 1024 * 1024; // 20 МБ
  $allowedExt = [
    'jpg','jpeg','png','webp','gif',
    'pdf','doc','docx','txt','rtf','odt',
    'ppt','pptx','xls','xlsx','csv',
    'zip','rar','7z','gz','tar',
    'mp3','wav','ogg','m4a','aac',
    'mp4','mov','avi','mkv'
  ];

  $fileCount = count($_FILES['files']['name']);
  for ($i = 0; $i < $fileCount; $i++) {
    $tmp  = $_FILES['files']['tmp_name'][$i];
    $name = $_FILES['files']['name'][$i];
    $size = $_FILES['files']['size'][$i];

    if (!is_uploaded_file($tmp)) continue;
    if ($size > $maxSize) continue;

    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    if ($ext && !in_array($ext, $allowedExt, true)) continue;

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = $finfo ? finfo_file($finfo, $tmp) : null;
    if ($finfo) finfo_close($finfo);
    if (!$mime) $mime = 'application/octet-stream';

    $uploads[] = [
      'tmp'  => $tmp,
      'name' => $name,
      'mime' => $mime
    ];
  }

  if (!empty($uploads)) {
    foreach ($uploads as $file) {
      $cFile = mkp_curl_file($file['tmp'], $file['mime'], $file['name']);

      tg_api('sendDocument', [
        'chat_id'  => $chat_id,
        'caption'  => "📎 {$file['name']}",
        'document' => $cFile
      ]);

      // Небольшая пауза, чтобы не упереться в ограничение Flood control
      usleep(350000);
    }
  }
}

echo json_encode(['ok'=>true,'msg'=>'Отправлено']);
