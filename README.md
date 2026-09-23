# IP Address Deletion

![Version: 1.3.0](https://img.shields.io/badge/Version-1.3.0-green)  
   
![phpBB >= 3.3.9, < 3.4.0@dev](https://img.shields.io/badge/phpBB->=3.3.9,%20<3.4.0@dev-009BDF)  

![PHP >= 8.1.33, < 8.7.0@dev](https://img.shields.io/badge/PHP->=8.1.33,%20<8.7.0@dev-blueviolet)

[![Build Status](https://github.com/Mike-on-Tour/ipdelete/workflows/Tests/badge.svg)](https://github.com/Mike-on-Tour/ipdelete/actions)

IP Address Deletion is an extension to the phpBB bulletin board software which ensures privacy and data protection by deleting user related IP addresses in all database tables original to phpBB when a user gets deleted.

## Description
There are countries where the IP address an internet user uses is assumed to belong to his/her personal data and thus falls under privacy and data protection laws (e.g. GDPR Recital 30). Especially the supreme court of the European Union ruled that a user has a right to be informed if the IP address from which he/she logs into a web site is stored and that he/she has a right to have this information deleted if the respective service is no longer used. This means that the IP address still stored within phpBB's database must be deleted if a user gets deleted.  
phpBB stores user IP addresses in several tables and explicitly within the posts table it is not deleted if a user gets deleted and his/her posts are retained. This is what `IP Address Deletion` does.  
Starting with ver 1.1.0 `IP Address Deletion` checks for posts formerly assigned to the user to be deleted and deletes the IP address assigned to these posts since the IP address is not changed when a moderator assigns an existing post to another user.  
To fulfill this task `IP Address Deletion` is hooked into phpBB's `delete_user` function via the `core.delete_user_before` event. Everytime a user is deleted it replaces IP Addresses stored with this user's `user_id` with an empty string to ensure that nowhere within the phpBB core tables the IP address is stored any longer.  
The phpBB version is checked during activation and if found unsatisfying activation is not possible!  

## Note
`IP Address Deletion` has no settings and is not visible anywhere in the ACP. After having been successfully enabled it just works in the background. Its existence is only visible through its presence in the table listing the enabled and active extensions.
