<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?= $brand['link'] ?>"><?= $brand['name'] ?></a>
		</div>
		<div id="navbar" class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<?php foreach ($menus as $menu): ?>
				<li class="<?= ($menu['name'] == $this->router->fetch_method())?'active':'' ?>"><a href="<?= $menu['link'] ?>"><?= $menu['text'] ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</nav>
