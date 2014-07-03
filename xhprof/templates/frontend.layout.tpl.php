<?php
namespace ay\xhprof;
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
    <link rel="stylesheet" href="<?=$config['url_static']?>css/frontend.css">
    <link rel="stylesheet" href="<?=$config['url_static']?>css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=$config['url_static']?>css/jquery-ui.custom.min.css">

    <script type="text/javascript" src="<?=$config['url_static']?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?=$config['url_static']?>js/jquery-ui.custom.min.js"></script>
    <script type="text/javascript" src="<?=$config['url_static']?>js/jquery.ba-throttle-debounce.min.js"></script>

    <script type="text/javascript" src="<?=$config['url_static']?>js/jquery.ay-toggle-element.js"></script>
    <script type="text/javascript" src="<?=$config['url_static']?>js/jquery.ay-table-sort.js"></script>
    <script type="text/javascript" src="<?=$config['url_static']?>js/jquery.ay-table-sticky.js"></script>

    <script type="text/javascript" src="<?=$config['url_static']?>js/d3.v2.js" charset="UTF-8"></script>
    <script type="text/javascript" src="<?=$config['url_static']?>js/crossfilter.v1.js"></script>
    <script type="text/javascript" src="<?=$config['url_static']?>js/d3.crossfilter.ay-histogram.js"></script>
    <script type="text/javascript" src="<?=$config['url_static']?>js/d3.ay-pie-chart.js"></script>

    <script type="text/javascript" src="<?=$config['url_static']?>js/frontend.js"></script>

    <title>XHProf.io</title>
</head>
<body class="template-<?=$template['file']?>">
    <?php require __DIR__ . '/header.inc.tpl.php';?>

    <?=\ay\display_messages()?>

    <?=$template['body']?>

    <?php require __DIR__ . '/footer.inc.tpl.php';?>
</body>
</html>
