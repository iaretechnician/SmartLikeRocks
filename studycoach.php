<?php
/**
 * Minimal PHP chat page that hits OpenAI Responses API
 * and uses file_search with your existing vector store.
 * 
 * Requirements: PHP 7.4+ with cURL enabled.
 * Set env vars: OPENAI_API_KEY, VECTOR_STORE_ID
 * Docs (for reference): 
 * - Responses API: https://platform.openai.com/docs/api-reference/responses
 * - File Search:   https://platform.openai.com/docs/guides/tools-file-search
 */

session_start();

// ---- Config ----
$OPENAI_API_KEY   = asst_RB7XAZhk7QayVKKLNMOT6QJA;     // or put your key here (not recommended)
$VECTOR_STORE_ID  = vs_68a74fc8fbd88191bdadf75a2b4f3be0;    // your existing vector store id
$MODEL            = 'gpt-4o-mini';                      // good balance; change if you prefer
$API_URL          = 'https://api.openai.com/v1/responses';

// Basic guardrails
if (!$OPENAI_API_KEY || !$VECTOR_STORE_ID) {
  die("Missing OPENAI_API_KEY or VECTOR_STORE_ID. Set as environment variables.");
}

// ---- Simple session chat history ----
if (!isset($_SESSION['history'])) {
  $_SESSION['history'] = [];
}

// Reset session if requested
if (isset($_GET['reset'])) {
  $_SESSION['history'] = [];
  header("Location: ".$_SERVER['PHP_SELF']);
  exit;
}

// Handle submit
$userMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $userMessage = trim($_POST['message'] ?? '');
  if ($userMessage !== '') {
    $_SESSION['history'][] = ['role' => 'user', 'content' => $userMessage];
  }
}

// ---- Build prompt ----
$systemInstruction = <<<SYS
You are my certification study coach. Use ONLY the attached PDFs via file_search.
- Ask me one question at a time unless I say "explain" or ask to review.
- After each answer I give, tell me Correct/Incorrect and explain briefly.
- Always include source doc title + page number in explanations.
- Track topics I miss and, when I ask "summary", output a short reading plan with exact pages.
- If you are unsure or the PDFs don’t cover it, say so and point me to the closest section.
SYS;

$input = [
  ['role' => 'system', 'content' => $systemInstruction],
];

// Append session history (user & assistant turns)
foreach ($_SESSION['history'] as $turn) {
  $input[] = [
    'role'    => $turn['role'],
    'content' => $turn['content']
  ];
}

// If user just opened the page (no message yet), give a friendly starter
if (empty($_SESSION['history'])) {
  $input[] = ['role' => 'assistant', 'content' => 'Tell me the exam/topic to start with, or say “quiz me”.'];
}

// ---- Call OpenAI Responses API ----
function call_openai_responses($apiKey, $apiUrl, $model, $vectorStoreId, $inputItems) {
  $payload = [
    'model' => $model,
    'input' => $inputItems,
    'tools' => [
      [
        'type' => 'file_search',
        'vector_store_ids' => [$vectorStoreId]
      ]
    ],
    // You can request retrieval metadata to surface citations in UI if you wish:
    'include' => ['output[*].file_search_call.search_results'],
  ];

  $ch = curl_init($apiUrl);
  //----------------------------------------------------
    // --- Make TLS trust work by pointing to a real CA bundle ---
  $ca = getenv('CURL_CA_BUNDLE') ?: getenv('SSL_CERT_FILE');
  $candidates = array_filter([
    $ca,
    '/etc/ssl/certs/ca-certificates.crt',   // Debian/Ubuntu
    '/etc/pki/tls/certs/ca-bundle.crt',     // RHEL/CentOS/Alma/Rocky
    '/etc/ssl/cert.pem',                    // macOS/Homebrew PHP or some *nix
    '/usr/local/share/certs/ca-root-nss.crt', // FreeBSD
    'C:\\Windows\\System32\\curl-ca-bundle.crt', // Windows
    'C:\\Windows\\curl-ca-bundle.crt'
  ], fn($p) => $p && file_exists($p));

  if ($candidates) {
    curl_setopt($ch, CURLOPT_CAINFO, $candidates[0]);   // use the first that exists
  } else {
    // last-resort: try a hashed certs directory if it exists
    if (is_dir('/etc/ssl/certs')) {
      curl_setopt($ch, CURLOPT_CAPATH, '/etc/ssl/certs');
    }
  }

  
  //---------------------------------------------------
  
  
  curl_setopt_array($ch, [
    CURLOPT_HTTPHEADER => [
      'Content-Type: application/json',
      'Authorization: Bearer ' . $apiKey,
    ],
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($payload),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 90,
  ]);
  $raw = curl_exec($ch);
  $err = curl_error($ch);
  $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  if ($err) {
    return ['error' => "cURL error: $err"];
  }
  if ($code >= 400) {
    return ['error' => "HTTP $code: $raw"];
  }

  $json = json_decode($raw, true);
  if (!$json) {
    return ['error' => "Invalid JSON from API."];
  }

  // Prefer the convenience field if present:
  if (isset($json['output_text'])) {
    return ['text' => $json['output_text'], 'raw' => $json];
  }

  // Fallback: concatenate any text in output items
  $text = '';
  if (isset($json['output']) && is_array($json['output'])) {
    foreach ($json['output'] as $item) {
      // Many responses include a nested 'content' array with text segments
      if (isset($item['content']) && is_array($item['content'])) {
        foreach ($item['content'] as $c) {
          if (($c['type'] ?? '') === 'output_text' && isset($c['text'])) {
            $text .= $c['text'];
          } elseif (isset($c['text'])) {
            $text .= $c['text'];
          }
        }
      }
    }
  }

  if ($text === '') {
    $text = '[No text output returned]';
  }

  return ['text' => $text, 'raw' => $json];
}

$assistantReply = '';
$apiError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $userMessage !== '') {
  $resp = call_openai_responses($OPENAI_API_KEY, $API_URL, $MODEL, $VECTOR_STORE_ID, $input);
  if (isset($resp['error'])) {
    $apiError = $resp['error'];
    $assistantReply = "Sorry—there was an API error. ($apiError)";
  } else {
    $assistantReply = $resp['text'];
  }
  // Save assistant turn in history
  $_SESSION['history'][] = ['role' => 'assistant', 'content' => $assistantReply];
}

// ---- Simple HTML ----
function e($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Study Coach</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; max-width: 900px; margin: 20px auto; padding: 0 16px; }
      h1 { margin: 0 0 12px; }
      .bar { display:flex; gap:8px; margin: 12px 0 18px; }
      .bar input[type="text"] { flex:1; padding: 11px 12px; border-radius: 10px; border: 1px solid #ccc; }
      .bar button { padding: 11px 16px; border: 1px solid #333; background: #fff; border-radius: 10px; cursor: pointer; }
      .chat { border: 1px solid #e5e5e5; border-radius: 12px; padding: 12px; background: #fafafa; }
      .msg { padding: 10px 12px; border-radius: 10px; margin: 8px 0; white-space: pre-wrap; }
      .user { background: #eef3ff; }
      .assistant { background: #f6f6f6; }
      .meta { color:#666; font-size: 12px; margin: 6px 4px 0; }
      .toprow { display:flex; align-items:center; justify-content:space-between; gap: 12px; }
      .pill { font-size: 12px; background:#222; color:#fff; padding: 2px 8px; border-radius: 999px; }
      .small { font-size: 12px; color: #444; }
    </style>
  </head>
  <body>
    <div class="toprow">
      <h1>Certification Study Coach</h1>
      <div class="pill">Vector Store: <?php echo e(substr($VECTOR_STORE_ID, 0, 12)); ?>…</div>
    </div>
    <div class="small">Type <em>quiz me</em> to start, or ask about a specific module. The assistant cites doc titles + pages.</div>

    <div class="bar">
      <form method="post" style="display:flex; gap:8px; width:100%;">
        <input type="text" name="message" placeholder="Ask a question, answer the quiz, or say 'summary'…" autofocus>
        <button type="submit">Send</button>
      </form>
      <form method="get">
        <button type="submit" name="reset" value="1" title="Clear chat session">Reset</button>
      </form>
    </div>

    <div class="chat">
      <?php foreach ($_SESSION['history'] as $turn): ?>
        <div class="msg <?php echo $turn['role'] === 'user' ? 'user' : 'assistant'; ?>">
          <strong><?php echo $turn['role'] === 'user' ? 'You' : 'Coach'; ?>:</strong>
          <br><?php echo e($turn['content']); ?>
        </div>
      <?php endforeach; ?>
    </div>

    <?php if ($apiError): ?>
      <div class="meta">API error: <?php echo e($apiError); ?></div>
    <?php endif; ?>

    <div class="meta" style="margin-top:10px;">
      Tip: keep your PDFs OCR’d/text-native for best retrieval. Ask the coach to “drill me on <topic>” or “mock exam”.
    </div>
  </body>
</html>
