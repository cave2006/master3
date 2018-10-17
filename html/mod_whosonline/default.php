<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_whosonline
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined( '_JEXEC' ) or die;

use Joomla\CMS\Language\Text;

?>

<?php
if ( $showmode == 0 || $showmode == 2 )
{
    $guest = Text::plural( 'MOD_WHOSONLINE_GUESTS', $count[ 'guest' ] );
    $member = Text::plural( 'MOD_WHOSONLINE_MEMBERS', $count[ 'user' ] );
    echo '<p>', Text::sprintf( 'MOD_WHOSONLINE_WE_HAVE', $guest, $member ), '</p>';
}

if ( ( $showmode > 0 ) && count( $names ) )
{
    
    if ( $params->get( 'filter_groups', 0 ) )
    {
        echo '<p>', Text::_( 'MOD_WHOSONLINE_SAME_GROUP_MESSAGE' ), '</p>';
    }
?>

<ul class="uk-list whosonline<?php echo $moduleclass_sfx; ?>">
    <?php foreach ( $names as $name ) { ?>
    <li><?php echo $name->username; ?></li>
    <?php } ?>
</ul>

<?php
}
