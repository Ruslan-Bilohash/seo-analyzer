<?php
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'ru';
$current_page = 'help';
$page_title = 'Справка | SEO Analyzer';

include 'lang.php';
$t = getTranslations($lang);
?>
<?php include 'header.php'; ?>

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

<?php include 'footer.php'; ?>