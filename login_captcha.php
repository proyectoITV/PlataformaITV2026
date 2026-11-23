<?php
@ini_set('display_errors', '0');

if (session_status() === PHP_SESSION_NONE) {
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
               (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) ||
               (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');

    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'domain'   => '',
        'secure'   => $isHttps,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

// Caracteres sin ambigüedad visual (se omiten 0, O, 1, I)
$chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
$length = 5;
$code = '';
$maxIndex = strlen($chars) - 1;
for ($i = 0; $i < $length; $i++) {
    $code .= $chars[random_int(0, $maxIndex)];
}

$_SESSION['login_captcha'] = $code;
$_SESSION['login_captcha_time'] = time();

header('Content-Type: image/svg+xml; charset=UTF-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');

$width = 165;
$height = 46;

$svg = '<?xml version="1.0" encoding="UTF-8"?>';
$svg .= '<svg xmlns="http://www.w3.org/2000/svg" width="' . $width . '" height="' . $height . '" viewBox="0 0 ' . $width . ' ' . $height . '" role="img" aria-label="Código de verificación">';
$svg .= '<defs>';
$svg .= '<linearGradient id="cbg" x1="0%" y1="0%" x2="100%" y2="100%">';
$svg .= '<stop offset="0%" stop-color="#fdf8f6"/>';
$svg .= '<stop offset="100%" stop-color="#f3e9e4"/>';
$svg .= '</linearGradient>';
$svg .= '</defs>';
$svg .= '<rect width="' . $width . '" height="' . $height . '" rx="8" fill="url(#cbg)"/>';

// Líneas suaves de interferencia
$lineColors = ['#bc955c', '#990000', '#c9a675', '#b86b73'];
for ($i = 0; $i < 6; $i++) {
    $x1 = random_int(0, 30);
    $y1 = random_int(4, $height - 4);
    $cx = random_int(40, $width - 40);
    $cy = random_int(0, $height);
    $x2 = random_int($width - 30, $width);
    $y2 = random_int(4, $height - 4);
    $color = $lineColors[random_int(0, count($lineColors) - 1)];
    $opacity = number_format(random_int(18, 35) / 100, 2, '.', '');
    $svg .= '<path d="M' . $x1 . ' ' . $y1 . ' Q' . $cx . ' ' . $cy . ' ' . $x2 . ' ' . $y2 . '" stroke="' . $color . '" stroke-width="1.3" fill="none" opacity="' . $opacity . '"/>';
}

// Puntos de ruido
for ($i = 0; $i < 24; $i++) {
    $px = random_int(4, $width - 4);
    $py = random_int(4, $height - 4);
    $r = number_format(random_int(7, 15) / 10, 1, '.', '');
    $color = $lineColors[random_int(0, count($lineColors) - 1)];
    $opacity = number_format(random_int(20, 42) / 100, 2, '.', '');
    $svg .= '<circle cx="' . $px . '" cy="' . $py . '" r="' . $r . '" fill="' . $color . '" opacity="' . $opacity . '"/>';
}

// Caracteres con rotación y desplazamiento controlado
$textColors = ['#6b0f1a', '#8a1520', '#4a0c13', '#7a1c24'];
$fonts = ['Georgia, serif', 'Consolas, monospace', 'Trebuchet MS, sans-serif', 'Verdana, sans-serif'];
for ($i = 0; $i < $length; $i++) {
    $char = htmlspecialchars($code[$i], ENT_XML1, 'UTF-8');
    $x = 20 + ($i * 29) + random_int(-3, 3);
    $y = 31 + random_int(-4, 4);
    $angle = random_int(-16, 16);
    $size = random_int(21, 25);
    $color = $textColors[random_int(0, count($textColors) - 1)];
    $font = $fonts[random_int(0, count($fonts) - 1)];
    $svg .= '<text x="' . $x . '" y="' . $y . '" fill="' . $color . '" font-family="' . $font . '" font-size="' . $size . '" font-weight="700" transform="rotate(' . $angle . ' ' . $x . ' ' . $y . ')" style="user-select:none;">' . $char . '</text>';
}

$svg .= '</svg>';
echo $svg;
