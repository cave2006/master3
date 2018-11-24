<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.master3
 *
 * @copyright   Copyright (C) 2018 Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

defined('_JEXEC') or die;

use \Joomla\CMS\Filesystem\Path;

include_once realpath( Path::clean( JPATH_LIBRARIES . '/master3/config.php' ) ); 

function modChrome_master3($module, &$params, &$attribs)
{
    $config = \Master3Config::getInstance();
    $masterParams = $config->getModuleParams( $module->id );
    
    $moduleTag = 'div';
    if ( $module->module === 'mod_menu' )
    {
        $moduleTag = 'nav';
    }

    $moduleClass = [];
    $moduleClass[] = 'tm-pos-' . $module->position;
    $moduleClass[] = trim( $masterParams->display );
    $moduleClass[] = trim( $masterParams->class );
    $moduleClass[] = htmlspecialchars( $params->get( 'moduleclass_sfx', '' ), ENT_COMPAT, 'UTF-8' );
    $moduleClass = trim( implode( ' ', $moduleClass ) );

    $titleTag = $masterParams->titleTag !== 'module' ? $masterParams->titleTag : htmlspecialchars( $params->get( 'header_tag', 'h3' ) );
    $titleClass = trim( $masterParams->titleClass . ' ' . htmlspecialchars( $params->get( 'header_class', '' ), ENT_COMPAT, 'UTF-8' ) );
    $titleClass = $titleClass ? ' class="' . $titleClass . '"' : '';

    if ( $module->content )
    {
        echo '<' . $moduleTag . '>';
        
        if ( $masterParams->align !== '' )
        {
            echo '<div class="uk-flex ' . $masterParams->align . ' uk-width">';
        }
        
        echo '<div class="' . $moduleClass . '">';
        
        if ( $module->showtitle && $masterParams->titleTag !== 'none' )
        {
            echo '<' . $titleTag . $titleClass . '>' . $module->title . '</' . $titleTag . '>';
        }

        echo $module->content;
        
        echo '</div>';

        if ( $masterParams->align !== '' )
        {
            echo '</div>';
        }
        
        echo '</' . $moduleTag . '>';
    }
}


function modChrome_navbar($module, &$params, &$attribs)
{
    $moduleTag = 'div';
    $moduleClass = [];
    $moduleClass[] = 'tm-pos-' . $module->position;
    $moduleClass[] = $module->module === 'mod_menu' && in_array( $module->position, [ 'navbar-left', 'navbar-center', 'narbar-right' ] ) ? '' : 'uk-navbar-item';
    $moduleClass[] = $module->module === 'mod_menu' ? '' : htmlspecialchars( $params->get( 'moduleclass_sfx', '' ), ENT_COMPAT, 'UTF-8' );
    $moduleClass = trim( implode( ' ', $moduleClass ) );

    if ( $module->content )
    {
        $config = \Master3Config::getInstance();
        
        if ( $module->module === 'mod_menu' )
        {
            $sfx = $config->getOffcanvasToggle();
            
            $moduleTag = 'nav';
            $moduleClass .= ' uk-visible' . $sfx;

            echo '<a class="uk-navbar-toggle uk-hidden' . $sfx . '" href="#" data-uk-navbar-toggle-icon data-uk-toggle="target:#offcanvas-menu"></a>';
        }
        else
        {
            $moduleClass .= ' ' .  $config->getModuleParams( $module->id )->display;
        }
        
        echo '<' . $moduleTag . ' class="' . trim( $moduleClass ) . '">';

        echo $module->content;
        
        echo '</' . $moduleTag . '>';
    }
}
