<?php defined('_JEXEC') or die;
/*
 * @package     Joomla.Site
 * @subpackage  Templates.master3
 * @copyright   Copyright (C) 2018 Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

use Joomla\CMS\Version;
use Joomla\CMS\Filesystem\Path;

class master3InstallerScript
{
	function preflight( $type, $parent )
	{
		$ver = new Version();
	
		$minJVer = $parent->get( 'manifest' )->attributes()->version;

		if( version_compare( $ver->getShortVersion(), $minJVer, 'lt' ) )
		{
			\JError::raiseWarning( null, 'Cannot install Master3 template in a Joomla release prior to ' . $minJVer );
			return false;
		}
	}

	function postflight( $type, $parent )
	{
		$srcfile = Path::clean( __DIR__ . '/script/tabs.php' );
		$dstfile = Path::clean( JPATH_ROOT . '/layouts/joomla/form/field/subform/tabs.php' );
		if ( !is_dir( dirname( $dstfile ) ) )
		{
			mkdir( dirname( $dstfile ), 0755, true);
		}
		if ( !copy ( $srcfile, $dstfile ) )
		{
			echo '<p>Do not copiig file tabs.php</p>';
		}
		
		$srcfile = Path::clean( __DIR__ . '/script/section.php' );
		$dstfile = Path::clean( JPATH_ROOT . '/layouts/joomla/form/field/subform/tabs/section.php' );
		if ( !is_dir( dirname( $dstfile ) ) )
		{
			mkdir( dirname( $dstfile ), 0755, true);
		}
		if ( !copy ( $srcfile, $dstfile ) )
		{
			echo '<p>Do not copiig file section.php</p>';
		}
		
		$srcfile = Path::clean( __DIR__ . '/script/subform-tabs.css' );
		$dstfile = Path::clean( JPATH_ROOT . '/media/system/css/subform-tabs.css' );
		if ( !is_dir( dirname( $dstfile ) ) )
		{
			mkdir( dirname( $dstfile ), 0755, true);
		}
		if ( !copy ( $srcfile, $dstfile ) )
		{
			echo '<p>Do not copiig file subform-tabs.css</p>';
		}

		$srcfile = Path::clean( JPATH_ROOT . '/templates/master3/layouts/template.default-original.php' );
		$dstfile = Path::clean( JPATH_ROOT . '/templates/master3/layouts/template.default.php' );
		if ( !file_exists( $dstfile ) )
		{
			if ( !copy ( $srcfile, $dstfile ) )
			{
				echo '<p>Do not copiig file template.default-original.php => template.default.php in /templates/master3/layouts/, please do this manually</p>';
			}
		}
	}
}
