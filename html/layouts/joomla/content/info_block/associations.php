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
use Joomla\CMS\Router\Route;

if ( !empty( $displayData[ 'item' ]->associations ) )
{
    $associations = $displayData[ 'item' ]->associations;
?>

<dd class="association">
    <?php
    echo Text::_( 'JASSOCIATIONS' );
    foreach ( $associations as $association )
    {
        if ( $displayData[ 'item' ]->params->get( 'flags', 1 ) && $association[ 'language' ]->image )
        {
            $flag = HTMLHelper::_( 'image', 'mod_languages/' . $association[ 'language' ]->image . '.gif', $association[ 'language' ]->title_native, array( 'title' => $association[ 'language' ]->title_native ), true );
            echo '&nbsp;<a href="' . Route::_( $association[ 'item' ] ) .'">' . $flag . '</a>&nbsp;';
        } else {
            $class = 'label label-association label-' . $association[ 'language' ]->sef;
            echo '&nbsp;<a class="' . $class . '" href="' . Route::_( $association[ 'item' ] ) . '">' . strtoupper( $association[ 'language' ]->sef ) . '</a>&nbsp;';
        }
    }
    ?>
</dd>
<?php
}
