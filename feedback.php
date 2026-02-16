<?php
session_start();

$lang = isset($_POST['lang']) ? $_POST['lang'] : (isset($_GET['lang']) ? $_GET['lang'] : 'ru');
$current_page = 'feedback';
$page_title = 'Заказать аудит | SEO Analyzer';

include 'lang.php';
$t = getTranslations($lang);

// === ГЕНЕРАЦИЯ КАПЧИ ===
if (!isset($_SESSION['captcha_answer'])) {
    $num1 = rand(3, 9);
    $num2 = rand(3, 9);
    $_SESSION['captcha_answer'] = $num1 + $num2;
    $_SESSION['captcha_question'] = "$num1 + $num2 = ?";
}

$order_success = false;
$error = '';

if (isset($_POST['action']) && $_POST['action'] === 'order_audit') {
    $user_answer = intval($_POST['captcha'] ?? 0);
    
    if ($user_answer !== $_SESSION['captcha_answer']) {
        $error = $lang === 'ru' ? 'Неверный ответ на капчу!' : 
                ($lang === 'ua' ? 'Невірна відповідь на капчу!' : 'Wrong captcha answer!');
    } else {
        $to = "rbilohash@gmail.com";
        $subject = "Заказ полного SEO-аудита от " . ($_POST['name'] ?? 'Клиент');
        
        $message = "=== ЗАКАЗ АУДИТА ===\n\n";
        $message .= "Имя: " . ($_POST['name'] ?? '') . "\n";
        $message .= "Email: " . ($_POST['email'] ?? '') . "\n";
        $message .= "Сайт: " . ($_POST['site'] ?? '') . "\n\n";
        $message .= "Сообщение:\n" . ($_POST['message'] ?? '') . "\n\n";
        $message .= "=== КОНТАКТЫ ===\n";
        $message .= "Norway, 3014 Drammen\n";
        $message .= "Тел: +47 462 55 885\n";

        $headers = "From: no-reply@meistru.lt\r\nContent-Type: text/plain; charset=utf-8";
        
        mail($to, $subject, $message, $headers);
        $order_success = true;
        
        unset($_SESSION['captcha_answer']);
    }
}
?>
<?php include 'header.php'; ?>

<div class="feedback-page">
    <div class="feedback-card">
        <h1><i class="fas fa-clipboard-list"></i> <?php echo $t['order_audit'] ?? 'Заказать аудит'; ?></h1>
        
        <?php if ($order_success): ?>
            <div class="success-message">
                <i class="fas fa-check-circle"></i>
                <?php echo $t['audit_success']; ?>
            </div>
        <?php elseif ($error): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" class="feedback-form">
            <input type="hidden" name="action" value="order_audit">
            <input type="hidden" name="lang" value="<?php echo htmlspecialchars($lang); ?>">

            <div class="form-group">
                <label for="name"><?php echo $t['name_label']; ?></label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email"><?php echo $t['email_label']; ?></label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="site"><?php echo $t['site_label']; ?></label>
                <input type="text" id="site" name="site" required placeholder="example.com">
            </div>

            <div class="form-group">
                <label for="message"><?php echo $t['message_label']; ?></label>
                <textarea id="message" name="message" rows="6" required></textarea>
            </div>

            <!-- Капча -->
            <div class="form-group captcha-group">
                <label for="captcha">Капча: <?php echo $_SESSION['captcha_question']; ?></label>
                <input type="text" id="captcha" name="captcha" placeholder="Ответ" required>
            </div>

            <button type="submit" class="submit-btn">
                <i class="fas fa-paper-plane"></i> 
                <?php echo $t['submit_audit']; ?>
            </button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
// Чистий JavaScript без inline (вирішує CSP)
document.addEventListener('DOMContentLoaded', function() {
    // Можно добавить улучшения здесь
});
</script>

<style>
/* === ОПТИМИЗИРОВАНО ДЛЯ iPHONE === */
.feedback-page {
    min-height: calc(100vh - 180px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 30px 15px;
    background: linear-gradient(135deg, #f8fafc, #e0f2fe);
}

.feedback-card {
    background: white;
    max-width: 920px;           /* Сделали шире */
    width: 100%;
    padding: 55px 40px;
    border-radius: 28px;
    box-shadow: 0 25px 70px rgba(0,0,0,0.13);
}

.feedback-card h1 {
    text-align: center;
    margin-bottom: 35px;
    font-size: 30px;
    color: #1e2937;
}

.success-message {
    background: #f0fdf4;
    color: #166534;
    padding: 20px;
    border-radius: 16px;
    text-align: center;
    margin-bottom: 30px;
    font-size: 18px;
}

.error-message {
    background: #fef2f2;
    color: #b91c1c;
    padding: 15px;
    border-radius: 12px;
    text-align: center;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 26px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #334155;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 16px;
    border: 2px solid #e2e8f0;
    border-radius: 14px;
    font-size: 16.5px;
    transition: all 0.3s;
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 4px rgba(99,102,241,0.15);
    outline: none;
}

.submit-btn {
    width: 100%;
    padding: 18px;
    background: linear-gradient(135deg, #22c55e, #16a34a);
    color: white;
    border: none;
    border-radius: 16px;
    font-size: 18px;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    transition: all 0.3s;
}

.submit-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(34,197,94,0.4);
}

/* Адаптивность специально для iPhone */
@media (max-width: 768px) {
    .feedback-card { 
        padding: 45px 30px; 
        max-width: 100%; 
    }
}

@media (max-width: 480px) {
    .feedback-card { 
        padding: 35px 20px; 
        border-radius: 20px; 
    }
    
    .feedback-card h1 { 
        font-size: 26px; 
    }
}
</style>