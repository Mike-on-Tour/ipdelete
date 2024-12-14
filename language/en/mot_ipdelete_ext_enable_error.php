<?php
/**
*
* @package IP Address Deletion v1.2.0
* @copyright (c) 2020 - 2024 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'MOT_IPDELETE_EXT_NAME'							=> 'IP Address Deletion',
	'MOT_IPDELETE_ERROR_EXTENSION_NOT_ENABLE'		=> 'The extension „%1$s“ can not be enabled. Please check whether the necessary requirements for this extension are satisfied.',
	'MOT_IPDELETE_ERROR_MESSAGE_PHPBB_VERSION'		=> 'Minimum version of phpBB required is „%1$s“ but less than „%2$s“',
	'MOT_IPDELETE_PHP_VERSION_ERROR'				=> 'Minimum version of PHP is „%1$s“ but less than „%2$s“',
]);
