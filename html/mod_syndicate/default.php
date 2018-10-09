<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_syndicate
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

?>
<a href="<?php echo $link; ?>" class="syndicate-module<?php echo $moduleclass_sfx; ?>">
	<?php
	echo HTMLHelper::_( 'image', 'system/livemarks.png', 'feed-image', null, true );
	if ( $params->get( 'display_text', 1 ) )
	{
		echo '<span>';
		if ( str_replace( ' ', '', $text ) !== '' )
		{
			echo $text;
		}
		else
		{
			echo Text::_( 'MOD_SYNDICATE_DEFAULT_FEED_ENTRIES' );
		}
		echo '</span>';
	}
	?>
</a>
