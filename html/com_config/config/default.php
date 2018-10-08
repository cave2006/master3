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

Factory::getDocument()->addScriptDeclaration("
	Joomla.submitbutton = function(task)
	{
		if (task == 'config.cancel' || document.formvalidator.isValid(document.getElementById('application-form'))) {
			Joomla.submitform(task, document.getElementById('application-form'));
		}
	}
");

?>
<form action="<?php echo Route::_('index.php?option=com_config'); ?>" id="application-form" method="post" name="adminForm" class="form-validate">

	<div class="btn-toolbar" role="toolbar" aria-label="<?php echo Text::_('JTOOLBAR'); ?>" data-uk-margin>
		<button type="button" class="uk-button uk-button-default uk-flex-inline uk-flex-middle" onclick="Joomla.submitbutton('config.save.config.apply')"><span class="uk-text-success uk-margin-small-right" data-uk-icon="icon:check"></span><span><?php echo Text::_('JSAVE') ?></span></button>
		<button type="button" class="uk-button uk-button-default uk-flex-inline uk-flex-middle" onclick="Joomla.submitbutton('config.cancel')"><span class="uk-text-danger uk-margin-small-right" data-uk-icon="icon:close"></span><span><?php echo Text::_('JCANCEL') ?></span></button>
	</div>

	<hr class="hr-condensed" />

	<div id="page-site" class="tab-pane active">
		<?php echo $this->loadTemplate('site'); ?>
		<?php echo $this->loadTemplate('metadata'); ?>
		<?php echo $this->loadTemplate('seo'); ?>
	</div>

	<input type="hidden" name="task" value="" />
	<?php echo HTMLHelper::_('form.token'); ?>

</form>
