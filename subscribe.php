<?php
session_start();

$lang = isset($_POST['lang']) ? $_POST['lang'] : (isset($_GET['lang']) ? $_GET['lang'] : 'ru');
$current_page = 'subscribe';
$page_title = 'Подписка | SEO Analyzer';

include 'lang.php';
$t = getTranslations($lang);

// === ПЕРЕВОДЫ ДЛЯ ПОДПИСКИ (все 8 языков) ===
$sub = [
    'ru' => [
        'title'       => 'Подписка на обновления',
        'subtitle'    => 'Будьте в курсе новых функций и улучшений SEO Analyzer',
        'email'       => 'Ваш email',
        'button'      => 'Подписаться',
        'success'     => 'Спасибо! Вы успешно подписались ❤️',
        'already'     => 'Этот email уже подписан',
        'unsubscribe' => 'Чтобы отписаться — напишите администратору: rbilohash@gmail.com',
        'icon'        => '🔔'
    ],
    'en' => [
        'title'       => 'Subscribe to updates',
        'subtitle'    => 'Stay informed about new features and improvements of SEO Analyzer',
        'email'       => 'Your email',
        'button'      => 'Subscribe',
        'success'     => 'Thank you! You have successfully subscribed ❤️',
        'already'     => 'This email is already subscribed',
        'unsubscribe' => 'To unsubscribe — write to the administrator: rbilohash@gmail.com',
        'icon'        => '🔔'
    ],
    'ua' => [
        'title'       => 'Підписка на оновлення',
        'subtitle'    => 'Будьте в курсі нових функцій та покращень SEO Analyzer',
        'email'       => 'Ваш email',
        'button'      => 'Підписатися',
        'success'     => 'Дякуємо! Ви успішно підписалися ❤️',
        'already'     => 'Цей email вже підписаний',
        'unsubscribe' => 'Щоб відписатися — напишіть адміністратору: rbilohash@gmail.com',
        'icon'        => '🔔'
    ],
    'lt' => [
        'title'       => 'Prenumerata naujienoms',
        'subtitle'    => 'Gaukite naujienas apie SEO Analyzer atnaujinimus',
        'email'       => 'Jūsų el. paštas',
        'button'      => 'Prenumeruoti',
        'success'     => 'Ačiū! Jūs sėkmingai prenumeravote ❤️',
        'already'     => 'Šis el. paštas jau prenumeruotas',
        'unsubscribe' => 'Norėdami atsisakyti prenumeratos — parašykite administratoriui: rbilohash@gmail.com',
        'icon'        => '🔔'
    ],
    'pl' => [
        'title'       => 'Subskrypcja aktualizacji',
        'subtitle'    => 'Bądź na bieżąco z nowymi funkcjami SEO Analyzer',
        'email'       => 'Twój email',
        'button'      => 'Subskrybuj',
        'success'     => 'Dziękujemy! Zapisano pomyślnie ❤️',
        'already'     => 'Ten email jest już zapisany',
        'unsubscribe' => 'Aby zrezygnować — napisz do administratora: rbilohash@gmail.com',
        'icon'        => '🔔'
    ],
    'ge' => [
        'title'       => 'გამოწერა განახლებებზე',
        'subtitle'    => 'იყავით ინფორმირებული SEO Analyzer-ის ახალი ფუნქციების შესახებ',
        'email'       => 'თქვენი ელფოსტა',
        'button'      => 'გამოწერა',
        'success'     => 'გმადლობთ! წარმატებით გამოიწერეთ ❤️',
        'already'     => 'ეს ელფოსტა უკვე გამოწერილია',
        'unsubscribe' => 'გამოწერის გასაუქმებლად — მიწერეთ ადმინისტრატორს: rbilohash@gmail.com',
        'icon'        => '🔔'
    ],
    'no' => [
        'title'       => 'Abonner på oppdateringer',
        'subtitle'    => 'Få varsler om nye funksjoner i SEO Analyzer',
        'email'       => 'Din e-post',
        'button'      => 'Abonner',
        'success'     => 'Takk! Du er nå abonnent ❤️',
        'already'     => 'Denne e-posten er allerede abonnert',
        'unsubscribe' => 'For å melde deg av — skriv til administrator: rbilohash@gmail.com',
        'icon'        => '🔔'
    ],
    'de' => [
        'title'       => 'Abonnieren Sie Updates',
        'subtitle'    => 'Bleiben Sie über neue Funktionen von SEO Analyzer informiert',
        'email'       => 'Ihre E-Mail',
        'button'      => 'Abonnieren',
        'success'     => 'Vielen Dank! Sie haben erfolgreich abonniert ❤️',
        'already'     => 'Diese E-Mail ist bereits abonniert',
        'unsubscribe' => 'Zum Abbestellen schreiben Sie bitte dem Administrator: rbilohash@gmail.com',
        'icon'        => '🔔'
    ]
];

$s = $sub[$lang] ?? $sub['ru'];

// === ОБРАБОТКА ПОДПИСКИ ===
$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = trim(strtolower($_POST['email']));
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $file = __DIR__ . '/subscribe.json';
        if (!file_exists($file)) file_put_contents($file, '[]');
        
        $subscribers = json_decode(file_get_contents($file), true) ?? [];
        
        if (in_array($email, $subscribers)) {
            $error = $s['already'];
        } else {
            $subscribers[] = $email;
            file_put_contents($file, json_encode($subscribers, JSON_PRETTY_PRINT));
            
            // === ОТПРАВКА ПИСЬМА АДМИНИСТРАТОРУ ===
            $admin_email = "rbilohash@gmail.com";
            $admin_subject = "Новый подписчик SEO Analyzer";
            $admin_message = "Новый пользователь подписался на обновления!\n\n";
            $admin_message .= "Email: " . $email . "\n";
            $admin_message .= "Дата: " . date('Y-m-d H:i:s') . "\n";
            $admin_message .= "Всего подписчиков: " . count($subscribers);
            
            $admin_headers = "From: no-reply@meistru.lt\r\nContent-Type: text/plain; charset=utf-8";
            
            mail($admin_email, $admin_subject, $admin_message, $admin_headers);
            
            $success = true;
        }
    } else {
        $error = $lang === 'ru' ? 'Введите корректный email' : 'Please enter a valid email';
    }
}
?>

<?php include 'header.php'; ?>

<div class="subscribe-page">
    <div class="subscribe-card">
        <div class="icon-big"><?php echo $s['icon']; ?></div>
        
        <h1><?php echo $s['title']; ?></h1>
        <p class="subtitle"><?php echo $s['subtitle']; ?></p>

        <?php if ($success): ?>
            <div class="success-box">
                <i class="fas fa-check-circle"></i>
                <p><?php echo $s['success']; ?></p>
            </div>
        <?php elseif ($error): ?>
            <div class="error-box"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (!$success): ?>
        <form method="POST" class="subscribe-form">
            <input type="hidden" name="lang" value="<?php echo htmlspecialchars($lang); ?>">
            
            <div class="input-wrapper">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="<?php echo $s['email']; ?>" required>
            </div>
            
            <button type="submit" class="subscribe-btn">
                <?php echo $s['button']; ?>
            </button>
        </form>
        <?php endif; ?>

        <div class="unsubscribe">
            <small><?php echo $s['unsubscribe']; ?></small>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<style>
/* Тот же красивый стиль, что и раньше */
.subscribe-page { min-height: calc(100vh - 180px); display: flex; align-items: center; justify-content: center; padding: 40px 20px; background: linear-gradient(135deg, #f8fafc, #e0f2fe); }
.subscribe-card { background: white; max-width: 520px; width: 100%; padding: 60px 40px; border-radius: 28px; box-shadow: 0 25px 70px rgba(0,0,0,0.13); text-align: center; }
.icon-big { font-size: 68px; margin-bottom: 20px; }
.subscribe-card h1 { font-size: 28px; margin-bottom: 12px; color: #1e2937; }
.subtitle { font-size: 17px; color: #64748b; line-height: 1.5; margin-bottom: 40px; }
.input-wrapper { position: relative; margin-bottom: 20px; }
.input-wrapper i { position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 20px; }
.input-wrapper input { width: 100%; padding: 18px 18px 18px 52px; border: 2px solid #e2e8f0; border-radius: 16px; font-size: 17px; }
.subscribe-btn { width: 100%; padding: 18px; background: linear-gradient(135deg, #22c55e, #16a34a); color: white; border: none; border-radius: 16px; font-size: 18px; font-weight: 700; cursor: pointer; }
.subscribe-btn:hover { transform: translateY(-3px); box-shadow: 0 15px 35px rgba(34,197,94,0.4); }
.success-box, .error-box { padding: 20px; border-radius: 16px; margin: 20px 0; font-size: 18px; }
.success-box { background: #f0fdf4; color: #166534; }
.error-box { background: #fef2f2; color: #b91c1c; }
.unsubscribe { margin-top: 40px; font-size: 14px; color: #64748b; }
</style>