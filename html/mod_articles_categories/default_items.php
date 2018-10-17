<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_categories
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Helper\ModuleHelper;

$input  = Factory::getApplication()->input;
$option = $input->getCmd( 'option' );
$view   = $input->getCmd( 'view' );
$id     = $input->getInt( 'id' );

foreach ( $list as $item )
{
    echo '<li';
    if ( $id == $item->id && $view == 'category' && $option == 'com_content' ) echo ' class="active"';
    echo '>';
    $levelup = $item->level - $startLevel - 1; 
    
    echo '<h' . $params->get('item_heading') + $levelup . '>';
    echo 
        '<a href="' . Route::_( ContentHelperRoute::getCategoryRoute( $item->id ) ) . '">',
        $item->title,
        ( $params->get( 'numitems' ) ? $item->numitems : '' ),
        '</a>';
    echo '</h' . $params->get('item_heading') + $levelup . '>';

    if ( $params->get( 'show_description', 0 ) )
    {
        echo HTMLHelper::_( 'content.prepare', $item->description, $item->getParams(), 'mod_articles_categories.content' ); 
    }
    
    if
    (
        $params->get( 'show_children', 0 ) && 
        ( ( $params->get( 'maxlevel', 0 ) == 0 ) || ( $params->get( 'maxlevel' ) >= ( $item->level - $startLevel ) ) ) && 
        count( $item->getChildren() )
    )
    {
        echo '<ul class="uk-list uk-margin-small-left">';
        $temp = $list;
        $list = $item->getChildren();
        require ModuleHelper::getLayoutPath( 'mod_articles_categories', $params->get( 'layout', 'default' ) . '_items' );
        $list = $temp;
        echo '</ul>';
    }

    echo '</li>';
}
