<?php $this->display('header', array('title' => 'Менеджер продажи рекламы')) ?>

<?php if ($error) echo '<div class="error">'. $error .'</div>' ?>

<?php $this->display('title', array('text' => ($action == 'add' ? 'Добавление' : 'Редактирование'))) ?>
<div class="block">
Стоимость 10 баллов.
</div>
<form action="<?php echo a_url('ads_manager/user/link_edit', 'link_id='. $_GET['link_id']) ?>" method="post">
<div class="menu">
			Название ссылки: <br />
			<input type="text" name="title" value="<?php echo $link['title'] ?>" /><br />

			URL: <br />
			<input name="url" type="text" value="<?php echo $link['url'] ?>"><br />
			Тексты ссылки (новый текст с новой строки)<br />
			<textarea name="names" wrap="off"><?php echo stripslashes($link['names']) ?></textarea><br />
			Площадка<br />
			<select size="1" name="area_id">
			<?php foreach($areas as $area): ?>
  				<option value="<?php echo $area['area_id'] ?>"<?php if($link['area_id'] == $area['area_id']): ?> selected="selected"<?php endif; ?>><?php echo $area['title'] ?></option>
  			<?php endforeach; ?>
			</select>
		</p>
   	</div>
</div>
        <input type="submit" name="submit" value="<?php echo ($action == 'add' ? 'Добавить' : 'Изменить') ?>">
</form>
<div class="block">
<a href="<?php echo a_url('ads_manager/user') ?>">Менеджер</a><br />
<a href="<?php echo a_url('user/profile') ?>">В кабинет</a><br />
<a href="<?php echo URL ?>">На главную</a>
</div>
<?php $this->display('footer') ?>
