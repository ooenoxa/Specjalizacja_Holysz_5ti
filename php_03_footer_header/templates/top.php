<!doctype html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php out($page_description); if (!isset($page_description)) {  ?> Witam <?php } ?>">
	<title><?php out($page_title); if (empty($page_title)) {  ?> Bank Kredytowy <?php } ?></title>
	<link rel="stylesheet" href="<?php print(_APP_URL); ?>/css/main.css">	
</head>
<body>

<div class="header">
	<h1><?php out($page_title); if (!isset($page_title)) {  ?> Bank Kredytowy <?php } ?></h1>
	<h2><?php out($page_header); if (!isset($page_header)) {  ?>Serdecznie Witamy<?php } ?></h1>
	<p>
		<?php out($page_description); if (!isset($page_description)) {  ?> To oficjalna strona naszego banku <?php } ?>
	</p>
</div>

<div class="content">