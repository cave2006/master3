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
<legend class="uk-h4 uk-text-primary"><?php echo Text::_( 'COM_CONFIG_METADATA_SETTINGS' ); ?></legend>

<?php foreach ( $this->form->getFieldset( 'metadata' ) as $field ) { ?>
<div class="uk-form-stacked uk-margin">
    <div class="uk-form-label"><?php echo $field->label; ?></div>
    <div class="uk-form-controls"><?php echo $field->input;?></div>
</div>
<?php } ?>
