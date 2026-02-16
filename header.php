<?php
// $t, $lang, $page_title, $current_page уже определены в вызывающем файле
$meta_desc = $t['meta_description'] ?? 'Бесплатный онлайн-инструмент для анализа SEO вашего сайта. Проверка title, meta, скорости, ссылок и рекомендаций.';
$meta_keywords = $t['meta_keywords'] ?? 'seo analyzer, анализ сайта, seo check, title, meta description, h1, скорость загрузки';
?>
<!DOCTYPE html>
<html lang="<?php echo $lang ?? 'ru'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($meta_desc); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($meta_keywords); ?>">
    <meta property="og:title" content="<?php echo $page_title; ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($meta_desc); ?>">
    <meta property="og:type" content="website">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {--primary:#6366f1;--primary-dark:#4f46e5;--accent:#f97316;--success:#22c55e;--danger:#ef4444;--warning:#eab308;}
        *{box-sizing:border-box;}
        body{font-family:'Segoe UI',system-ui,sans-serif;max-width:980px;margin:0 auto;padding:20px;background:linear-gradient(135deg,#f8fafc 0%,#e0f2fe 100%);line-height:1.6;color:#1e2937;}
        .header{background:linear-gradient(135deg,var(--primary),#a5b4fc);color:white;padding:35px 25px;border-radius:20px 20px 0 0;text-align:center;margin-bottom:20px;box-shadow:0 10px 25px rgba(99,102,241,0.3);position:relative;overflow:hidden;}
        .header::before{content:'';position:absolute;top:-50%;right:-20%;width:300px;height:300px;background:rgba(255,255,255,0.15);border-radius:50%;}
        .header h1{margin:0;font-size:38px;font-weight:700;display:flex;align-items:center;justify-content:center;gap:12px;position:relative;z-index:1;}
        .version{font-size:15px;font-weight:500;opacity:0.9;margin:8px 0 10px;letter-spacing:1px;}
        .slogan{font-style:italic;font-size:16px;margin-top:8px;opacity:0.95;line-height:1.4;position:relative;z-index:1;}
        .container{background:white;padding:35px;border-radius:0 0 20px 20px;box-shadow:0 15px 35px rgba(0,0,0,0.12);}
        .input-group{display:flex;gap:10px;margin-bottom:30px;align-items:center;flex-wrap:wrap;}
        .protocol-select{display:flex;align-items:center;background:#f1f5f9;border-radius:12px;padding:4px;border:1px solid #e2e8f0;}
        .protocol-select select{background:transparent;border:none;padding:12px 16px;font-size:16px;font-weight:500;color:#334155;}
        .input-wrapper{flex:1;position:relative;}
        .input-wrapper i{position:absolute;left:16px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:18px;}
        input[type="text"]{width:100%;padding:14px 16px 14px 48px;border:2px solid #e2e8f0;border-radius:12px;font-size:17px;background:#fff;transition:all .3s;}
        input[type="text"]:focus{border-color:var(--primary);box-shadow:0 0 0 4px rgba(99,102,241,0.15);outline:none;}
        button,.help-btn,.audit-btn,.donate-btn{position:relative;overflow:hidden;padding:15px 32px;background:var(--primary);color:white;border:none;border-radius:12px;cursor:pointer;font-size:17px;font-weight:600;transition:all .3s;display:flex;align-items:center;gap:8px;white-space:nowrap;}
        button:after{content:'';position:absolute;top:50%;left:50%;width:5px;height:5px;background:rgba(255,255,255,0.5);opacity:0;border-radius:50%;transform:translate(-50%,-50%) scale(1);transition:transform .6s,opacity .6s;}
        button:active:after{transform:translate(-50%,-50%) scale(30);opacity:0;}
        button:hover,.help-btn:hover,.audit-btn:hover,.donate-btn:hover{background:var(--primary-dark);transform:translateY(-2px);box-shadow:0 8px 20px rgba(99,102,241,0.3);}
        .result{margin-top:30px;padding:28px;border-radius:16px;background:#f8fafc;box-shadow:inset 0 3px 8px rgba(0,0,0,0.05);}
        .scanning-title{font-size:22px;font-weight:600;color:#1e2937;margin:25px 0 15px;text-align:center;background:#f0f9ff;padding:15px;border-radius:12px;}
        .speed-bar{height:10px;background:#e2e8f0;border-radius:999px;margin:15px 0;overflow:hidden;}
        .speed-fill{height:100%;transition:width .8s ease;}
        .good,.issue,.recommendation{padding:14px 18px;border-radius:12px;margin:12px 0;font-size:15.5px;display:flex;align-items:flex-start;gap:12px;}
        .good{background:#f0fdf4;color:var(--success);border-left:5px solid var(--success);}
        .issue{background:#fef2f2;color:var(--danger);border-left:5px solid var(--danger);}
        .recommendation{background:#fefce8;color:#854d0e;border-left:5px solid var(--warning);}
        .history-section{margin-top:40px;background:white;padding:25px;border-radius:16px;box-shadow:0 8px 25px rgba(0,0,0,0.08);}
        .history-section h3{margin:0 0 15px 0;color:#1e2937;}
        .history-list{display:flex;flex-wrap:wrap;gap:12px;}
        .history-item{background:#f8fafc;padding:12px 16px;border-radius:10px;border:1px solid #e2e8f0;cursor:pointer;transition:all .2s;white-space:nowrap;}
        .history-item:hover{background:#e0f2fe;border-color:var(--primary);transform:translateY(-2px);box-shadow:0 4px 15px rgba(99,102,241,0.2);}
        .footer{text-align:center;margin-top:35px;padding:28px;color:#64748b;font-size:14.5px;border-top:1px solid #e2e8f0;background:white;border-radius:20px;box-shadow:0 8px 25px rgba(0,0,0,0.08);}
        .footer a{color:var(--accent);text-decoration:none;margin:0 12px;}
        .footer a:hover{text-decoration:underline;}
        .lang-select select{padding:10px 16px;border-radius:10px;border:1px solid #cbd5e1;background:white;font-size:15px;}
        @media (max-width:768px){.input-group{flex-direction:column;}.protocol-select{width:100%;}button{width:100%;}}
    </style>
    <!-- JSON-LD микроразметка -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebApplication",
      "name": "SEO Analyzer",
      "url": "https://<?php echo $_SERVER['HTTP_HOST']; ?>",
      "description": "<?php echo htmlspecialchars($meta_desc); ?>",
      "applicationCategory": "UtilityApplication",
      "author": {"@type":"Person","name":"Ruslan Bilohash"}
    }
    </script>
</head>
<body>
<div class="header">
    <h1><i class="fas fa-chart-line"></i> <?php echo $t['title']; ?></h1>
    <div class="version"><?php echo $t['version']; ?></div>
    <div class="slogan"><?php echo $t['slogan']; ?></div>
</div>
<div class="container">