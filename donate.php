<?php
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'ru';
$current_page = 'donate';
$page_title = 'Підтримати проект | SEO Analyzer';

include 'lang.php';
$t = getTranslations($lang);
?>
<?php include 'header.php'; ?>

<div class="donate-page">
    <div class="donate-card">
        <h1><i class="fas fa-heart" style="color:#ef4444;"></i> <?php echo $t['donate_title']; ?></h1>
        <p class="donate-text"><?php echo $t['donate_text']; ?></p>

        <!-- QR -->


        <h3>Оберіть спосіб оплати</h3>

        <div class="payment-grid">
            <a href="https://buymeacoffee.com/bilohash" target="_blank" class="payment-btn coffee">
                <i class="fas fa-coffee"></i><span>BuyMeACoffee</span>
            </a>
            <a href="https://wise.com/pay/me/ruslanb933" target="_blank" class="payment-btn wise">
                <i class="fas fa-globe"></i><span>Wise</span>
            </a>
            <a href="https://www.paypal.com/donate/?hosted_button_id=GSS6YYMXZ3J4N" target="_blank" class="payment-btn paypal">
                <i class="fab fa-paypal"></i><span>PayPal</span>
            </a>
            <button id="vipps-btn" class="payment-btn vipps">
                <i class="fas fa-mobile-alt"></i><span>Vipps</span><small>+47 462 55 885</small>
            </button>
            <div class="payment-btn paypal-qr">
                <img src="https://edukvam.com/seo/QR-kode-paypal.png" alt="PayPal QR" class="qr-small">
                <span>PayPal QR</span>
            </div>
        </div>

        <div class="other-ways">
            <p>Або напишіть мені:</p>
            <a href="https://t.me/meistru_lt" target="_blank" class="telegram-btn">
                <i class="fab fa-telegram-plane"></i> Telegram @meistru_lt
            </a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
document.getElementById('vipps-btn').addEventListener('click', function() {
    navigator.clipboard.writeText('+4746255885');
    alert('Номер Vipps скопійовано: +47 462 55 885');
});
</script>

<style>
.donate-page {
    min-height: calc(100vh - 180px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    background: linear-gradient(135deg, #f8fafc, #e0f2fe);
}

.donate-card {
    background: white;
    max-width: 860px;
    width: 100%;
    padding: 60px 50px;
    border-radius: 28px;
    box-shadow: 0 25px 70px rgba(0,0,0,0.13);
    text-align: center;
}

.donate-card h1 { font-size: 34px; margin-bottom: 15px; color: #1e2937; }
.donate-text { font-size: 18.5px; line-height: 1.7; color: #475569; margin-bottom: 40px; }

.qr-container { margin: 30px 0 45px; }
.qr-code { max-width: 260px; border-radius: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.15); }

.payment-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(165px, 1fr));
    gap: 22px;
    margin: 40px 0;
}

.payment-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 28px 16px;
    border-radius: 20px;
    color: white;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
    min-height: 130px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.payment-btn:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.18); }
.payment-btn i { font-size: 36px; margin-bottom: 12px; }

.coffee { background: linear-gradient(135deg, #FFDD00, #FBBF24); color:#000; }
.vipps  { background: #FF5C00; }
.wise   { background: #00C853; }   /* Зелений, як просив */
.paypal { background: #00457C; }

.paypal-qr { background:#f8fafc; border:2px dashed #90a4ae; color:#263238; padding:20px; }
.paypal-qr img { max-width:140px; border-radius:12px; margin-bottom:10px; }

.other-ways { margin-top:50px; }
.telegram-btn {
    background:#0088cc; color:white; padding:16px 36px;
    border-radius:50px; text-decoration:none; font-weight:600;
    display:inline-flex; align-items:center; gap:10px;
}

/* Адаптивність */
@media (max-width:768px) {
    .donate-card { padding:45px 30px; }
    .payment-grid { grid-template-columns:repeat(2,1fr); }
}
@media (max-width:480px) {
    .payment-grid { grid-template-columns:1fr; }
}
</style>