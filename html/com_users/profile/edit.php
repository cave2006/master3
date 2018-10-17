<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined( '_JEXEC' ) or die;

JHtml::_( 'behavior.keepalive' );
JHtml::_( 'behavior.formvalidator' );
JHtml::_( 'formbehavior.chosen', 'select' );
JHtml::_( 'bootstrap.tooltip' );


// Load user_profile plugin language
$lang = JFactory::getLanguage(  );
$lang->load( 'plg_user_profile', JPATH_ADMINISTRATOR );

?>
<div class="profile-edit<?php echo $this->pageclass_sfx; ?>">
    
    <?php if ( $this->params->get( 'show_page_heading' ) ) { ?>
    <h1><?php echo $this->escape( $this->params->get( 'page_heading' ) ); ?></h1>
    <?php } ?>

    <script type="text/javascript">
        Joomla.twoFactorMethodChange = function( e )
        {
            var selectedPane = 'com_users_twofactor_' + jQuery( '#jform_twofactor_method' ).val(  );

            jQuery.each( jQuery( '#com_users_twofactor_forms_container>div' ), function( i, el )
            {
                if ( el.id != selectedPane )
                {
                    jQuery( '#' + el.id ).hide( 0 );
                }
                else
                {
                    jQuery( '#' + el.id ).show( 0 );
                }
            } );
        }
    </script>

    <form id="member-profile" action="<?php echo JRoute::_( 'index.php?option=com_users&task=profile.save' ); ?>" method="post" class="form-validate form-horizontal well" enctype="multipart/form-data">
        
        <ul data-uk-tab="connect:#com-users-profile-edit-content">
            <?php
            foreach ( $this->form->getFieldsets(  ) as $group => $fieldset )
            {
                if ( count( $this->form->getFieldset( $group ) ) )
                {
            ?>
            <li><a href="#"><?php echo JText::_( $fieldset->label ); ?></a></li>
            <?php
                }
            }

            if ( count( $this->twofactormethods ) > 1 )
            {
            ?>
            <li><a href="#"><?php echo JText::_( 'COM_USERS_PROFILE_TWO_FACTOR_AUTH' ); ?></a></li>
            <?php } ?>
        </ul>
        
        <ul id="com-users-profile-edit-content" class="uk-margin uk-switcher">
            <?php
            // Iterate through the form fieldsets and display each one.
            foreach ( $this->form->getFieldsets(  ) as $group => $fieldset )
            {

                $fields = $this->form->getFieldset( $group );
                if ( count( $fields ) )
                {
                    echo '<li>';

                    // If the fieldset has a label set, display it as the legend.
                    if ( isset( $fieldset->label ) )
                    {
                    ?>
                    <legend class="uk-h4 uk-text-primary"><?php echo JText::_( $fieldset->label ); ?></legend>
                    <?php
                    }

                    if ( isset( $fieldset->description ) && trim( $fieldset->description ) )
                    {
                    ?>
                    <p><?php echo $this->escape( JText::_( $fieldset->description ) ); ?></p>
                    <?php
                    }

                    // Iterate through the fields in the set and display them.
                    foreach ( $fields as $field )
                    {
                        // If the field is hidden, just display the input.
                        if ( $field->hidden )
                        {
                            echo $field->input;
                        }
                        else
                        {
                        ?>
                        <div class="uk-form-stacked uk-margin">
                            <div class="uk-form-label">
                                <?php
                                echo $field->label;
                                if ( !$field->required && $field->type !== 'Spacer' )
                                {
                                ?>
                                <span class="optional"><?php echo JText::_( 'COM_USERS_OPTIONAL' ); ?></span>
                                <?php } ?>
                            </div>
                            <div class="uk-form-controls">
                                <?php if ( $field->fieldname === 'password1' ) { ?>
                                <input type="password" style="display:none">
                                <?php
                                }
                                echo $field->input;
                                ?>
                            </div>
                        </div>
                        <?php
                        }
                    }

                    echo '</li>';
                }
            }


            if ( count( $this->twofactormethods ) > 1 )
            {
            ?>
            <li>
                <legend class="uk-h4 uk-text-primary"><?php echo JText::_( 'COM_USERS_PROFILE_TWO_FACTOR_AUTH' ); ?></legend>
                
                <div class="control-group">
                    <div class="control-label">
                        <label id="jform_twofactor_method-lbl" for="jform_twofactor_method" class="hasTooltip"
                            title="<?php echo '<strong>' . JText::_( 'COM_USERS_PROFILE_TWOFACTOR_LABEL' ) . '</strong><br />' . JText::_( 'COM_USERS_PROFILE_TWOFACTOR_DESC' ); ?>">
                            <?php echo JText::_( 'COM_USERS_PROFILE_TWOFACTOR_LABEL' ); ?>
                        </label>
                    </div>
                    <div class="controls">
                        <?php echo JHtml::_( 'select.genericlist', $this->twofactormethods, 'jform[twofactor][method]', array( 'onchange' => 'Joomla.twoFactorMethodChange(  )' ), 'value', 'text', $this->otpConfig->method, 'jform_twofactor_method', false ); ?>
                    </div>
                </div>
                
                <div id="com_users_twofactor_forms_container">
                    <?php foreach ( $this->twofactorform as $form ) { ?>
                        <?php $style = $form[ 'method' ] == $this->otpConfig->method ? 'display: block' : 'display: none'; ?>
                        <div id="com_users_twofactor_<?php echo $form[ 'method' ]; ?>" style="<?php echo $style; ?>">
                            <?php echo $form[ 'form' ]; ?>
                        </div>
                    <?php } ?>
                </div>

                <hr>
                
                <legend class="uk-h4 uk-text-primary"><?php echo JText::_( 'COM_USERS_PROFILE_OTEPS' ); ?></legend>

                <div class="uk-alert"><?php echo JText::_( 'COM_USERS_PROFILE_OTEPS_DESC' ); ?></div>
                
                <?php if ( empty( $this->otpConfig->otep ) ) { ?>
                <div class="uk-alert uk-alert-warning"><?php echo JText::_( 'COM_USERS_PROFILE_OTEPS_WAIT_DESC' ); ?></div>
                <?php
                }
                else
                {
                    foreach ( $this->otpConfig->otep as $otep )
                    {
                ?>
                <span class="uk-inline"><?php echo substr( $otep, 0, 4 ); ?>-<?php echo substr( $otep, 4, 4 ); ?>-<?php echo substr( $otep, 8, 4 ); ?>-<?php echo substr( $otep, 12, 4 ); ?></span>
                <?php
                    }
                }
                ?>
            </li>
            <?php } ?>
        </ul>
        
        <hr class="uk-margin-medium">

        <div class="uk-flex">
            <button type="submit" class="uk-button uk-button-primary uk-margin-small-right validate"><?php echo JText::_( 'JSUBMIT' ); ?></button>
            <a class="uk-button uk-button-default" href="<?php echo JRoute::_( 'index.php?option=com_users&view=profile' ); ?>" title="<?php echo JText::_( 'JCANCEL' ); ?>"><?php echo JText::_( 'JCANCEL' ); ?></a>
        </div>
        
        <input type="hidden" name="option" value="com_users" />
        <input type="hidden" name="task" value="profile.save" />
        <?php echo JHtml::_( 'form.token' ); ?>

    </form>
</div>
