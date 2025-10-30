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
  $fileCount = count($_FILES['files']['name']);
  for ($i=0; $i<$fileCount; $i++) {
    $tmp  = $_FILES['files']['tmp_name'][$i];
    $name = $_FILES['files']['name'][$i];
    if (!is_uploaded_file($tmp)) continue;
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = finfo_file($finfo, $tmp);
    finfo_close($finfo);

    // допустимые типы
    $allowed = [
  'image/jpeg','image/png','image/webp','image/gif',
  'application/pdf',
  'application/msword',
  'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
  'application/zip','application/x-zip-compressed',
  'audio/mpeg','audio/mp3','audio/wav','audio/x-wav',
  'text/plain'
];
    if (!in_array($mime,$allowed)) continue;

    $cFile = new CURLFile($tmp, $mime, $name);
    $params = [
      'chat_id' => $chat_id,
      'caption' => "📎 {$name}",
      'document' => $cFile
    ];
    tg_api('sendDocument', $params);
  }
}

echo json_encode(['ok'=>true,'msg'=>'Отправлено']);