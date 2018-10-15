<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

?>
			<dd class="create">
					<span data-uk-icon="icon:calendar"></span>
					<time datetime="<?php echo HTMLHelper::_( 'date', $displayData[ 'item' ]->created, 'c' ); ?>" itemprop="dateCreated">
						<?php echo Text::sprintf( 'COM_CONTENT_CREATED_DATE_ON', HTMLHelper::_( 'date', $displayData[ 'item' ]->created, Text::_( 'd.m.Y' ) ) ); ?>
					</time>
			</dd>