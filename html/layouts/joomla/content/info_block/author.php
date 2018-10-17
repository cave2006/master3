<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined( 'JPATH_BASE' ) or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

?>
<dd class="createdby" itemprop="author" itemscope itemtype="https://schema.org/Person">
    <span data-uk-icon="icon:user"></span>
    <?php
    $author = ( $displayData[ 'item' ]->created_by_alias ?: $displayData[ 'item' ]->author );
    $author = '<span itemprop="name">' . $author . '</span>';
    if ( !empty( $displayData[ 'item' ]->contact_link  ) && $displayData[ 'params' ]->get( 'link_author' ) == true )
    {
        echo Text::sprintf( 'COM_CONTENT_WRITTEN_BY', HTMLHelper::_( 'link', $displayData[ 'item' ]->contact_link, $author, array( 'itemprop' => 'url' ) ) );
    }
    else
    {
        echo Text::sprintf( 'COM_CONTENT_WRITTEN_BY', $author );
    }
    ?>
</dd>
