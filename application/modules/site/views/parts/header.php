<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php if (isset($meta) && is_array($meta)) : ?>
	<?php foreach ($meta as $tag) : ?>
		<meta name="<?= $tag['name'] ?>" content="<?= $tag['content'] ?>">
	<?php endforeach; ?>
<?php endif; ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="<?= base_url('public/CSS-frameworks/Bootstrap/v3/dist/css/bootstrap.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('public/assets/css/style.css') ?>">
<title><?= $title ?></title>
