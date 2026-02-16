<?php
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'ru';
$current_page = 'about';
$page_title = 'О проекте | SEO Analyzer';

include 'lang.php';
$t = getTranslations($lang);
?>
<?php include 'header.php'; ?>

<div class="about-section" style="max-width:800px;margin:0 auto;">
    <h1 style="text-align:center;margin-bottom:30px;"><?php echo $t['about']; ?></h1>
    
    <div class="about-card">
        <h2>SEO Analyzer 1.8</h2>
        <p><strong>Дата выпуска:</strong> февраль 2026</p>
        <p><strong>Автор:</strong> Ruslan Bilohash</p>
        
        <h3>Что это за инструмент?</h3>
        <p>SEO Analyzer — это современный, быстрый и бесплатный онлайн-инструмент для анализа основных SEO-параметров любой веб-страницы. Он помогает веб-мастерам, SEO-специалистам и владельцам сайтов быстро выявить проблемы и получить рекомендации по улучшению.</p>
        
        <h3>Основные возможности</h3>
        <ul style="columns:2;gap:30px;">
            <li>Проверка Title (длина, наличие)</li>
            <li>Meta Description + Keywords + Robots</li>
            <li>H1 и H2 заголовки (количество)</li>
            <li>Alt-теги у всех изображений</li>
            <li>Viewport и мобильная адаптивность</li>
            <li>Время загрузки + размер контента</li>
            <li>Структура URL и читаемость</li>
            <li>Внутренние / внешние / nofollow ссылки</li>
            <li>Open Graph (og:title, og:description)</li>
            <li>История последних анализов</li>
            <li>Заказ полного профессионального аудита</li>
            <li>Поддержка 8 языков</li>
        </ul>
        
        <h3>Технические особенности</h3>
        <p>Скрипт работает на чистом PHP + DOMDocument, не требует базы данных, использует только один JSON-файл для истории. Полностью клиент-серверный, без внешних API.</p>
        
        <div style="text-align:center;margin-top:40px;">
            <a href="index.php" class="button-primary" style="padding:16px 40px;font-size:18px;">Начать анализ сайта →</a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>