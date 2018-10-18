<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Content.pagenavigation
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$lang = JFactory::getLanguage(); ?>

<div class="uk-flex uk-flex-between uk-margin">
	
	<?php if ($row->prev) { ?>
	<a class="uk-button uk-button-link uk-flex uk-flex-middle" data-uk-tooltip="<?php echo htmlspecialchars($rows[$location-1]->title); ?>" aria-label="<?php echo JText::sprintf('JPREVIOUS_TITLE', htmlspecialchars($rows[$location-1]->title)); ?>" href="<?php echo $row->prev; ?>" rel="prev">
		<span data-uk-icon="icon:chevron-left" aria-hidden="true"></span>
		<span aria-hidden="true"><?php echo $row->prev_label; ?></span>'
	</a>
	<?php } ?>
	
	<?php if ($row->next) { ?>
	<a class="uk-button uk-button-link uk-flex uk-flex-middle" data-uk-tooltip="<?php echo htmlspecialchars($rows[$location+1]->title); ?>" aria-label="<?php echo JText::sprintf('JNEXT_TITLE', htmlspecialchars($rows[$location+1]->title)); ?>" href="<?php echo $row->next; ?>" rel="next">
		<span aria-hidden="true"><?php echo  $row->next_label; ?></span>
		<span data-uk-icon="icon:chevron-right" aria-hidden="true"></span>
	</a>
	<?php } ?>
</div>
