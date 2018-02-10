<?php $this->display('header', array('title' => 'Заказ рекламы')) ?>

<?php $this->display('title', array('text' => 'Реклама на сайте')) ?>

<?php if($links): ?>
<?php foreach($links as $link): ?>

<div class="menu">
			Имя: <b><?php echo $link['title'] ?></b><br />
			Адрес: <?php echo $link['url'] ?><br />
			Названия ссылки: <?php echo nl2br($link['names']) ?><br />
			Площадка: <?php echo ($link['area_ident'] == 'all_pages_up' ? 'Верх всех страниц' : 'Низ всех страниц') ?><br />
			Переходов: <?php echo $link['count_all'] ?><br />
			<a href="<?php echo a_url('ads_manager/user/link_edit', 'link_id='. $link['link_id']) ?>">Изменить</a> | <a href="<?php echo a_url('ads_manager/user/delete', 'link_id='. $link['link_id']) ?>">Удалить</a>
</div>

<?php endforeach; ?>
<?php else: ?>
<div class="menu">
<p>Ссылок нет</p>
</div>
<?php endif; ?>

<div class="block">
<a href="<?php echo a_url('ads_manager/user/link_edit') ?>">Добавить</a><br />
<a href="<?php echo a_url('user/profile') ?>">В кабинет</a><br />
<a href="<?php echo URL ?>">На главную</a>
</div>

<?php $this->display('footer') ?>