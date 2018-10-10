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

?>
<legend class="uk-h4 uk-text-primary"><?php echo Text::_( 'COM_CONFIG_SITE_SETTINGS' ); ?></legend>

<?php foreach ( $this->form->getFieldset( 'site' ) as $field ) { ?>
<div class="uk-form-stacked uk-margin">
	<div class="uk-form-label"><?php echo $field->label; ?></div>
	<div class="uk-form-controls">
		<?php 
		if ( in_array( strtolower( $field->type ), [ 'list', 'accesslevel' ] ) )
		{
			$this->form->setFieldAttribute( $field->fieldname, 'class', 'uk-select' );
			echo $this->form->getField( $field->fieldname )->input;
		}
		else
		{
			echo $field->input;
		}
		?>
	</div>
</div>
<?php } ?>
