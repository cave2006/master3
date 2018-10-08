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

HTMLHelper::_('behavior.formvalidator');
HTMLHelper::_('behavior.keepalive');

$user = Factory::getUser();

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
<form action="<?php echo Route::_('index.php?option=com_config'); ?>" method="post" name="adminForm" id="templates-form" class="form-validate">

	<div class="btn-toolbar" role="toolbar" aria-label="<?php echo Text::_('JTOOLBAR'); ?>" data-uk-margin>
		<button type="button" class="uk-button uk-button-default uk-flex-inline uk-flex-middle" onclick="Joomla.submitbutton('config.save.templates.apply')"><span class="uk-text-success uk-margin-small-right" data-uk-icon="icon:check"></span><span><?php echo Text::_('JSAVE') ?></span></button>
		<button type="button" class="uk-button uk-button-default uk-flex-inline uk-flex-middle" onclick="Joomla.submitbutton('config.cancel')"><span class="uk-text-danger uk-margin-small-right" data-uk-icon="icon:close"></span><span><?php echo Text::_('JCANCEL') ?></span></button>
	</div>

	<hr class="hr-condensed" />

	<div id="page-site" class="tab-pane active">
		<?php // Get the menu parameters that are automatically set but may be modified.
		echo $this->loadTemplate('options'); ?>
	</div>

	<input type="hidden" name="task" value="" />
	<?php echo HTMLHelper::_('form.token'); ?>

</form>
