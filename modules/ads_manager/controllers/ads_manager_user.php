<?php

defined('IN_SYSTEM') or die('<b>403<br />Запрет доступа!</b>');


/**
 * Пользовательский контроллер менеджера продажи рекламы
 */
class Ads_Manager_User_Controller extends Controller {
	/**
	 * Уровень пользовательского доступа
	 */
	public $access_level = 5;

	/**
	 * Метод по умолчанию
	 */
	public function action_index() {
		$this->action_list();
	}
		public function action_list() {
		
		$result = $this->db->query("SELECT * FROM #__ads_manager_links WHERE user_id = '".USER_ID."' ORDER BY position ASC");
			while ($link = $this->db->fetch_array($result)) {
				$links[] = $link;
			}
					// Назначение переменных
		$this->tpl->assign(array(
			'links' => $links
		));

		// Вывод шаблона
		$this->tpl->display('list');
		}
	/**
	 * Добавление / редактирование ссылки
	 */
	public function action_link_edit() {
		if (is_numeric($_GET['link_id'])) {
			if (!$link = $this->db->get_row("SELECT * FROM #__ads_manager_links WHERE link_id = '".intval($_GET['link_id'])."' AND user_id = '". USER_ID ."'"))
				a_error('Редактируемая ссылка не найдена!');
			$action = 'edit';
		}
		else {
			$link = array();
			$action = 'add';
		}

		if (isset($_POST['submit'])) {
			if (empty($_POST['title'])) {
				$this->error .= 'Укажите заголовок ссылки<br />';
			}
			if (empty($_POST['url'])) {
				$this->error .= 'Укажите URL ссылки<br />';
			}
			if (empty($_POST['names'])) {
				$this->error .= 'Укажите текст ссылки<br />';
			}
			if (!$area = $this->db->get_row("SELECT * FROM #__ads_manager_areas WHERE area_id = '".a_safe($_POST['area_id'])."'")) {
				$this->error .= 'Площадка с данным идентификатором не найдена!<br />';
			}

			if (!$this->error) {
				if ($action == 'add') {
					if ($this->user['rating'] < 10)
					a_error("Недостаточно баллов на счете!<br />Баллы даются за активность.");
					$position = $this->db->get_one("SELECT MAX(position) FROM #__ads_manager_links WHERE area_id = '".$area['area_id']."'") + 1;
	
					$this->db->query("INSERT INTO #__ads_manager_links SET
						title = '". a_safe($_POST['title'])."',
						url = '". a_safe($_POST['url'])."',
						names = '". a_safe($_POST['names'])."',
						area_id = '". $area['area_id']."',
						user_id = '". USER_ID ."',
						area_ident = '". $area['ident']."',
						position = '". $position."'
					");
					user::rating_update(-10, USER_ID);
					$message = 'Ссылка успешно добавлена!';
				}
				if ($action == 'edit') {
					$this->db->query("UPDATE #__ads_manager_links SET
						title = '". a_safe($_POST['title'])."',
						url = '". a_safe($_POST['url'])."',
						names = '". a_safe($_POST['names'])."',
						area_id = '". $area['area_id']."',
						user_id = '". USER_ID ."',
						area_ident = '". $area['ident']."'
						WHERE link_id = '". $link['link_id']."'"
					);
					$message = 'Ссылка успешно изменена!';
				}
	
				a_notice($message, a_url('ads_manager/user'));
			}
		}
		if (!isset($_POST['submit']) || $this->error) {
			$areas = $this->db->get_array("SELECT * FROM #__ads_manager_areas");
	
			$this->tpl->assign(array(
			'error' => $this->error,
			'link' => $link,
			'action' => $action,
			'areas' => $areas
			));
	
			$this->tpl->display('link_edit');
		}
	}
		public function action_delete() {
		
		if (!$link = $this->db->get_row("SELECT * FROM #__ads_manager_links WHERE link_id = '".intval($_GET['link_id'])."' AND user_id = '". USER_ID ."'"))
				a_error('Удаляемая ссылка не найдена!');
		$this->db->query("DELETE FROM #__ads_manager_links WHERE link_id = '".intval($_GET['link_id'])."'");
		a_notice('Ссылка успешно удалена!', a_url('ads_manager/user'));
}
}
?>