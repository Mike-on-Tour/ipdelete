# IP Address Deletion

![Version: 1.1.0](https://img.shields.io/badge/Version-1.1.0-green)  
   
![phpBB 3.2.x Compatible](https://img.shields.io/badge/phpBB-%3e=%203.2.4%20Compatible-009BDF)
![phpBB 3.3.x Compatible](https://img.shields.io/badge/phpBB-3.3.x%20Compatible-009BDF)  

[![Build Status](https://github.com/Mike-on-Tour/ipdelete/workflows/Tests/badge.svg)](https://github.com/GITHUB-USERNAME/REPO-NAME/actions)

IP Address Deletion is an extension to the phpBB bulletin board software which ensures privacy and data protection by deleting user related IP addresses in all database tables original to phpBB when a user gets deleted.

## Description
There are countries where the IP address an internet user uses is assumed to belong to his/her personal data and thus falls under privacy and data protection laws. Especially the supreme court of the European Union ruled that a user has a right to be informed if the IP address from which he/she logs into a web site is stored and that he/she has a right to have this information deleted if the respective service is no longer used. This means that the IP address still stored within phpBB's database must be deleted if a user gets deleted.  
phpBB stores user IP addresses in several tables and explicitly within the posts table it is not deleted if a user gets deleted and his/her posts are retained. This is what `IP Address Deletion` does.  
Starting with ver 1.1.0 `IP Address Deletion` checks for posts formerly assigned to the user to be deleted and deletes the IP address assigned to these posts since the IP address is not changed when a moderator assigns an existing post to another user.  
For this reason `IP Address Deletion` is limited to phpBB versions higher than or equal to 3.2.4, the phpBB version is checked during activation and if found unsatisfying activation is not possible!  
To fulfill this task `IP Address Deletion` is hooked into phpBB's `delete_user` function via the `core.delete_user_before` event. Everytime a user is deleted it replaces IP Addresses stored with this user's `user_id` with an empty string to ensure that nowhere within the phpBB core tables the IP address is stored any longer.

## Note
`IP Address Deletion` has no settings and is not visible anywhere in the ACP. After having been successfully enabled it just works in the background. Its existence is only visible through its presence in the table listing the enabled and active extensions.
