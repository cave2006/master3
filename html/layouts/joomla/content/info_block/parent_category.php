<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright ( C ) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined( 'JPATH_BASE' ) or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

?>
			<dd class="parent-category-name">
				<?php 
				$title = $this->escape( $displayData[ 'item' ]->parent_title );
				if ( $displayData[ 'params' ]->get( 'link_parent_category' ) && !empty( $displayData[ 'item' ]->parent_slug ) )
				{
					$url = '<a href="' . Route::_( ContentHelperRoute::getCategoryRoute( $displayData[ 'item' ]->parent_slug ) ) . '" itemprop="genre">' . $title . '</a>';
					echo Text::sprintf( 'COM_CONTENT_PARENT', $url );
				}
				else
				{
					echo Text::sprintf( 'COM_CONTENT_PARENT', '<span itemprop="genre">' . $title . '</span>' );
				}
				?>
			</dd>