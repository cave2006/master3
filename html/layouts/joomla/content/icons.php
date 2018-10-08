<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright ( C ) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined( 'JPATH_BASE' ) or die;

use Joomla\CMS\HTML\HTMLHelper;

$canEdit = $displayData[ 'params' ]->get( 'access-edit' );
$articleId = $displayData[ 'item' ]->id;

?>

<div class="uk-margin-small uk-flex">
	<?php
	if ( empty( $displayData[ 'print' ] ) )
	{
		if ( $canEdit || $displayData[ 'params' ]->get( 'show_print_icon' ) || $displayData[ 'params' ]->get( 'show_email_icon' ) )
		{
			if ( $displayData[ 'params' ]->get( 'show_print_icon' ) )
			{
				echo '<div class="uk-margin-small-right">' . HTMLHelper::_( 'icon.print_popup', $displayData[ 'item' ], $displayData[ 'params' ] ) . '</div>';
			}
			
			if ( $displayData[ 'params' ]->get( 'show_email_icon' ) )
			{
				echo '<div class="uk-margin-small-right">' . HTMLHelper::_( 'icon.email', $displayData[ 'item' ], $displayData[ 'params' ] ) . '</div>';
			}
			
			if ( $canEdit )
			{
				echo '<div class="uk-margin-small-right">' . HTMLHelper::_( 'icon.edit', $displayData[ 'item' ], $displayData[ 'params' ] ) . '</div>';
			}
		}
	}
	else
	{
		echo HTMLHelper::_( 'icon.print_screen', $displayData[ 'item' ], $displayData[ 'params' ] );
	}
	?>
</div>
