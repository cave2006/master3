<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_config
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

HTMLHelper::_( 'behavior.formvalidator' );
HTMLHelper::_( 'behavior.keepalive' );

Factory::getDocument()->addScriptDeclaration("
	Joomla.submitbutton = function(task)
	{
		if (task == 'config.cancel' || document.formvalidator.isValid(document.getElementById('templates-form')))
		{
			Joomla.submitform(task, document.getElementById('templates-form'));
		}
	}
");
?>
<h1 class="uk-article-title"><?php echo Text::_( 'COM_CONFIG_TEMPLATE_SETTINGS' ); ?></h1>

<form action="<?php echo Route::_( 'index.php?option=com_config' ); ?>" method="post" name="adminForm" id="templates-form" class="form-validate">

	<?php
	// Get the menu parameters that are automatically set but may be modified.
	echo $this->loadTemplate( 'options' );
	?>

	<hr class="uk-margin-medium">

	<div class="uk-flex">
		<button type="button" class="uk-button uk-button-primary uk-margin-small-right uk-flex-inline uk-flex-middle" onclick="Joomla.submitbutton('config.save.templates.apply')"><?php echo Text::_( 'JSAVE' ) ?></button>
		<button type="button" class="uk-button uk-flex-inline uk-flex-middle" onclick="Joomla.submitbutton('config.cancel')"><?php echo Text::_( 'JCANCEL' ) ?></button>
	</div>

	<input type="hidden" name="task" value="" />
	<?php echo HTMLHelper::_( 'form.token' ); ?>

</form>
