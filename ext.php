<?php
/**
*
* @package IP Address Deletion v1.2.0
* @copyright (c) 2020 - 2024 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\ipdelete;

class ext extends \phpbb\extension\base
{
	protected $error_message = [];
	protected $phpbb_min_ver = '3.2.4';
	protected $phpbb_below_ver = '3.4.0@dev';
	protected $php_min_ver = '7.2.0';
	protected $php_below_ver = '8.5.0@dev';

	public function is_enableable()
	{
		// Set the language element depending on the phpBB version (3.1.x uses the $user->lang object)
		if (phpbb_version_compare(PHPBB_VERSION, '3.2.0', '<'))
		{
			$language = $this->container->get('user');
			$language->add_lang_ext('mot/ipdelete', 'mot_ipdelete_ext_enable_error');
		}
		else
		{
			$language = $this->container->get('language');
			$language->add_lang('mot_ipdelete_ext_enable_error', 'mot/ipdelete');
		}
		$ext_name = $language->lang('MOT_IPDELETE_EXT_NAME');

		// Check requirements
		if (!$this->phpbb_requirement())
		{
			$this->error_message[] = $language->lang('MOT_IPDELETE_ERROR_MESSAGE_PHPBB_VERSION', $this->phpbb_min_ver, $this->phpbb_below_ver);
		}

		if (!$this->php_requirement())
		{
			$this->error_message[] = $language->lang('MOT_IPDELETE_PHP_VERSION_ERROR', $this->php_min_ver, $this->php_below_ver);
		}

		if (!empty($this->error_message))
		{
			// Insert general message at the beginning
			array_unshift($this->error_message, $language->lang('MOT_IPDELETE_ERROR_EXTENSION_NOT_ENABLE', $ext_name));
			// phpBB versions before 3.3.0 must use 'trigger_error'
			if (phpbb_version_compare(PHPBB_VERSION, '3.3.0', '<'))
			{
				$this->error_message = implode('<br>', $this->error_message);
				trigger_error($this->error_message, E_USER_WARNING);
			}
		}
		return empty($this->error_message) ? true : $this->error_message;
	}

	protected function phpbb_requirement()
	{
		return (phpbb_version_compare(PHPBB_VERSION, $this->phpbb_min_ver, '>=') && phpbb_version_compare(PHPBB_VERSION, $this->phpbb_below_ver, '<'));
	}

	protected function php_requirement()
	{
		return phpbb_version_compare(PHP_VERSION, $this->php_min_ver, '>=') && phpbb_version_compare(PHP_VERSION, $this->php_below_ver, '<');
	}
}
