<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>SEO Analyzer</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            max-width: 900px;
            margin: 0 auto;
            padding: 30px;
            background: #f5f7fa;
        }
        .header {
            background: linear-gradient(45deg, #ffb74d, #ff8a65);
            color: white;
            padding: 25px;
            border-radius: 15px 15px 0 0;
            text-align: center;
            margin-bottom: 25px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header h1 {
            margin: 0;
            font-size: 34px;
            font-weight: 500;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.15);
        }
        .slogan {
            font-style: italic;
            font-size: 15px;
            margin-top: 10px;
            color: #fff9f0;
        }
        .container {
            background: white;
            padding: 25px;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .input-group {
            margin-bottom: 25px;
        }
        input[type="text"] {
            width: 70%;
            padding: 12px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            background: #fafafa;
        }
        button {
            padding: 12px 25px;
            background: #ffb74d;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s;
        }
        button:hover {
            background: #ff9800;
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            background: #f9f9f9;
        }
        .good {
            color: #27ae60;
            background: #e8f5e9;
            padding: 8px 12px;
            border-radius: 5px;
            margin: 8px 0;
        }
        .issue {
            color: #c0392b;
            background: #ffebee;
            padding: 8px 12px;
            border-radius: 5px;
            margin: 8px 0;
        }
        .recommendation {
            color: #2980b9;
            background: #e8f0fe;
            padding: 8px 12px;
            border-radius: 5px;
            margin: 8px 0;
            font-style: italic;
        }
        .footer {
            text-align: center;
            margin-top: 25px;
            padding: 20px;
            color: #7f8c8d;
            font-size: 14px;
            border-top: 1px solid #e0e0e0;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .footer a {
            color: #ff8a65;
            text-decoration: none;
            transition: color 0.3s;
        }
        .footer a:hover {
            color: #f4511e;
        }
        .contacts {
            margin: 10px 0;
        }
        .contacts span {
            margin: 0 15px;
        }
        .lang-select {
            margin-top: 15px;
        }
        .help-btn {
            float: right;
            background: #ff8a65;
            padding: 8px 20px;
            margin-bottom: 15px;
            border-radius: 8px;
            transition: background 0.3s;
        }
        .help-btn:hover {
            background: #f4511e;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.4);
        }
        .modal-content {
            background: white;
            margin: 60px auto;
            padding: 25px;
            width: 80%;
            max-width: 650px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            position: relative;
        }
        .close {
            position: absolute;
            right: 25px;
            top: 15px;
            font-size: 28px;
            cursor: pointer;
            color: #95a5a6;
            transition: color 0.3s;
        }
        .close:hover {
            color: #2c3e50;
        }
        .tips {
            background: #f1f8e9;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }
        select {
            padding: 8px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            background: #fafafa;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <?php
    // Определение языка
    $lang = isset($_GET['lang']) ? $_GET['lang'] : 'ru';

    $translations = [
        'ru' => [
            'title' => 'SEO Анализатор',
            'slogan' => 'Оптимизируйте ваш сайт для поисковых систем!<br>Только для анализа и улучшения собственных ресурсов.',
            'h2' => 'Анализ SEO-параметров',
            'placeholder' => 'Введите URL для анализа',
            'button' => 'Анализировать',
            'error' => 'Ошибка: Не удалось загрузить страницу',
            'http_status' => 'HTTP Статус: ',
            'https_check' => 'HTTPS: ',
            'url_structure' => 'Структура URL: ',
            'links_check' => 'Ссылки: ',
            'social_meta' => 'Социальные мета-теги (Open Graph): ',
            'title_check' => 'Заголовок (Title): ',
            'meta_desc' => 'Мета-описание: ',
            'meta_keywords' => 'Мета-ключевые слова: ',
            'meta_robots' => 'Мета-robots: ',
            'h1_check' => 'H1 заголовок: ',
            'h2_check' => 'H2 заголовки: ',
            'images_alt' => 'Изображения (alt): ',
            'viewport' => 'Viewport: ',
            'load_time' => 'Время загрузки: ',
            'content_size' => 'Размер контента: ',
            'optimal' => 'Оптимально',
            'too_long' => 'Слишком длинный',
            'absent' => 'Отсутствует',
            'present' => 'Присутствуют',
            'too_many' => 'Слишком много',
            'all_with_alt' => 'Все с alt',
            'without_alt' => 'без alt',
            'good' => 'Хорошо',
            'slow' => 'Медленно',
            'enough' => 'Достаточно',
            'low_content' => 'Мало контента',
            'noindex' => 'Запрещена индексация',
            'not_set' => 'Не указан (доступно для индексации)',
            'configured' => 'Настроен',
            'secure' => 'Используется (безопасно)',
            'insecure' => 'Не используется (небезопасно)',
            'readable' => 'Читаемый',
            'complex' => 'Сложный или слишком длинный',
            'internal' => 'Внутренние: ',
            'external' => 'Внешние: ',
            'nofollow' => 'С nofollow: ',
            'symbols' => 'символов',
            'help' => 'Справка',
            'about' => 'О программе',
            'about_text' => '<strong>SEO Анализатор</strong> - это инструмент для анализа SEO-параметров веб-страниц. Он помогает оценить, насколько ваш сайт соответствует требованиям поисковых систем, и выявить области для улучшения.',
            'features' => 'Возможности:',
            'features_list' => '<li>Проверка длины заголовка (Title)</li><li>Анализ мета-описания, ключевых слов и robots</li><li>Подсчет H1 и H2 заголовков</li><li>Проверка alt-тегов изображений</li><li>Анализ мобильной адаптивности (viewport)</li><li>Измерение времени загрузки и размера контента</li><li>Анализ ссылок и структуры URL</li><li>Проверка социальных мета-тегов</li>',
            'howto' => 'Как использовать:',
            'howto_list' => '<li>Введите URL вашего сайта в поле ввода</li><li>Нажмите кнопку "Анализировать"</li><li>Ознакомьтесь с результатами</li><li>Зеленый цвет - всё в порядке, красный - требуется оптимизация</li>',
            'tips' => 'Советы по оптимизации:',
            'tips_list' => '<li><strong>Title:</strong> Держите длину до 60 символов для лучшей видимости в поиске.</li><li><strong>Мета-описание:</strong> Оптимально 120-160 символов с ключевыми словами.</li><li><strong>H1:</strong> Используйте только один H1 на страницу.</li><li><strong>Изображения:</strong> Добавляйте alt-теги для улучшения доступности и SEO.</li><li><strong>Скорость:</strong> Оптимизируйте изображения и код, чтобы время загрузки было менее 3 секунд.</li><li><strong>Контент:</strong> Стремитесь к объему более 50 KB для информативности.</li><li><strong>URL:</strong> Используйте короткие и читаемые ссылки с ключевыми словами.</li>',
            'footer' => 'Разработчик: Ruslan Bilohash, 2025',
            'recommendations' => 'Рекомендации:',
            'rec_title_too_long' => 'Сократите заголовок до 60 символов.',
            'rec_title_absent' => 'Добавьте заголовок (Title) для страницы.',
            'rec_meta_desc_too_long' => 'Сократите мета-описание до 160 символов.',
            'rec_meta_desc_absent' => 'Добавьте мета-описание с ключевыми словами.',
            'rec_h1_absent' => 'Добавьте один H1 заголовок.',
            'rec_h1_too_many' => 'Оставьте только один H1 заголовок.',
            'rec_images_alt' => 'Добавьте alt-теги к изображениям: ',
            'rec_viewport_absent' => 'Добавьте тег viewport для мобильной адаптивности.',
            'rec_load_time_slow' => 'Оптимизируйте страницу, чтобы время загрузки было менее 3 секунд.',
            'rec_content_low' => 'Увеличьте объем контента до 50 KB или больше.',
            'rec_https_insecure' => 'Переведите сайт на HTTPS для безопасности и лучшего ранжирования.',
            'rec_url_complex' => 'Упростите URL: используйте ключевые слова и сократите длину.',
            'rec_social_meta_absent' => 'Добавьте Open Graph теги (og:title, og:description) для соцсетей.'
        ],
        'en' => [
            'title' => 'SEO Analyzer',
            'slogan' => 'Optimize your website for search engines!<br>Only for analysis and improvement of your own resources.',
            'h2' => 'SEO Parameters Analysis',
            'placeholder' => 'Enter URL for analysis',
            'button' => 'Analyze',
            'error' => 'Error: Failed to load the page',
            'http_status' => 'HTTP Status: ',
            'https_check' => 'HTTPS: ',
            'url_structure' => 'URL Structure: ',
            'links_check' => 'Links: ',
            'social_meta' => 'Social Meta Tags (Open Graph): ',
            'title_check' => 'Title: ',
            'meta_desc' => 'Meta Description: ',
            'meta_keywords' => 'Meta Keywords: ',
            'meta_robots' => 'Meta Robots: ',
            'h1_check' => 'H1 Heading: ',
            'h2_check' => 'H2 Headings: ',
            'images_alt' => 'Images (alt): ',
            'viewport' => 'Viewport: ',
            'load_time' => 'Load Time: ',
            'content_size' => 'Content Size: ',
            'optimal' => 'Optimal',
            'too_long' => 'Too long',
            'absent' => 'Absent',
            'present' => 'Present',
            'too_many' => 'Too many',
            'all_with_alt' => 'All with alt',
            'without_alt' => 'without alt',
            'good' => 'Good',
            'slow' => 'Slow',
            'enough' => 'Enough',
            'low_content' => 'Low content',
            'noindex' => 'Indexing forbidden',
            'not_set' => 'Not set (indexing allowed)',
            'configured' => 'Configured',
            'secure' => 'Used (secure)',
            'insecure' => 'Not used (insecure)',
            'readable' => 'Readable',
            'complex' => 'Complex or too long',
            'internal' => 'Internal: ',
            'external' => 'External: ',
            'nofollow' => 'With nofollow: ',
            'symbols' => 'characters',
            'help' => 'Help',
            'about' => 'About the Program',
            'about_text' => '<strong>SEO Analyzer</strong> is a tool for analyzing SEO parameters of web pages. It helps evaluate how well your site meets search engine requirements and identify areas for improvement.',
            'features' => 'Features:',
            'features_list' => '<li>Title length check</li><li>Meta description, keywords and robots analysis</li><li>H1 and H2 heading count</li><li>Image alt tags check</li><li>Mobile responsiveness (viewport)</li><li>Load time and content size measurement</li><li>Links and URL structure analysis</li><li>Social meta tags check</li>',
            'howto' => 'How to use:',
            'howto_list' => '<li>Enter your website URL</li><li>Click "Analyze"</li><li>Review the results</li><li>Green - all good, red - needs optimization</li>',
            'tips' => 'Optimization tips:',
            'tips_list' => '<li><strong>Title:</strong> Keep under 60 characters for better search visibility.</li><li><strong>Meta Description:</strong> Optimal 120-160 characters with keywords.</li><li><strong>H1:</strong> Use only one H1 per page.</li><li><strong>Images:</strong> Add alt tags for accessibility and SEO.</li><li><strong>Speed:</strong> Optimize images and code for load time under 3 seconds.</li><li><strong>Content:</strong> Aim for more than 50 KB.</li><li><strong>URL:</strong> Use short, readable links with keywords.</li>',
            'footer' => 'Developer: Ruslan Bilohash, 2025',
            'recommendations' => 'Recommendations:',
            'rec_title_too_long' => 'Shorten the title to 60 characters.',
            'rec_title_absent' => 'Add a Title tag for the page.',
            'rec_meta_desc_too_long' => 'Shorten the meta description to 160 characters.',
            'rec_meta_desc_absent' => 'Add a meta description with keywords.',
            'rec_h1_absent' => 'Add one H1 heading.',
            'rec_h1_too_many' => 'Leave only one H1 heading.',
            'rec_images_alt' => 'Add alt tags to images: ',
            'rec_viewport_absent' => 'Add viewport tag for mobile responsiveness.',
            'rec_load_time_slow' => 'Optimize the page to load in under 3 seconds.',
            'rec_content_low' => 'Increase content size to 50 KB or more.',
            'rec_https_insecure' => 'Switch to HTTPS for security and better ranking.',
            'rec_url_complex' => 'Simplify URL: use keywords and shorten length.',
            'rec_social_meta_absent' => 'Add Open Graph tags (og:title, og:description) for social networks.'
        ],
        'no' => [
            'title' => 'SEO Analyzer',
            'slogan' => 'Optimaliser nettstedet ditt for søkemotorer!<br>Bare for analyse og forbedring av egne ressurser.',
            'h2' => 'Analyse av SEO-parametere',
            'placeholder' => 'Skriv inn URL for analyse',
            'button' => 'Analyser',
            'error' => 'Feil: Kunne ikke laste siden',
            'http_status' => 'HTTP Status: ',
            'https_check' => 'HTTPS: ',
            'url_structure' => 'URL-struktur: ',
            'links_check' => 'Lenker: ',
            'social_meta' => 'Sosiale meta-tagger (Open Graph): ',
            'title_check' => 'Tittel (Title): ',
            'meta_desc' => 'Meta-beskrivelse: ',
            'meta_keywords' => 'Meta-nøkkelord: ',
            'meta_robots' => 'Meta-robots: ',
            'h1_check' => 'H1-overskrift: ',
            'h2_check' => 'H2-overskrifter: ',
            'images_alt' => 'Bilder (alt): ',
            'viewport' => 'Viewport: ',
            'load_time' => 'Lastetid: ',
            'content_size' => 'Innholdsstørrelse: ',
            'optimal' => 'Optimal',
            'too_long' => 'For lang',
            'absent' => 'Mangler',
            'present' => 'Tilstede',
            'too_many' => 'For mange',
            'all_with_alt' => 'Alle med alt',
            'without_alt' => 'uten alt',
            'good' => 'Bra',
            'slow' => 'Langsom',
            'enough' => 'Tilstrekkelig',
            'low_content' => 'Lite innhold',
            'noindex' => 'Indeksering forbudt',
            'not_set' => 'Ikke satt (indeksering tillatt)',
            'configured' => 'Konfigurert',
            'secure' => 'Brukt (sikkert)',
            'insecure' => 'Ikke brukt (usikkert)',
            'readable' => 'Lesbar',
            'complex' => 'Kompleks eller for lang',
            'internal' => 'Interne: ',
            'external' => 'Eksterne: ',
            'nofollow' => 'Med nofollow: ',
            'symbols' => 'tegn',
            'help' => 'Hjelp',
            'about' => 'Om programmet',
            'about_text' => '<strong>SEO Analyzer</strong> er et verktøy for analyse av SEO-parametere på nettsider. Det hjelper deg å vurdere hvor godt nettstedet ditt oppfyller kravene til søkemotorer og identifisere områder for forbedring.',
            'features' => 'Funksjoner:',
            'features_list' => '<li>Sjekk av tittellengde</li><li>Analyse av meta-beskrivelse, nøkkelord og robots</li><li>Telling av H1 og H2 overskrifter</li><li>Sjekk av alt-tagger på bilder</li><li>Mobiltilpasning (viewport)</li><li>Måling av lastetid og innholdsstørrelse</li><li>Analyse av lenker og URL-struktur</li><li>Sjekk av sosiale meta-tagger</li>',
            'howto' => 'Slik bruker du:',
            'howto_list' => '<li>Skriv inn URL-en til nettstedet ditt</li><li>Klikk "Analyser"</li><li>Se gjennom resultatene</li><li>Grønn - alt bra, rød - trenger optimalisering</li>',
            'tips' => 'Optimaliseringstips:',
            'tips_list' => '<li><strong>Title:</strong> Hold lengden under 60 tegn for bedre synlighet i søk.</li><li><strong>Meta Description:</strong> Optimalt 120-160 tegn med nøkkelord.</li><li><strong>H1:</strong> Bruk kun én H1 per side.</li><li><strong>Bilder:</strong> Legg til alt-tagger for tilgjengelighet og SEO.</li><li><strong>Hastighet:</strong> Optimaliser bilder og kode for lastetid under 3 sekunder.</li><li><strong>Innhold:</strong> Sikte på mer enn 50 KB.</li><li><strong>URL:</strong> Bruk korte, lesbare lenker med nøkkelord.</li>',
            'footer' => 'Utvikler: Ruslan Bilohash, 2025',
            'recommendations' => 'Anbefalinger:',
            'rec_title_too_long' => 'Forkort tittelen til 60 tegn.',
            'rec_title_absent' => 'Legg til en Title-tag for siden.',
            'rec_meta_desc_too_long' => 'Forkort meta-beskrivelsen til 160 tegn.',
            'rec_meta_desc_absent' => 'Legg til en meta-beskrivelse med nøkkelord.',
            'rec_h1_absent' => 'Legg til én H1-overskrift.',
            'rec_h1_too_many' => 'Behold kun én H1-overskrift.',
            'rec_images_alt' => 'Legg til alt-tagger på bilder: ',
            'rec_viewport_absent' => 'Legg til viewport-tag for mobiltilpasning.',
            'rec_load_time_slow' => 'Optimaliser siden slik at lastetiden er under 3 sekunder.',
            'rec_content_low' => 'Øk innholdsstørrelsen til 50 KB eller mer.',
            'rec_https_insecure' => 'Bytt til HTTPS for sikkerhet og bedre rangering.',
            'rec_url_complex' => 'Forenkle URL: bruk nøkkelord og forkort lengden.',
            'rec_social_meta_absent' => 'Legg til Open Graph-tagger (og:title, og:description) for sosiale medier.'
        ]
        // Добавляй другие языки сюда по аналогии
    ];

    $t = $translations[$lang] ?? $translations['ru'];
    ?>
    <div class="header">
        <h1><?php echo $t['title']; ?></h1>
        <div class="slogan"><?php echo $t['slogan']; ?></div>
    </div>
    <div class="container">
        <button class="help-btn" onclick="document.getElementById('helpModal').style.display='block'"><?php echo $t['help']; ?></button>
        <h2><?php echo $t['h2']; ?></h2>
        <form method="POST" class="input-group">
            <input type="text" name="url" placeholder="<?php echo $t['placeholder']; ?>" required>
            <button type="submit"><?php echo $t['button']; ?></button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $url = trim($_POST["url"]);
            $headers = @get_headers($url, 1);
           
            if ($headers === false || !isset($headers[0])) {
                echo '<div class="result"><div class="issue">' . $t['error'] . '</div></div>';
                exit;
            }

            $http_status = $headers[0];
            $is_https = (stripos($url, 'https://') === 0);
            $start_time = microtime(true);
            $content = @file_get_contents($url);
            $load_time = microtime(true) - $start_time;

            if ($content === false) {
                echo '<div class="result"><div class="issue">' . $t['error'] . '</div></div>';
                exit;
            }

            $doc = new DOMDocument();
            @$doc->loadHTML($content);

            // ... (весь парсинг остаётся без изменений) ...

            $title_text = $doc->getElementsByTagName('title')->item(0)?->nodeValue ?? '';
            $title_length = strlen($title_text);

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
                if ($meta->getAttribute('name') === 'viewport') { $viewport = true; break; }
            }

            $content_size = strlen($content) / 1024;

            // Анализ ссылок
            $internal_links = $external_links = $nofollow_links = 0;
            $parsed_url = parse_url($url);
            $base_domain = $parsed_url['host'] ?? '';
            foreach ($doc->getElementsByTagName('a') as $link) {
                $href = $link->getAttribute('href');
                if (empty($href) || $href === '#') continue;

                if (stripos($href, 'http') === 0) {
                    $link_domain = parse_url($href, PHP_URL_HOST) ?? '';
                    ($link_domain === $base_domain) ? $internal_links++ : $external_links++;
                } else {
                    $internal_links++;
                }
                if ($link->getAttribute('rel') === 'nofollow') $nofollow_links++;
            }

            // Анализ структуры URL
            $url_length = strlen($url);
            $is_readable_url = (preg_match('/^[a-zA-Z0-9\-\/]+$/', parse_url($url, PHP_URL_PATH) ?? '') && $url_length <= 100);

            echo '<div class="result">';

            echo '<div class="' . (stripos($http_status, '200') !== false ? 'good' : 'issue') . '">' . $t['http_status'] . $http_status . '</div>';
            echo '<div class="' . ($is_https ? 'good' : 'issue') . '">' . $t['https_check'] . ($is_https ? $t['secure'] : $t['insecure']) . '</div>';
            echo '<div class="' . ($is_readable_url ? 'good' : 'issue') . '">' . $t['url_structure'] . ($is_readable_url ? $t['readable'] : $t['complex']) . " (" . $url_length . " " . $t['symbols'] . ")</div>";
            echo '<div class="good">' . $t['links_check'] . $t['internal'] . $internal_links . ', ' . $t['external'] . $external_links . ', ' . $t['nofollow'] . $nofollow_links . '</div>';
            echo '<div class="' . ($og_title && $og_description ? 'good' : 'issue') . '">' . $t['social_meta'] . ($og_title && $og_description ? $t['present'] : $t['absent']) . '</div>';

            // Title, Meta, H1, H2, Images, Viewport, Load Time, Content Size — всё остаётся как было, только с $t

            echo '<div class="' . ($title_length > 0 && $title_length <= 60 ? 'good' : 'issue') . '">' . $t['title_check'] . ($title_length > 0 ? ($title_length <= 60 ? $t['optimal'] . " ($title_length)" : $t['too_long'] . " ($title_length)") : $t['absent']) . '</div>';
            echo '<div class="' . (strlen($description) > 0 && strlen($description) <= 160 ? 'good' : 'issue') . '">' . $t['meta_desc'] . (strlen($description) > 0 ? (strlen($description) <= 160 ? $t['optimal'] . " (" . strlen($description) . ")" : $t['too_long'] . " (" . strlen($description) . ")") : $t['absent']) . '</div>';
            echo '<div class="' . (strlen($keywords) > 0 ? 'good' : 'issue') . '">' . $t['meta_keywords'] . (strlen($keywords) > 0 ? $t['present'] : $t['absent']) . '</div>';
            echo '<div class="' . ($robots === '' || stripos($robots, 'noindex') === false ? 'good' : 'issue') . '">' . $t['meta_robots'] . ($robots === '' ? $t['not_set'] : (stripos($robots, 'noindex') !== false ? $t['noindex'] : $t['configured'])) . '</div>';
            echo '<div class="' . ($h1_count === 1 ? 'good' : 'issue') . '">' . $t['h1_check'] . ($h1_count === 1 ? $t['optimal'] : ($h1_count > 1 ? $t['too_many'] . " ($h1_count)" : $t['absent'])) . '</div>';
            echo '<div class="' . ($h2_count > 0 && $h2_count <= 10 ? 'good' : 'issue') . '">' . $t['h2_check'] . ($h2_count > 0 ? ($h2_count <= 10 ? $t['optimal'] . " ($h2_count)" : $t['too_many'] . " ($h2_count)") : $t['absent']) . '</div>';
            echo '<div class="' . ($images_without_alt === 0 ? 'good' : 'issue') . '">' . $t['images_alt'] . ($images_without_alt === 0 ? $t['all_with_alt'] : "$images_without_alt " . $t['without_alt']) . '</div>';
            echo '<div class="' . ($viewport ? 'good' : 'issue') . '">' . $t['viewport'] . ($viewport ? $t['present'] : $t['absent']) . '</div>';
            echo '<div class="' . ($load_time < 3 ? 'good' : 'issue') . '">' . $t['load_time'] . number_format($load_time, 2) . ' s (' . ($load_time < 3 ? $t['good'] : $t['slow']) . ')</div>';
            echo '<div class="' . ($content_size > 50 ? 'good' : 'issue') . '">' . $t['content_size'] . number_format($content_size, 1) . ' KB (' . ($content_size > 50 ? $t['enough'] : $t['low_content']) . ')</div>';

            echo '<h3>' . $t['recommendations'] . '</h3>';
            if ($title_length > 60) echo '<div class="recommendation">' . $t['rec_title_too_long'] . '</div>';
            elseif ($title_length == 0) echo '<div class="recommendation">' . $t['rec_title_absent'] . '</div>';
            if (strlen($description) > 160) echo '<div class="recommendation">' . $t['rec_meta_desc_too_long'] . '</div>';
            elseif (strlen($description) == 0) echo '<div class="recommendation">' . $t['rec_meta_desc_absent'] . '</div>';
            if ($h1_count == 0) echo '<div class="recommendation">' . $t['rec_h1_absent'] . '</div>';
            elseif ($h1_count > 1) echo '<div class="recommendation">' . $t['rec_h1_too_many'] . '</div>';
            if ($images_without_alt > 0) echo '<div class="recommendation">' . $t['rec_images_alt'] . $images_without_alt . '</div>';
            if (!$viewport) echo '<div class="recommendation">' . $t['rec_viewport_absent'] . '</div>';
            if ($load_time >= 3) echo '<div class="recommendation">' . $t['rec_load_time_slow'] . '</div>';
            if ($content_size <= 50) echo '<div class="recommendation">' . $t['rec_content_low'] . '</div>';
            if (!$is_https) echo '<div class="recommendation">' . $t['rec_https_insecure'] . '</div>';
            if (!$is_readable_url) echo '<div class="recommendation">' . $t['rec_url_complex'] . '</div>';
            if (!$og_title || !$og_description) echo '<div class="recommendation">' . $t['rec_social_meta_absent'] . '</div>';

            echo '</div>';
        }
        ?>
    </div>

    <div class="footer">
        <?php echo $t['footer']; ?>
        <div class="contacts">
            <span><a href="https://t.me/meistru_lt" target="_blank">Telegram: @meistru_lt</a></span>
            <span><a href="mailto:rbilohash@gmail.com">Email: rbilohash@gmail.com</a></span>
            <span><a href="https://meistru.lt" target="_blank">Website: meistru.lt</a></span>
        </div>
        <div class="lang-select">
            <select onchange="window.location.href='?lang='+this.value">
                <option value="ru" <?php echo $lang == 'ru' ? 'selected' : ''; ?>>Русский</option>
                <option value="ua" <?php echo $lang == 'ua' ? 'selected' : ''; ?>>Українська</option>
                <option value="lt" <?php echo $lang == 'lt' ? 'selected' : ''; ?>>Lietuvių</option>
                <option value="en" <?php echo $lang == 'en' ? 'selected' : ''; ?>>English</option>
                <option value="pl" <?php echo $lang == 'pl' ? 'selected' : ''; ?>>Polski</option>
                <option value="ge" <?php echo $lang == 'ge' ? 'selected' : ''; ?>>ქართული</option>
                <option value="no" <?php echo $lang == 'no' ? 'selected' : ''; ?>>Norsk</option>
            </select>
        </div>
    </div>

    <div id="helpModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('helpModal').style.display='none'">×</span>
            <h2><?php echo $t['about']; ?></h2>
            <p><?php echo $t['about_text']; ?></p>
            <h3><?php echo $t['features']; ?></h3>
            <ul><?php echo $t['features_list']; ?></ul>
            <h3><?php echo $t['howto']; ?></h3>
            <ol><?php echo $t['howto_list']; ?></ol>
            <div class="tips">
                <h3><?php echo $t['tips']; ?></h3>
                <ul><?php echo $t['tips_list']; ?></ul>
            </div>
        </div>
    </div>

    <script>
        window.onclick = function(event) {
            var modal = document.getElementById('helpModal');
            if (event.target == modal) modal.style.display = "none";
        }
    </script>
</body>
</html>