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
	protected $files = [
		'/layouts/joomla/form/field/subform/tabs.php',
		'/layouts/joomla/form/field/subform/tabs/section.php',
		'/media/system/css/subform-tabs.css',
		'/libraries/master3/fields/aes.css',
		'/libraries/master3/fields/aes.js',
		'/libraries/master3/fields/aes.php',
		'/libraries/master3/fields/subformfiles.php',
		'/libraries/master3/fields/subformlayouts.php',
		'/libraries/master3/fields/subformmenus.php',
		'/libraries/master3/fields/subformmodules.php',
		'/libraries/master3/fields/subformoffcanvas.php',
		'/libraries/master3/fields/subformsections.php',
		'/libraries/master3/fields/versions.php',
		'/libraries/master3/forms/files.xml',
		'/libraries/master3/forms/layouts.xml',
		'/libraries/master3/forms/menus.xml',
		'/libraries/master3/forms/modules.xml',
		'/libraries/master3/forms/offcanvas.xml',
		'/libraries/master3/forms/sections.xml',
		'/libraries/master3/config.php'
	];

	protected $dirs = [
		'/layouts/joomla/form/field/subform/tabs/',
		'/libraries/master3/fields/',
		'/libraries/master3/forms/',
		'/libraries/master3/'
	];
	
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
		$msg = '';
		
		foreach ( $this->files as $file )
		{
			$srcfile = Path::clean( __DIR__ . '/script' . $file );
			$dstfile = Path::clean( JPATH_ROOT . $file );
			if ( !is_dir( dirname( $dstfile ) ) )
			{
				mkdir( dirname( $dstfile ), 0755, true);
			}
			if ( !copy ( $srcfile, $dstfile ) )
			{
				$msg .= '<p>Do not copiig file ' . $file . '</p>';
			}
		}

		$srcfile = Path::clean( JPATH_ROOT . '/templates/master3/layouts/template.default-original.php' );
		$dstfile = Path::clean( JPATH_ROOT . '/templates/master3/layouts/template.default.php' );
		if ( !file_exists( $dstfile ) )
		{
			if ( !copy ( $srcfile, $dstfile ) )
			{
				$msg .= '<p>Do not copiig file template.default-original.php => template.default.php in /templates/master3/layouts/, please do this manually</p>';
			}
		}

		if ( $msg )
		{
			\JError::raiseWarning( null, $msg );
			return false;
		}
	}

	function uninstall( $parent )
	{
		foreach ( $this->files as $file )
		{
			$dst = Path::clean( JPATH_ROOT . $file );
			@unlink( $dst );
		}
		foreach ( $this->dirs as $dir )
		{
			$dst = Path::clean( JPATH_ROOT . $dir );
			@rmdir( $dst );
		}
	}
	
}
