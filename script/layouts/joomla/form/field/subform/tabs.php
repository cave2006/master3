<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::_( 'behavior.tabstate' );

/**
 * Make thing clear
 *
 * @var Form    $tmpl             The Empty form for template
 * @var array   $forms            Array of JForm instances for render the rows
 * @var bool    $multiple         The multiple state for the form field
 * @var int     $min              Count of minimum repeating in multiple mode
 * @var int     $max              Count of maximum repeating in multiple mode
 * @var string  $fieldname        The field name
 * @var string  $control          The forms control
 * @var string  $label            The field label
 * @var string  $description      The field description
 * @var array   $buttons          Array of the buttons that will be rendered
 * @var bool    $groupByFieldset  Whether group the subform fields by it`s fieldset
 */

extract($displayData);

HTMLHelper::_( 'stylesheet', 'system/subform-tabs.css', [ 'version' => 'auto', 'relative' => true ] );

/*if ($multiple)
{
	HTMLHelper::_( 'script', 'system/subform-tabs.js', [ 'version' => 'auto', 'relative' => true ] );
}
*/

$sublayout = 'section';

if ( !$forms )
{
	echo '<div class="alert alert-warning uk-alert uk-alert-warning">Subform elements not found.</div>';
}
else
{
	$fieldset = $forms[0]->getFieldset('');
	$keyField = array_shift( $fieldset );

	$this->tab_name = 'subform-tabset-' . $fieldname;
	
	echo '<div class="subform-tabs tabs-left">';
	
	echo HTMLHelper::_( 'bootstrap.startTabSet', $this->tab_name, [ 'active' => (string)'subform-tab-' . $fieldname. '-' . $keyField->fieldname . '-0' ] );
	
	foreach ($forms as $k => $form)
	{
		echo HTMLHelper::_( 'bootstrap.addTab', $this->tab_name, (string)'subform-tab-' . $fieldname. '-' . $keyField->fieldname . '-' . $k, $form->getValue( $keyField->fieldname, $keyField->group ? $keyField->group : null ) );
		
		echo $this->sublayout($sublayout, array('form' => $form, 'basegroup' => $fieldname, 'group' => $fieldname . $k, 'buttons' => $buttons));
		echo HTMLHelper::_( 'bootstrap.endTab' );
	}
	
	echo HTMLHelper::_( 'bootstrap.endTabSet' );
	
	echo '</div>';
}