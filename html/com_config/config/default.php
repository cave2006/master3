<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_config
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined( '_JEXEC' ) or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

HTMLHelper::_( 'behavior.formvalidator' );
HTMLHelper::_( 'behavior.keepalive' );

Factory::getDocument(  )->addScriptDeclaration( "
    Joomla.submitbutton = function( task )
    {
        if ( task == 'config.cancel' || document.formvalidator.isValid( document.getElementById( 'application-form' ) ) ) {
            Joomla.submitform( task, document.getElementById( 'application-form' ) );
        }
    }
" );

?>
<h1 class="uk-article title"><?php echo Text::_( 'COM_CONFIG_CONFIGURATION' ); ?></h1>

<form action="<?php echo Route::_( 'index.php?option=com_config' ); ?>" id="application-form" method="post" name="adminForm" class="form-validate">

    <ul data-uk-tab="connect:#com-config-config-content">
        <li><a href="#"><?php echo Text::_( 'COM_CONFIG_SITE_SETTINGS' ); ?></a></li>
        <li><a href="#"><?php echo Text::_( 'COM_CONFIG_METADATA_SETTINGS' ); ?></a></li>
        <li><a href="#"><?php echo Text::_( 'COM_CONFIG_SEO_SETTINGS' ); ?></a></li>
    </ul>
    <ul id="com-config-config-content" class="uk-switcher">
        <li><?php echo $this->loadTemplate( 'site' ); ?></li>
        <li><?php echo $this->loadTemplate( 'metadata' ); ?></li>
        <li><?php echo $this->loadTemplate( 'seo' ); ?></li>
    </ul>

    <hr class="uk-margin-medium">

    <div class="uk-flex">
        <button type="button" class="uk-button uk-button-primary uk-margin-small-right uk-flex-inline uk-flex-middle" onclick="Joomla.submitbutton( 'config.save.config.apply' )"><?php echo Text::_( 'JSAVE' ) ?></button>
        <button type="button" class="uk-button uk-flex-inline uk-flex-middle" onclick="Joomla.submitbutton( 'config.cancel' )"><?php echo Text::_( 'JCANCEL' ) ?></button>
    </div>

    <input type="hidden" name="task" value="" />
    <?php echo HTMLHelper::_( 'form.token' ); ?>

</form>
