<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_search
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined( '_JEXEC' ) or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

$lang = Factory::getLanguage();
$upper_limit = $lang->getUpperLimitSearchWord();

?>
<form id="searchForm" action="<?php echo Route::_( 'index.php?option=com_search' ); ?>" method="post">
    
    <div class="uk-margin-bottom">
        <div class="uk-button-group uk-width">
            <input type="text" name="searchword" title="<?php echo Text::_( 'COM_SEARCH_SEARCH_KEYWORD' ); ?>" placeholder="<?php echo Text::_( 'COM_SEARCH_SEARCH_KEYWORD' ); ?>" id="search-searchword" maxlength="<?php echo $upper_limit; ?>" value="<?php echo $this->escape( $this->origkeyword ); ?>" class="uk-input" />
            <button name="Search" onclick="this.form.submit()" class="uk-button uk-button-primary uk-text-nowrap" data-uk-tooltip="<?php echo Text::_( 'COM_SEARCH_SEARCH' );?>">
                <span class="uk-margin-small-right" data-uk-icon="icon:search"></span>
                <?php echo Text::_( 'JSEARCH_FILTER_SUBMIT' ); ?>
            </button>
        </div>
        <input type="hidden" name="task" value="search" />
    </div>

    <?php if ( !empty( $this->searchword ) ) { ?>
    <div class="uk-margin-bottom searchintro<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
        <?php echo Text::plural( 'COM_SEARCH_SEARCH_KEYWORD_N_RESULTS', '<span class="uk-text-primary">' . $this->total . '</span>' ); ?>
    </div>
    <?php } ?>

    <?php if ( $this->params->get( 'search_phrases', 1 ) ) { ?>
    <div class="uk-margin-bottom phrases">
        <legend class="uk-text-bold"><?php echo Text::_( 'COM_SEARCH_FOR' ); ?></legend>
        <div class="uk-margin-right phrases-box uk-flex uk-flex-wrap uk-flex-middle" data-uk-margin>
            <?php
            $searchphrases = [];
            $searchphrases[] = HTMLHelper::_( 'select.option', 'all', JText::_( 'COM_SEARCH_ALL_WORDS' ) );
            $searchphrases[] = HTMLHelper::_( 'select.option', 'any', JText::_( 'COM_SEARCH_ANY_WORDS' ) );
            $searchphrases[] = HTMLHelper::_( 'select.option', 'exact', JText::_( 'COM_SEARCH_EXACT_PHRASE' ) );
            
            echo HTMLHelper::_('select.radiolist', $searchphrases, 'searchphrase', 'class="uk-radio uk-margin-small-right"', 'value', 'text', $this->searchphrase );
            ?>
        </div>
        <div class="uk-margin-small-top ordering-box">
            <label for="ordering" class="uk-form-label"><?php echo Text::_( 'COM_SEARCH_ORDERING' ); ?></label>
            <?php
                $orders = [];
                $orders[] = HTMLHelper::_( 'select.option', 'newest', Text::_( 'COM_SEARCH_NEWEST_FIRST' ) );
                $orders[] = HTMLHelper::_( 'select.option', 'oldest', Text::_( 'COM_SEARCH_OLDEST_FIRST' ) );
                $orders[] = HTMLHelper::_( 'select.option', 'popular', Text::_( 'COM_SEARCH_MOST_POPULAR' ) );
                $orders[] = HTMLHelper::_( 'select.option', 'alpha', Text::_( 'COM_SEARCH_ALPHABETICAL' ) );
                $orders[] = HTMLHelper::_( 'select.option', 'category', Text::_( 'JCATEGORY' ) );
                
                echo HTMLHelper::_( 'select.genericlist', $orders, 'ordering', 'class="uk-select uk-form-small uk-form-width-small"', 'value', 'text', $this->ordering );
            ?>
        </div>
    </div>
    <?php } ?>

    <?php if ( $this->params->get( 'search_areas', 1 ) ) { ?>
    <div class="uk-margin-bottom only">
        <legend class="uk-text-bold"><?php echo Text::_( 'COM_SEARCH_SEARCH_ONLY' ); ?></legend>
        <?php
        foreach ( $this->searchareas[ 'search' ] as $val => $txt )
        {
            $checked = is_array( $this->searchareas[ 'active' ] ) && in_array( $val, $this->searchareas[ 'active' ] ) ? 'checked="checked"' : '';
        ?>
        <div class="uk-margin-small-top">
            <label for="area-<?php echo $val; ?>" class="uk-form-label">
                <input type="checkbox" name="areas[]" value="<?php echo $val; ?>" id="area-<?php echo $val; ?>" <?php echo $checked; ?> class="uk-checkbox" />
                <?php echo Text::_( $txt ); ?>
            </label>
        </div>
        <?php } ?>
    </div>
    <?php } ?>

    <?php if ( $this->total > 0 ) { ?>
    <div class="uk-flex uk-flex-wrap uk-flex-between">
        <div class="form-limit">
            <label for="limit"><?php echo Text::_( 'JGLOBAL_DISPLAY_NUM' ); ?></label>
            <?php echo $this->pagination->getLimitBox(); ?>
        </div>
        <div class="uk-badge"><?php echo $this->pagination->getPagesCounter(); ?></div>
    </div>
    <?php } ?>

</form>

<hr class="uk-margin-medium">
