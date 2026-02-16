<?php
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'ru';
$current_page = 'privacy';
$page_title = 'Политика конфиденциальности | SEO Analyzer';

include 'lang.php';
$t = getTranslations($lang);
?>
<?php include 'header.php'; ?>

<div class="privacy-page">
    <div class="privacy-card">
        <h1><?php echo $t['privacy_title']; ?></h1>
        <p class="privacy-text"><?php echo $t['privacy_text']; ?></p>

        <div class="consent-buttons">
            <a href="index.php?lang=<?php echo $lang; ?>" class="btn-accept">
                <?php echo $t['accept']; ?>
            </a>
            <a href="#" onclick="rejectConsent()" class="btn-reject">
                <?php echo $t['reject']; ?>
            </a>
        </div>

        <div class="privacy-note">
            <small><?php echo $t['privacy_note']; ?></small>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
function rejectConsent() {
    alert("<?php echo $t['reject_message']; ?>");
    window.location.href = "index.php?lang=<?php echo $lang; ?>";
}
</script>

<style>
.privacy-page {
    min-height: calc(100vh - 180px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    background: linear-gradient(135deg, #f8fafc, #e0f2fe);
}

.privacy-card {
    background: white;
    max-width: 780px;
    width: 100%;
    padding: 60px 50px;
    border-radius: 28px;
    box-shadow: 0 25px 70px rgba(0,0,0,0.13);
    text-align: center;
}

.privacy-card h1 { font-size: 32px; margin-bottom: 25px; color: #1e2937; }
.privacy-text { font-size: 17px; line-height: 1.8; color: #334155; text-align: left; margin-bottom: 40px; }

.consent-buttons {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-accept, .btn-reject {
    padding: 16px 40px;
    border-radius: 50px;
    font-size: 18px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s;
}

.btn-accept {
    background: #22c55e;
    color: white;
}

.btn-reject {
    background: #ef4444;
    color: white;
}

.btn-accept:hover { background:#16a34a; transform:translateY(-3px); }
.btn-reject:hover { background:#dc2626; transform:translateY(-3px); }

.privacy-note { margin-top:50px; font-size:14px; color:#64748b; }
</style>