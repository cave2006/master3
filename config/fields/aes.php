<?php
/**
 * @package     Joomla.Site
 * @subpackage  Form
 * 
 * @copyright   Copyright (C) 2018 Aleksey A. Morozov (AlekVolsk). All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Factory;

class JFormFieldAes extends \JFormField
{
    protected $type = 'aes';

    protected function getLabel()
    {
        return '';
    }

    protected function getInput()
    {
        $path = str_replace( '\\', '/', str_replace( JPATH_SITE, '', __DIR__ ) );
        
        if ( (int) $this->element[ 'styles' ] == true )
        {
            Factory::getDocument()->addStyleSheet( $path . '/aes.css ');
        }
        
        if ( (int) $this->element[ 'script' ] == true )
        {
            Factory::getDocument()->addScript( $path . '/aes.js' );
        }
        
        return '';
    }
}