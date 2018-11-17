<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Form
 *
 * @copyright   Copyright (C) 2018 Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Filesystem\Path;
use Joomla\CMS\Form\FormHelper;

FormHelper::loadFieldClass( 'subform' );

class JFormFieldSubformSections extends \JFormFieldSubform
{
    protected $type = 'subformsections';
    
    protected $layout = 'joomla.form.field.subform.repeatable-table';

    public function setup( SimpleXMLElement $element, $value, $group = null )
    {
        if ( !parent::setup( $element, $value, $group ) )
        {
            return false;
        }
        
        $fields = $this->getFormFields();
        $sections = $this->getSections();
        $outValues = [];

        foreach ( $sections as $key => $section )
        {
            $originRow = '';
            
            if ( $this->value )
            {
                foreach ( $this->value as $originValue )
                {
                    if ( $originValue[ 'form' ][ 'name' ] == $section )
                    {
                        $originRow = $originValue[ 'form' ];
                    }
                }
            }
            else
            {
                $originRow = [
                    'name' => '',
                    'id' => '',
                    'style' => 'uk-section-default',
                    'padding' => 'uk-section',
                    'image' => '',
                    'class' => '',
                    'container' => 'uk-container',
                    'responsive' => 'medium',
                    'gutter' => ''
                ];
            }
            
            foreach ( $fields as $field )
            {
                $fieldValue = '';
                
                if ( $field === 'name' )
                {
                    $fieldValue = $section;
                }
                elseif ( $originRow && $originRow[ 'name' ] === $section )
                {
                    $fieldValue = isset( $originRow[ $field ] ) ? $originRow[ $field ] : null;
                }
                
                if ( $fieldValue !== null)
                {
                    $outValues[ $this->fieldname . $key ][ 'form' ][ $field ] = $fieldValue;
                }
            }
        }
        
        $this->value = $outValues;

        return true;
    }
    
    protected function getFormFields()
    {
        $xml = simplexml_load_file( $this->formsource );
        $xmlFields = (array) $xml->fields;
        $fields = [];

        foreach ( $xmlFields[ 'fieldset' ] as $fieldset )
        {
            foreach ( $fieldset->field as $field )
            {
                $fields[] = $field->attributes()->name->__toString();
            }
        }

        return $fields;
    }

    protected function getSections()
    {
        $sections = [];

        $filePath = realpath( Path::clean( __DIR__ . '/../../templateDetails.xml' ) );
        
        if ( is_file( $filePath ) )
        {
            $xml = simplexml_load_file( $filePath );

            if ( !$xml )
            {
                return false;
            }

            if ( $xml->getName() != 'extension' && $xml->getName() != 'metafile' )
            {
                unset($xml);
                return false;
            }
            
            foreach ($xml->positions[ 0 ]->position as $position)
            {
                if ( isset( $position[ 'section' ] ) )
                {
                    $sections[] = $position->attributes()->section->__toString();
                }
            }
        }

        return array_values( array_unique( $sections ) );
    }
}
