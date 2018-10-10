<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\Filesystem\Path;

include_once realpath( Path::clean( __DIR__ . '/../../../config/config.php' ) ); 

$templateConfig = \Master3Config::getInstance();

$denyUserAuthorization = $templateConfig->getDUA();

if ( !$denyUserAuthorization )
{

	$cookieLogin = $this->user->get( 'cookieLogin' );

	if ( !empty( $cookieLogin ) || $this->user->get( 'guest' ) )
	{
		// The user is not logged in or needs to provide a password.
		echo $this->loadTemplate( 'login' );
	}
	else
	{
		// The user is already logged in.
		echo $this->loadTemplate( 'logout' );
	}

}