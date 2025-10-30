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
    CURLOPT_TIMEOUT => 15,
  ]);

  $body = curl_exec($ch);
  $err  = curl_error($ch);
  $code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
  curl_close($ch);

  if ($body === false) {
    return [
      'ok'        => false,
      'error'     => $err ?: 'Curl error',
      'http_code' => $code,
    ];
  }

  $decoded = json_decode($body, true);
  if (!is_array($decoded)) {
    return [
      'ok'        => false,
      'error'     => 'Telegram response decode error',
      'http_code' => $code,
      'raw'       => $body,
    ];
  }

  if (!empty($decoded['ok'])) {
    return [
      'ok'        => true,
      'result'    => $decoded['result'] ?? null,
      'http_code' => $code,
    ];
  }

  return [
    'ok'         => false,
    'error'      => $decoded['description'] ?? 'Telegram error',
    'error_code' => $decoded['error_code'] ?? null,
    'http_code'  => $code,
    'retry_after'=> $decoded['parameters']['retry_after'] ?? null,
    'response'   => $decoded,
  ];
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

function mkp_normalize_file_inputs($files) {
  $normalized = [];

  if (!is_array($files) || !isset($files['name'])) {
    return $normalized;
  }

  $names    = $files['name'];
  $tmpNames = $files['tmp_name'] ?? [];
  $types    = $files['type'] ?? [];
  $errors   = $files['error'] ?? [];
  $sizes    = $files['size'] ?? [];

  if (!is_array($names)) {
    $names    = [$names];
    $tmpNames = [$tmpNames];
    $types    = [$types];
    $errors   = [$errors];
    $sizes    = [$sizes];
  }

  $count = count($names);

  for ($i = 0; $i < $count; $i++) {
    $name = $names[$i];
    if ($name === null || $name === '') {
      continue;
    }

    $error = $errors[$i] ?? UPLOAD_ERR_OK;
    if ($error !== UPLOAD_ERR_OK) {
      continue;
    }

    $tmp = $tmpNames[$i] ?? '';
    if ($tmp === '' || !is_uploaded_file($tmp)) {
      continue;
    }

    $normalized[] = [
      'name' => $name,
      'tmp'  => $tmp,
      'size' => (int)($sizes[$i] ?? 0),
      'type' => $types[$i] ?? '',
    ];
  }

  return $normalized;
}

function tg_log_error($context, $payload) {
  $line = sprintf("%s %s %s\n", date('c'), $context, $payload);
  @file_put_contents(__DIR__ . '/telegram-error.log', $line, FILE_APPEND);
}

function tg_format_caption($name) {
  $caption = "📎 " . $name;

  if (function_exists('mb_strlen') && function_exists('mb_substr')) {
    if (mb_strlen($caption) > 1024) {
      return mb_substr($caption, 0, 1020) . '…';
    }
    return $caption;
  }

  if (strlen($caption) > 1024) {
    return substr($caption, 0, 1020) . '…';
  }

  return $caption;
}

function tg_send_document($chatId, $file, $maxAttempts = 3) {
  $attempt = 0;

  while ($attempt < $maxAttempts) {
    $params = [
      'chat_id'  => $chatId,
      'caption'  => tg_format_caption($file['name']),
      'document' => mkp_curl_file($file['tmp'], $file['mime'], $file['name']),
    ];

    $response = tg_api('sendDocument', $params);

    if (!empty($response['ok'])) {
      usleep(350000);
      return true;
    }

    if (($response['error_code'] ?? null) === 429 && !empty($response['retry_after'])) {
      sleep((int)$response['retry_after']);
      $attempt++;
      continue;
    }

    tg_log_error('sendDocument', json_encode([
      'file'   => $file['name'],
      'error'  => $response['error'] ?? 'unknown',
      'code'   => $response['error_code'] ?? null,
      'http'   => $response['http_code'] ?? null,
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

    return false;
  }

  tg_log_error('sendDocument', json_encode([
    'file'  => $file['name'],
    'error' => 'max attempts exceeded',
  ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

  return false;
}

function tg_send_media_group($chatId, $chunk) {
  $attempt = 0;
  $maxAttempts = 2;

  while ($attempt < $maxAttempts) {
    $params = [
      'chat_id' => $chatId,
    ];
    $media = [];

    foreach ($chunk as $idx => $file) {
      $field = 'file' . $idx;
      $params[$field] = mkp_curl_file($file['tmp'], $file['mime'], $file['name']);

      $item = [
        'type'  => 'document',
        'media' => 'attach://' . $field,
      ];

      if ($idx === 0) {
        $item['caption'] = tg_format_caption($file['name']);
      }

      $media[] = $item;
    }

    $params['media'] = json_encode($media, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    $response = tg_api('sendMediaGroup', $params);

    if (!empty($response['ok'])) {
      usleep(350000);
      return true;
    }

    if (($response['error_code'] ?? null) === 429 && !empty($response['retry_after'])) {
      sleep((int)$response['retry_after']);
      $attempt++;
      continue;
    }

    tg_log_error('sendMediaGroup', json_encode([
      'files'  => array_column($chunk, 'name'),
      'error'  => $response['error'] ?? 'unknown',
      'code'   => $response['error_code'] ?? null,
      'http'   => $response['http_code'] ?? null,
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

    return false;
  }

  tg_log_error('sendMediaGroup', json_encode([
    'files' => array_column($chunk, 'name'),
    'error' => 'max attempts exceeded',
  ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

  return false;
}

// === ТЕКСТ СООБЩЕНИЯ ===
$text  = "📬 <b>Новая заявка с сайта MKProd</b>\n\n";
$text .= "☎ Контакт: {$contact}\n";
if ($msg!=='') $text .= "💬 Сообщение:\n{$msg}\n";

$sendMessage = tg_api('sendMessage', [
  'chat_id'    => $chat_id,
  'text'       => $text,
  'parse_mode' => 'HTML'
]);

if (empty($sendMessage['ok']) && ($sendMessage['error_code'] ?? null) === 429 && !empty($sendMessage['retry_after'])) {
  sleep((int)$sendMessage['retry_after']);
  $sendMessage = tg_api('sendMessage', [
    'chat_id'    => $chat_id,
    'text'       => $text,
    'parse_mode' => 'HTML'
  ]);
}

if (empty($sendMessage['ok'])) {
  tg_log_error('sendMessage', json_encode([
    'error' => $sendMessage['error'] ?? 'unknown',
    'code'  => $sendMessage['error_code'] ?? null,
  ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
  echo json_encode(['ok'=>false,'msg'=>'Не удалось отправить сообщение. Попробуйте позднее.']);
  exit;
}


// === ОТПРАВКА ПРИКРЕПЛЁННЫХ ФАЙЛОВ ===
$sentFiles = 0;
$totalUploads = 0;

$filesField = $_FILES['files'] ?? null;
if ($filesField === null) {
  foreach ($_FILES as $payload) {
    if (!empty($payload['name'])) {
      $filesField = $payload;
      break;
    }
  }
}

if (!empty($filesField)) {
  $rawUploads = mkp_normalize_file_inputs($filesField);

  if (!empty($rawUploads)) {
    $maxSize = 20 * 1024 * 1024; // 20 МБ
    $allowedExt = [
      'jpg','jpeg','png','webp','gif',
      'pdf','doc','docx','txt','rtf','odt',
      'ppt','pptx','xls','xlsx','csv',
      'zip','rar','7z','gz','tar',
      'mp3','wav','ogg','m4a','aac',
      'mp4','mov','avi','mkv'
    ];

    $uploads = [];
    $finfo = function_exists('finfo_open') ? @finfo_open(FILEINFO_MIME_TYPE) : false;

    foreach ($rawUploads as $file) {
      if ($file['size'] > $maxSize) {
        continue;
      }

      $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
      if ($ext && !in_array($ext, $allowedExt, true)) {
        continue;
      }

      $mime = $finfo ? @finfo_file($finfo, $file['tmp']) : null;
      if (!$mime && !empty($file['type'])) {
        $mime = $file['type'];
      }
      if (!$mime) {
        $mime = 'application/octet-stream';
      }

      $uploads[] = [
        'tmp'  => $file['tmp'],
        'name' => $file['name'],
        'mime' => $mime,
      ];
    }

    if ($finfo) {
      finfo_close($finfo);
    }

    if (!empty($uploads)) {
      $totalUploads = count($uploads);
      $chunks = array_chunk($uploads, 10); // Telegram media group ограничен 10 файлами

      foreach ($chunks as $chunk) {
        if (count($chunk) === 1) {
          if (tg_send_document($chat_id, $chunk[0])) {
            $sentFiles++;
          }
          continue;
        }

        if (tg_send_media_group($chat_id, $chunk)) {
          $sentFiles += count($chunk);
          continue;
        }

        foreach ($chunk as $file) {
          if (tg_send_document($chat_id, $file)) {
            $sentFiles++;
          }
        }
      }

      if ($sentFiles < $totalUploads) {
        tg_log_error('attachments', json_encode([
          'total' => $totalUploads,
          'sent'  => $sentFiles,
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        if ($sentFiles === 0) {
          echo json_encode(['ok'=>false,'msg'=>'Заявка отправлена, но файлы прикрепить не удалось.']);
          exit;
        }
      }
    }
  }
}

$responseMsg = 'Отправлено';
if ($totalUploads > 0 && $sentFiles === $totalUploads) {
  $responseMsg = 'Отправлено вместе с файлами';
} elseif ($totalUploads > 0 && $sentFiles > 0 && $sentFiles < $totalUploads) {
  $responseMsg = 'Отправлено, но часть файлов не загрузилась.';
}

echo json_encode(['ok'=>true,'msg'=>$responseMsg]);
