<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_random_image
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<div class="random-image<?php echo $moduleclass_sfx; ?>">
    <?php if ( $link ) echo '<a href="', $link, '">'; ?>
    <img
        data-src="<?php echo $image->folder . '/' . htmlspecialchars( $image->name, ENT_COMPAT, 'UTF-8' ); ?>"
        alt="<?php echo htmlspecialchars( $image->name, ENT_COMPAT, 'UTF-8' ); ?>"
        width="<?php echo $image->width; ?>"
        height="<?php echo $image->height; ?>"
        data-uk-img
    >
    <?php if ($link) echo '</a>'; ?>
</div>
