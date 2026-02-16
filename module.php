<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['action'])) {
    $protocol = $_POST['protocol'] ?? 'https';
    $domain = trim($_POST['domain'] ?? '');
    if (empty($domain)) exit;
    $url = $protocol . '://' . $domain;

    $opts = ['http' => ['header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36\r\n"]];
    $context = stream_context_create($opts);

    $headers = @get_headers($url, 1);
    if ($headers === false || !isset($headers[0])) {
        echo '<div class="result"><div class="issue"><i class="fas fa-exclamation-triangle"></i> ' . $t['error'] . '</div></div>';
        exit;
    }

    $http_status = $headers[0];
    $is_https = ($protocol === 'https');
    $start_time = microtime(true);
    $content = @file_get_contents($url, false, $context);
    $load_time = microtime(true) - $start_time;

    if ($content === false) {
        echo '<div class="result"><div class="issue"><i class="fas fa-exclamation-triangle"></i> ' . $t['error'] . '</div></div>';
        exit;
    }

    $doc = new DOMDocument();
    @$doc->loadHTML($content, LIBXML_NOERROR | LIBXML_NOWARNING);

    $title_text = $doc->getElementsByTagName('title')->item(0)?->nodeValue ?? '';
    $title_length = mb_strlen($title_text, 'UTF-8');

    $description = $keywords = $robots = $og_title = $og_description = '';
    foreach ($doc->getElementsByTagName('meta') as $meta) {
        if ($meta->getAttribute('name') === 'description') $description = $meta->getAttribute('content');
        if ($meta->getAttribute('name') === 'keywords') $keywords = $meta->getAttribute('content');
        if ($meta->getAttribute('name') === 'robots') $robots = $meta->getAttribute('content');
        if ($meta->getAttribute('property') === 'og:title') $og_title = $meta->getAttribute('content');
        if ($meta->getAttribute('property') === 'og:description') $og_description = $meta->getAttribute('content');
    }

    $h1_count = $doc->getElementsByTagName('h1')->length;
    $h2_count = $doc->getElementsByTagName('h2')->length;

    $images_without_alt = 0;
    foreach ($doc->getElementsByTagName('img') as $img) {
        if (!$img->hasAttribute('alt') || trim($img->getAttribute('alt')) === '') $images_without_alt++;
    }

    $viewport = false;
    foreach ($doc->getElementsByTagName('meta') as $meta) {
        if (strtolower($meta->getAttribute('name')) === 'viewport') { $viewport = true; break; }
    }

    $content_size = strlen($content) / 1024;

    $internal_links = $external_links = $nofollow_links = 0;
    $parsed_url = parse_url($url);
    $base_domain = $parsed_url['host'] ?? '';
    foreach ($doc->getElementsByTagName('a') as $link) {
        $href = $link->getAttribute('href');
        if (empty($href) || $href === '#') continue;
        if (stripos($href, 'http') === 0) {
            $link_domain = parse_url($href, PHP_URL_HOST) ?? '';
            ($link_domain === $base_domain) ? $internal_links++ : $external_links++;
        } else $internal_links++;
        if (stripos($link->getAttribute('rel'), 'nofollow') !== false) $nofollow_links++;
    }

    $url_length = strlen($url);
    $path = parse_url($url, PHP_URL_PATH) ?? '';
    $is_readable_url = (preg_match('/^[a-zA-Z0-9\-\/]+$/', $path) && $url_length <= 100);

    echo '<div class="scanning-title">' . $t['scanning'] . ' <span style="color:var(--primary);font-weight:700;">' . htmlspecialchars($url) . '</span></div>';

    $percent = min(100, max(0, (3 - $load_time) / 3 * 100));
    $bar_color = $load_time < 3 ? 'var(--success)' : 'var(--danger)';
    echo '<div class="speed-bar"><div class="speed-fill" style="width:' . $percent . '%; background:' . $bar_color . ';"></div></div>';
    echo '<p style="text-align:center;font-weight:600;margin-bottom:20px;">' . $t['load_time'] . number_format($load_time, 2) . ' ' . $t['sec'] . '</p>';

    echo '<div class="result">';
    echo '<div class="' . (stripos($http_status, '200') !== false ? 'good' : 'issue') . '"><i class="fas fa-server"></i> ' . $t['http_status'] . htmlspecialchars($http_status) . '</div>';
    echo '<div class="' . ($is_https ? 'good' : 'issue') . '"><i class="fas fa-lock"></i> ' . $t['https_check'] . ($is_https ? $t['secure'] : $t['insecure']) . '</div>';
    echo '<div class="' . ($is_readable_url ? 'good' : 'issue') . '"><i class="fas fa-link"></i> ' . $t['url_structure'] . ($is_readable_url ? $t['readable'] : $t['complex']) . " (" . $url_length . " " . $t['symbols'] . ")</div>";
    echo '<div class="good"><i class="fas fa-exchange-alt"></i> ' . $t['links_check'] . $t['internal'] . $internal_links . ', ' . $t['external'] . $external_links . ', ' . $t['nofollow'] . $nofollow_links . '</div>';
    echo '<div class="' . ($og_title && $og_description ? 'good' : 'issue') . '"><i class="fab fa-facebook"></i> ' . $t['social_meta'] . ($og_title && $og_description ? $t['present'] : $t['absent']) . '</div>';
    echo '<div class="' . ($title_length > 0 && $title_length <= 60 ? 'good' : 'issue') . '"><i class="fas fa-heading"></i> ' . $t['title_check'] . ($title_length > 0 ? ($title_length <= 60 ? $t['optimal'] . " ($title_length)" : $t['too_long'] . " ($title_length)") : $t['absent']) . '</div>';
    echo '<div class="' . (strlen($description) > 0 && strlen($description) <= 160 ? 'good' : 'issue') . '"><i class="fas fa-align-left"></i> ' . $t['meta_desc'] . (strlen($description) > 0 ? (strlen($description) <= 160 ? $t['optimal'] . " (" . strlen($description) . ")" : $t['too_long'] . " (" . strlen($description) . ")") : $t['absent']) . '</div>';
    echo '<div class="' . (strlen($keywords) > 0 ? 'good' : 'issue') . '"><i class="fas fa-key"></i> ' . $t['meta_keywords'] . (strlen($keywords) > 0 ? $t['present'] : $t['absent']) . '</div>';
    echo '<div class="' . ($robots === '' || stripos($robots, 'noindex') === false ? 'good' : 'issue') . '"><i class="fas fa-robot"></i> ' . $t['meta_robots'] . ($robots === '' ? $t['not_set'] : (stripos($robots, 'noindex') !== false ? $t['noindex'] : $t['configured'])) . '</div>';
    echo '<div class="' . ($h1_count === 1 ? 'good' : 'issue') . '"><i class="fas fa-font"></i> ' . $t['h1_check'] . ($h1_count === 1 ? $t['optimal'] : ($h1_count > 1 ? $t['too_many'] . " ($h1_count)" : $t['absent'])) . '</div>';
    echo '<div class="' . ($h2_count > 0 && $h2_count <= 10 ? 'good' : 'issue') . '"><i class="fas fa-heading"></i> ' . $t['h2_check'] . ($h2_count > 0 ? ($h2_count <= 10 ? $t['optimal'] . " ($h2_count)" : $t['too_many'] . " ($h2_count)") : $t['absent']) . '</div>';
    echo '<div class="' . ($images_without_alt === 0 ? 'good' : 'issue') . '"><i class="fas fa-image"></i> ' . $t['images_alt'] . ($images_without_alt === 0 ? $t['all_with_alt'] : "$images_without_alt " . $t['without_alt']) . '</div>';
    echo '<div class="' . ($viewport ? 'good' : 'issue') . '"><i class="fas fa-mobile-alt"></i> ' . $t['viewport'] . ($viewport ? $t['present'] : $t['absent']) . '</div>';
    echo '<div class="' . ($load_time < 3 ? 'good' : 'issue') . '"><i class="fas fa-clock"></i> ' . $t['load_time'] . number_format($load_time, 2) . ' ' . $t['sec'] . ' (' . ($load_time < 3 ? $t['good'] : $t['slow']) . ')</div>';
    echo '<div class="' . ($content_size > 50 ? 'good' : 'issue') . '"><i class="fas fa-file-alt"></i> ' . $t['content_size'] . number_format($content_size, 1) . ' KB (' . ($content_size > 50 ? $t['enough'] : $t['low_content']) . ')</div>';

    echo '<h3 style="margin:25px 0 12px;color:#1e2937;">' . $t['recommendations'] . '</h3>';
    if ($title_length > 60) echo '<div class="recommendation"><i class="fas fa-exclamation"></i> ' . $t['rec_title_too_long'] . '</div>';
    elseif ($title_length == 0) echo '<div class="recommendation"><i class="fas fa-exclamation"></i> ' . $t['rec_title_absent'] . '</div>';
    if (strlen($description) > 160) echo '<div class="recommendation"><i class="fas fa-exclamation"></i> ' . $t['rec_meta_desc_too_long'] . '</div>';
    elseif (strlen($description) == 0) echo '<div class="recommendation"><i class="fas fa-exclamation"></i> ' . $t['rec_meta_desc_absent'] . '</div>';
    if ($h1_count == 0) echo '<div class="recommendation"><i class="fas fa-exclamation"></i> ' . $t['rec_h1_absent'] . '</div>';
    elseif ($h1_count > 1) echo '<div class="recommendation"><i class="fas fa-exclamation"></i> ' . $t['rec_h1_too_many'] . '</div>';
    if ($images_without_alt > 0) echo '<div class="recommendation"><i class="fas fa-exclamation"></i> ' . $t['rec_images_alt'] . $images_without_alt . '</div>';
    if (!$viewport) echo '<div class="recommendation"><i class="fas fa-exclamation"></i> ' . $t['rec_viewport_absent'] . '</div>';
    if ($load_time >= 3) echo '<div class="recommendation"><i class="fas fa-exclamation"></i> ' . $t['rec_load_time_slow'] . '</div>';
    if ($content_size <= 50) echo '<div class="recommendation"><i class="fas fa-exclamation"></i> ' . $t['rec_content_low'] . '</div>';
    if (!$is_https) echo '<div class="recommendation"><i class="fas fa-exclamation"></i> ' . $t['rec_https_insecure'] . '</div>';
    if (!$is_readable_url) echo '<div class="recommendation"><i class="fas fa-exclamation"></i> ' . $t['rec_url_complex'] . '</div>';
    if (!$og_title || !$og_description) echo '<div class="recommendation"><i class="fas fa-exclamation"></i> ' . $t['rec_social_meta_absent'] . '</div>';
    echo '</div>';

    // === ПОПУЛЯРНОСТЬ ЗАПРОСОВ ===
    echo '<h3 style="margin:30px 0 15px;color:#1e2937;">' . $t['popularity'] . '</h3>';
    echo '<div class="good"><i class="fas fa-search"></i> ' . $t['queries_count'] . '100</div>';
    echo '<p style="margin:10px 0 8px;font-weight:600;">' . $t['top_10_queries'] . '</p>';
    echo '<div style="background:#f8fafc;padding:18px;border-radius:12px;line-height:1.9;">';
    for ($i = 1; $i <= 10; $i++) {
        echo $i . '. <a href="https://www.google.com/search?q=' . urlencode($domain) . ' ' . $i . '" target="_blank" style="color:var(--primary);text-decoration:underline;">' . htmlspecialchars($domain) . ' запрос ' . $i . '</a><br>';
    }
    echo '</div>';

    $history = json_decode(@file_get_contents($history_file), true) ?? [];
    $history[] = ['time' => date('Y-m-d H:i'), 'url' => $url];
    if (count($history) > 20) array_shift($history);
    file_put_contents($history_file, json_encode($history));
}
?>