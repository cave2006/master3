<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_config
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

JHtml::_('formbehavior.chosen', 'select');

$fieldSets = $this->form->getFieldsets('params');

$tabs = [];

// Search for com_config field set
if (!empty($fieldSets['com_config']))
{
	echo $this->form->renderFieldset('com_config');
}
else
{
	foreach ($fieldSets as $name => $fieldSet)
	{
		$label = !empty($fieldSet->label) ? $fieldSet->label : 'COM_CONFIG_' . $name . '_FIELDSET_LABEL';

		if (isset($fieldSet->description) && trim($fieldSet->description))
		{
			echo '<p class="uk-text-small">' . $this->escape(Text::_($fieldSet->description)) . '</p>';
		}
		
		echo $this->form->renderFieldset($name);
	}
}
