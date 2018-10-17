<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.master3
 *
 * @copyright   Copyright (C) 2018 Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

defined('_JEXEC') or die;

use Joomla\Filesystem\Path;
use Joomla\CMS\Language\Text;

include_once Path::clean( __DIR__ . '/config/config.php' ); 

$config = \Master3Config::getInstance();
$head = $config->getHead();

$errorCode = $this->error->getCode();

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <?php echo $head[ 'metas' ]; ?>
    <?php echo $head[ 'styles' ]; ?>
    <?php echo $head[ 'scripts' ]; ?>
</head>
<body class="<?php echo $config->getBodyClasses(); ?>">
    
    <div class="uk-offcanvas-container">
        
        <?php
        /*
         * logo
         * headbar
         */
        $section = $config->getSectionParams( 'headbar' );
        ?>
        <header id="<?php echo $section->id; ?>" class="<?php echo $section->class; ?>"<?php echo ( $section->image ? ' data-src="' . $section->image . '" data-uk-img' : '' ); ?>>
            <div class="<?php echo $section->container; ?>">
                <div data-uk-grid>
                    
                    <div class="uk-width-auto uk-flex uk-flex-middle">
                        <?php echo $config->getLogo(); ?>
                    </div>
                    
                </div>
            </div>
        </header>
        
        
        <?php
        /*
         * navbar
         * navbar
         * navbar
         */
        $section = $config->getSectionParams( 'navbar' );
        ?>
        <div class="<?php echo $section->class; ?>"<?php echo ( $section->image ? ' data-src="' . $section->image . '" data-uk-img' : '' );?>>
            <div class="<?php echo $section->container; ?>">
                <div data-uk-navbar<?php echo $section->navbarMode; ?>>
                    <div class="uk-navbar-left">
                        <ul class="uk-navbar-nav">
                            <li>
                                <a href="<?php echo $this->baseurl; ?>"><?php echo Text::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        
        <?php
        /*
         * system output
         */
        $section = $config->getSectionParams( 'main' );
        ?>
        <div class="<?php echo $section->class; ?>"<?php echo ( $section->image ? ' data-src="' . $section->image . '" data-uk-img' : '' );?>>
            <div class="<?php echo $section->container; ?>">
                <div>
                    <h1><?php echo Text::_( ( $errorCode == 404 ? 'JERROR_LAYOUT_PAGE_NOT_FOUND' : 'JERROR_LAYOUT_REQUESTED_RESOURCE_WAS_NOT_FOUND' ) ); ?></h1>
                    
                    <div class="uk-margin-large"><?php echo Text::_('JERROR_LAYOUT_PLEASE_CONTACT_THE_SYSTEM_ADMINISTRATOR'); ?></div>
                    
                    <table class="uk-table uk-table-divider uk-table-striped uk-margin uk-table-responsive">
                        
                        <tr>
                            <td class="uk-text-bold">Error Code</td>
                            <td class="uk-table-expand"><?php echo $errorCode ?></td>
                        </tr>
                        
                        <tr>
                            <td class="uk-text-bold">Error Message</td>
                            <td><?php echo htmlspecialchars( $this->error->getMessage(), ENT_QUOTES, 'UTF-8' );?></td>
                        </tr>
                        
                        <tr>
                            <td class="uk-text-bold">Error File</td>
                            <td><?php echo htmlspecialchars( $this->error->getFile(), ENT_QUOTES, 'UTF-8' ), ':', $this->error->getLine(); ?></td>
                        </tr>

                    </table>

                    <?php if ($this->debug) { ?>
                    <div class="uk-margin-large">
                        <?php
                        echo $this->renderBacktrace();
                        if ( $this->error->getPrevious() )
                        {
                            $loop = true;
                            $this->setError( $this->_error->getPrevious() );
                            while ( $loop === true )
                            {
                        ?>
                        <p><strong><?php echo JText::_( 'JERROR_LAYOUT_PREVIOUS_ERROR' ); ?></strong></p>
                        <p><?php
                                echo 
                                    htmlspecialchars( $this->_error->getMessage(), ENT_QUOTES, 'UTF-8' ), '<br>',
                                    htmlspecialchars( $this->_error->getFile(), ENT_QUOTES, 'UTF-8' ), ':', $this->_error->getLine();
                        ?></p>
                        <?php
                                echo $this->renderBacktrace();
                                $loop = $this->setError( $this->_error->getPrevious() );
                            }
                            $this->setError( $this->error );
                        }
                        ?>
                    </div>
                    <?php } ?>

                </div>
            </div>
        </div>
        
    </div>

</body>
</html>

