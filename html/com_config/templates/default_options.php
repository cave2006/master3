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
use Joomla\Filesystem\Path;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

$fieldSets = $this->form->getFieldsets( 'params' );

$tabs = [];

// Search for com_config field set
if ( !empty( $fieldSets[ 'com_config' ] ) )
{
    echo $this->form->renderFieldset( 'com_config' );
}
else
{
    ?>
<ul data-uk-tab="connent:#com-config-template-content">
    <?php
    foreach  ($fieldSets as $name => $fieldSet )
    {
        $label = !empty( $fieldSet->label ) ? $fieldSet->label : 'COM_CONFIG_' . $name . '_FIELDSET_LABEL';
        echo '<li><a href="#">' . Text::_( $label ) . '</a></li>';
    }
    ?>
</ul>
<ul id="com-config-template-content" class="uk-margin uk-switcher">
    <?php
    foreach  ($fieldSets as $name => $fieldSet )
    {
        echo '<li>';

        $label = strtoupper( !empty( $fieldSet->label ) ? $fieldSet->label : 'COM_CONFIG_' . $name . '_FIELDSET_LABEL' );
        echo '<legend class="uk-h4 uk-text-primary">' . Text::_( $label ) . '</legend>';

        if ( isset( $fieldSet->description ) && trim( $fieldSet->description ) )
        {
            echo '<p class="uk-text-small uk-margin">' . $this->escape( Text::_( $fieldSet->description ) ) . '</p>';
        }
        
        $fields = $this->form->getFieldset( $name );
        foreach ( $fields as $field )
        {
            
            if ( strtolower( $field->type ) === 'checkbox' )
            {
                ?>
                <div class="uk-form-stacked uk-margin">
                    <label for="<?php echo $field->fieldname; ?>"<?php if (!empty($field->classes)) echo ' class="uk-form-label"'; ?>>
                        <input 
                            type="<?php echo $field->type; ?>" 
                            name="<?php echo $field->name; ?>" 
                            id="<?php echo $field->fieldname; ?>" 
                            class="uk-<?php echo strtolower( $field->type ); ?>"
                            <?php echo !$field->checked ?: ' checked="true"'; ?>
                        >
                        <?php
                        echo strip_tags( $field->label );
                        if ($field->required)
                        {
                        ?>
                        <span class="uk-text-danger">&#160;*</span>
                        <?php } ?>
                    </label>
                </div>
                <?php
            }
            elseif ( in_array( strtolower( $field->type ), [ 'list' ] ) )
            {
                $this->form->setFieldAttribute( $field->fieldname, 'class', 'uk-select', $field->group ? $field->group : null );
                echo $this->form->renderField( $field->fieldname, $field->group ? $field->group : null );
            }
            else
            {
                echo $this->form->renderField( $field->fieldname, $field->group ? $field->group : null );
            }
        }
        
        echo '</li>';
    }
}
?>
</ul>