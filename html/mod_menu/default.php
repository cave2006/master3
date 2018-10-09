<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu.nav
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\Filesystem\Path;
use Joomla\CMS\Helper\ModuleHelper;

$id = '';

if ( $tagId = $params->get( 'tag_id', '' ) )
{
	$id = ' id="' . $tagId . '"';
}

$class_sfx = $class_sfx ? ' ' . trim( $class_sfx ) : '';

echo '<ul class="uk-nav' . $class_sfx . '"' . $id . '>';

foreach ( $list as $i => &$item )
{
	$class = 'item-' . $item->id;

	if ( in_array( $item->id, $path ) )
	{
		$class .= ' uk-active';
	}
	elseif ( $item->type === 'alias' )
	{
		$aliasToId = $item->params->get( 'aliasoptions' );

		if ( count( $path ) > 0 && $aliasToId == $path[ count( $path ) - 1 ] )
		{
			$class .= ' uk-active';
		}
		elseif ( in_array( $aliasToId, $path ) )
		{
			$class .= ' uk-active';
		}
	}

	if ( $item->type === 'separator' )
	{
		$class .= ' uk-nav-divider';
	}

	if ( $item->parent )
	{
		$class .= ' uk-parent';
	}

	if ($item->type == 'heading' && (int)$item->level > 1)
	{
		$class .= ' uk-nav-header';
	}

	echo '<li class="' . trim( $class ) . '">';

	switch ( $item->type )
	{
		case 'separator':
			break;

		case 'component':
		case 'heading':
		case 'url':
			require ModuleHelper::getLayoutPath( 'mod_menu', 'default_' . $item->type );
			break;

		default:
			require ModuleHelper::getLayoutPath( 'mod_menu', 'default_url' );
			break;
	}

	if ( $item->deeper )
	{
		echo '<ul class="uk-nav-sub">';
	}
	elseif ( $item->shallower )
	{
		echo '</li>';
		echo str_repeat( '</ul></li>', $level_diff );
	}
	else
	{
		echo '</li>';
	}
}

echo '</ul>';
