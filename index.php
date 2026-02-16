<?php
$lang = isset($_POST['lang']) ? $_POST['lang'] : (isset($_GET['lang']) ? $_GET['lang'] : 'ru');
$current_page = 'index';
$page_title = 'SEO Analyzer';

include 'lang.php';
$t = getTranslations($lang);

$history_file = __DIR__ . '/seo_history.json';
if (!file_exists($history_file)) file_put_contents($history_file, '[]');
?>
<?php include 'header.php'; ?>

<h2><?php echo $t['h2']; ?></h2>

<form method="POST" class="input-group">
    <input type="hidden" name="lang" value="<?php echo htmlspecialchars($lang); ?>">
    <div class="protocol-select">
        <select name="protocol">
            <option value="https" selected>https://</option>
            <option value="http">http://</option>
        </select>
    </div>
    <div class="input-wrapper">
        <i class="fas fa-globe"></i>
        <input type="text" name="domain" placeholder="<?php echo $t['placeholder']; ?>" required>
    </div>
    <button type="submit"><i class="fas fa-search"></i> <?php echo $t['button']; ?></button>
</form>

<?php include 'module.php'; ?>

<div class="history-section">
    <h3><?php echo $t['history']; ?></h3>
    <div class="history-list" id="history-list">
        <?php
        $history = json_decode(@file_get_contents($history_file), true) ?? [];
        if (empty($history)) {
            echo '<div class="history-item">' . $t['no_history'] . '</div>';
        } else {
            foreach (array_reverse($history) as $h) {
                echo '<div class="history-item" data-url="' . htmlspecialchars($h['url']) . '">' 
                     . htmlspecialchars($h['url']) . ' <small>(' . $h['time'] . ')</small></div>';
            }
        }
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
// Чистий JavaScript (вирішує CSP помилку)
document.addEventListener('DOMContentLoaded', function() {
    const historyItems = document.querySelectorAll('.history-item[data-url]');
    
    historyItems.forEach(item => {
        item.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            loadHistory(url);
        });
    });
});

function loadHistory(url) {
    let protocol = url.startsWith('http://') ? 'http' : 'https';
    let domain = url.replace(/^https?:\/\//, '');
    
    document.querySelector('select[name="protocol"]').value = protocol;
    document.querySelector('input[name="domain"]').value = domain;
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>