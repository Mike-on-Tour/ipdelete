<?php
/**
*
* @package IP Address Deletion v1.2.0
* @copyright (c) 2020 - 2024 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\ipdelete\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class main_listener implements EventSubscriberInterface
{

	public static function getSubscribedEvents()
	{
		return [
			'core.delete_user_before'		=> 'delete_ip',
		];
	}

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/**
	 * Constructor
	 *
	 * @param \phpbb\db\driver\driver_interface $db	Database object
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db)
	{
		$this->db = $db;
	}


	/**
	* Delete the IP stored with the user_id(s) belonging to users to be deleted in all phpBB tables by setting this entry to an empty string to ensure data privacy
	*
	* @param array	$event	containing:
	*	@var string		mode				Mode of posts deletion (retain|delete)
	*	@var array		user_ids			ID(s) of the user(s) bound to be deleted
	*	@var bool		retain_username		True if username should be retained, false otherwise
	*	@var array		user_rows			Array containing data of the user(s) bound to be deleted (since 3.2.4-RC1)
	*
	*/
	public function delete_ip($event)
	{
		$user_ids = $event['user_ids'];

		$table_arr = [
			['table' => LOG_TABLE,				'ip_name' => 'log_ip',			'id_name' => 'user_id'],
			['table' => LOGIN_ATTEMPT_TABLE,	'ip_name' => 'attempt_ip',		'id_name' => 'user_id'],
			['table' => POLL_VOTES_TABLE,		'ip_name' => 'vote_user_ip',	'id_name' => 'vote_user_id'],
			['table' => POSTS_TABLE,			'ip_name' => 'poster_ip',		'id_name' => 'poster_id'],
			['table' => PRIVMSGS_TABLE,			'ip_name' => 'author_ip',		'id_name' => 'author_id'],
			['table' => SESSIONS_TABLE,			'ip_name' => 'session_ip',		'id_name' => 'session_user_id'],
		];

		foreach ($table_arr as $row)
		{
			$sql = "UPDATE " . $row['table'] . "
					SET " . $row['ip_name'] . " = ''
					WHERE " . $this->db->sql_in_set($row['id_name'], $user_ids);
			$this->db->sql_query($sql);
		}

		// check for posts assigned to another user
		$sql = "SELECT post_id, log_data FROM " . LOG_TABLE . " WHERE log_operation = 'LOG_MCP_CHANGE_POSTER'";
		$result = $this->db->sql_query($sql);
		$logs = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		if (count($logs) > 0)
		{
			$user_rows = $event['user_rows'];
			$posts_to_process = [];

			foreach ($user_ids as $user_id)
			{
				$username = $user_rows[$user_id]['username'];
				foreach ($logs as $row)
				{
					if (explode('"', $row['log_data'])[3] == $username)	// The second item of the log data array holds the username of the former author
					{
						$posts_to_process[] = $row['post_id'];
					}
				}
			}

			if (count($posts_to_process) > 0)
			{
				$sql = "UPDATE " . POSTS_TABLE . "
					SET poster_ip = ''
					WHERE " . $this->db->sql_in_set('post_id', $posts_to_process);
				$this->db->sql_query($sql);
			}
		}
	}

}
