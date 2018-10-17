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

include_once Path::clean( __DIR__ . '/config/config.php' ); 

$config = \Master3Config::getInstance();
$head = $config->getHead();

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
         * toolbar-left
         * toolbar-right
         */
        if ( $this->countModules( 'toolbar-left + toolbar-right' ) )
        {
            $section = $config->getSectionParams( 'toolbar' );
        ?>
        <div id="<?php echo $section->id; ?>" class="<?php echo $section->class; ?>"<?php echo ( $section->image ? ' data-src="' . $section->image . '" data-uk-img' : '' ); ?>>
            <div class="<?php echo $section->container; ?>">
                <div class="uk-flex uk-flex-between">
                    
                    <?php if ( $this->countModules( 'toolbar-left' ) ) { ?>
                    <jdoc:include type="modules" name="toolbar-left" style="master3" />
                    <?php } ?>
                    
                    <?php if ( $this->countModules( 'toolbar-right' ) ) { ?>
                    <jdoc:include type="modules" name="toolbar-right" style="master3" />
                    <?php } ?>

                </div>
            </div>
        </div>
        <?php } ?>
        
        
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
                    
                    <?php if ( $this->countModules( 'headbar' ) ) { ?>
                    <div class="uk-width-expand uk-flex uk-flex-middle uk-flex-right">
                        <jdoc:include type="modules" name="headbar" style="master3" />
                    </div>
                    <?php } ?>

                </div>
            </div>
        </header>
        
        
        <?php
        /*
         * navbar-left
         * navbar-center
         * navbar-right
         */
        if ( $this->countModules( 'navbar-left + navbar-center + navbar-right' ) )
        {
            $section = $config->getSectionParams( 'navbar' );
        ?>
        <div id="<?php echo $section->id; ?>" class="<?php echo $section->class; ?>"<?php echo ( $section->image ? ' data-src="' . $section->image . '" data-uk-img' : '' ), $section->sticky;?>>
            <div class="<?php echo $section->container; ?>">
                <div data-uk-navbar<?php echo $section->navbarMode; ?>>
                    
                    <?php if ( $this->countModules( 'navbar-left' ) ) { ?>
                    <div class="uk-navbar-left">
                        <jdoc:include type="modules" name="navbar-left" style="navbar" />
                    </div>
                    <?php } ?>
                    
                    <?php if ( $this->countModules( 'navbar-center' ) ) { ?>
                    <div class="uk-navbar-center">
                        <jdoc:include type="modules" name="navbar-center" style="navbar" />
                    </div>
                    <?php } ?>
                    
                    <?php if ( $this->countModules( 'navbar-right' ) ) { ?>
                    <div class="uk-navbar-right">
                        <jdoc:include type="modules" name="navbar-right" style="navbar" />
                    </div>
                    <?php } ?>

                </div>
                <?php if ( $section->dropbarMode ) { ?>
                <div class="uk-navbar-dropbar"></div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
        

        <?php
        /*
         * breadcrumb
         */
        if ( $this->countModules( 'breadcrumb' ) )
        {
            $section = $config->getSectionParams( 'breadcrumb' );
        ?>
        <div id="<?php echo $section->id; ?>" class="<?php echo $section->class; ?>"<?php echo ( $section->image ? ' data-src="' . $section->image . '" data-uk-img' : '' ); ?>>
            <div class="<?php echo $section->container; ?>">
                <jdoc:include type="modules" name="breadcrumb" style="none" />
            </div>
        </div>
        <?php } ?>
        
        
        <?php
        /*
         * system messages
         */
        ?>
        <jdoc:include type="message" />

        
        <?php
        /*
         * top-a
         * top-b
         * top-c
         * top-d
         * top-e
         */
        $bottomSections = [ 'top-a', 'top-b', 'top-c', 'top-d', 'top-e' ];
        foreach ( $bottomSections as $bottomSection )
        {
            if ( $sectionPosCount = $this->countModules( $bottomSection ) )
            {
                $sectionPosCount = $sectionPosCount > 6 ? 6 : $sectionPosCount;
                $section = $config->getSectionParams( $bottomSection );
                $sectionResponsive = 'uk-child-width-1-' . ( $section->responsive === '' ? '1' : $sectionPosCount . $section->responsive );
                $section->gridClass = trim( $sectionResponsive . ' ' . $section->gridClass );
        ?>
        <div id="<?php echo $section->id; ?>" class="<?php echo $section->class; ?>"<?php echo ( $section->image ? ' data-src="' . $section->image . '" data-uk-img' : '' );?>>
            <div class="<?php echo $section->container; ?>">
                <div class="<?php echo $section->gridClass; ?>" data-uk-grid>
                    <jdoc:include type="modules" name="<?php echo $bottomSection; ?>" style="master3" />
                </div>
            </div>
        </div>
        <?php } } ?>
        

        <?php
        /*
         * system output
         * main-top
         * main-bottom
         * sidebar-a
         * sidebar-b
         */
        $systemOutput = $config->getSystemOutput();
        $countMainTop = $this->countModules( 'main-top' );
        $countMainBottom = $this->countModules( 'main-bottom' );
        $countSidebarA = $this->countModules( 'sidebar-a' );
        $countSidebarB = $this->countModules( 'sidebar-b' );
        if ( $systemOutput || $countMainTop || $countMainBottom || $countSidebarA || $countSidebarB )
        {
            $section = $config->getSectionParams( 'main' );
        ?>
        <div id="<?php echo $section->id; ?>" class="<?php echo $section->class; ?>"<?php echo ( $section->image ? ' data-src="' . $section->image . '" data-uk-img' : '' );?>>
            <div class="<?php echo $section->container; ?>">
                <div class="<?php echo $section->gridClass; ?>" data-uk-grid>
                    <?php if ( $systemOutput || $countMainTop || $countMainBottom ) { ?>
                    <div class="uk-width-<?php echo $section->mainGridSize . $section->responsive; ?>">
                        <div class="<?php echo 'uk-child-width-1-1 ' . $section->gridClass; ?>" data-uk-grid>
                            
                            <?php if ( $countMainTop ) { ?>
                            <div>
                                <div class="<?php echo 'uk-child-width-1-1 ' . $section->gridClass; ?>" data-uk-grid>
                                    <jdoc:include type="modules" name="main-top" style="master3" />
                                </div>
                            </div>
                            <?php } ?>

                            <?php if ( $systemOutput ) { ?>
                            <div>
                                <main id="content">
                                    <?php echo $systemOutput; ?>
                                </main>
                            </div>
                            <?php } ?>
                            
                            <?php if ( $countMainBottom ) { ?>
                            <div>
                                <div class="<?php echo 'uk-child-width-1-1 ' . $section->gridClass; ?>" data-uk-grid>
                                    <jdoc:include type="modules" name="main-bottom" style="master3" />
                                </div>
                            </div>
                            <?php } ?>

                        </div>
                    </div>
                    <?php
                    }
                    else
                    {
                        if ( ( $countSidebarA && !$countSidebarB ) || ( !$countSidebarA && $countSidebarB ))
                        {
                            $section->sidebarGridSize = '1-1';
                            $section->responsive = '';
                        }
                        elseif ( $countSidebarA && $countSidebarB )
                        {
                            $section->sidebarGridSize = '1-2';
                        }
                    }
                    ?>
                    
                    <?php if ( $countSidebarA ) { ?>
                    <aside class="<?php echo $section->sidebarAClass; ?>uk-width-<?php echo $section->sidebarGridSize . $section->responsive; ?>">
                        <div class="<?php echo 'uk-child-width-1-1 ' . $section->gridClass; ?>" data-uk-grid>
                            <jdoc:include type="modules" name="sidebar-a" style="master3" />
                        </div>
                    </aside>
                    <?php } ?>
                    
                    <?php if ( $countSidebarB ) { ?>
                    <aside class="<?php echo $section->sidebarBClass; ?>uk-width-<?php echo $section->sidebarGridSize . $section->responsive; ?>">
                        <div class="<?php echo 'uk-child-width-1-1 ' . $section->gridClass; ?>" data-uk-grid>
                            <jdoc:include type="modules" name="sidebar-b" style="master3" />
                        </div>
                    </aside>
                    <?php } ?>

                </div>
            </div>
        </div>
        <?php } ?>
        
        
        <?php
        /*
         * bottom-a
         * bottom-b
         * bottom-c
         * bottom-d
         * bottom-e
         */
        $bottomSections = [ 'bottom-a', 'bottom-b', 'bottom-c', 'bottom-d', 'bottom-e' ];
        foreach ( $bottomSections as $bottomSection )
        {
            if ( $sectionPosCount = $this->countModules( $bottomSection ) )
            {
                $sectionPosCount = $sectionPosCount > 6 ? 6 : $sectionPosCount;
                $section = $config->getSectionParams( $bottomSection );
                $sectionResponsive = 'uk-child-width-1-' . ( $section->responsive === '' ? '1' : $sectionPosCount . $section->responsive );
                $section->gridClass = trim( $sectionResponsive . ' ' . $section->gridClass );
        ?>
        <div id="<?php echo $section->id; ?>" class="<?php echo $section->class; ?>"<?php echo ( $section->image ? ' data-src="' . $section->image . '" data-uk-img' : '' );?>>
            <div class="<?php echo $section->container; ?>">
                <div class="<?php echo $section->gridClass; ?>" data-uk-grid>
                    <jdoc:include type="modules" name="<?php echo $bottomSection; ?>" style="master3" />
                </div>
            </div>
        </div>
        <?php } } ?>
        
        
        <?php
        /*
         * footer-left
         * footer-center
         * footer-right
         */
        if ( $this->countModules( 'footer-left + footer-center + footer-right' ) )
        {
            $section = $config->getSectionParams( 'footer' );
            $sectionPosCount =
                ( $this->countModules( 'footer-left' ) ? 1 : 0 ) +
                ( $this->countModules( 'footer-center' ) ? 1 : 0 ) +
                ( $this->countModules( 'footer-right' ) ? 1 : 0 );
            $sectionResponsive = 'uk-child-width-1-' . ( $section->responsive === '' ? '1' : $sectionPosCount . $section->responsive );
            $section->gridClass = trim( $sectionResponsive . ' ' . $section->gridClass );
        ?>
        <div id="<?php echo $section->id; ?>" class="<?php echo $section->class; ?>"<?php echo ( $section->image ? ' data-src="' . $section->image . '" data-uk-img' : '' );?>>
            <div class="<?php echo $section->container; ?>">
                
                <div class="<?php echo $section->gridClass; ?>" data-uk-grid>
                    
                    <?php if ( $this->countModules( 'footer-left' ) ) { ?>
                    <div>
                        <jdoc:include type="modules" name="footer-left" style="master3" />
                    </div>
                    <?php } ?>
                    
                    <?php if ( $this->countModules( 'footer-center' ) ) { ?>
                    <div>
                        <jdoc:include type="modules" name="footer-center" style="master3" />
                    </div>
                    <?php } ?>
                    
                    <?php if ( $this->countModules( 'footer-right' ) ) { ?>
                    <div>
                        <jdoc:include type="modules" name="footer-right" style="master3" />
                    </div>
                    <?php } ?>

                </div>
            </div>
            
            <?php if ($this->params->get('totop')) { ?>
            <div class="uk-container uk-container-expand uk-margin-top">
                <a data-uk-totop data-uk-scroll></a>
            </div>
            <?php } ?>

        </div>
        <?php } ?>

        <?php
        if ( $this->countModules( 'offcanvas' ) )
        {
            $offcanvas = $config->getOffcanvasParams( 'offcanvas' );
        ?>
        <div id="offcanvas" data-uk-offcanvas="<?php echo $offcanvas->attrs; ?>">
            <div class="uk-offcanvas-bar<?php echo $offcanvas->class; ?>">
                <a class="uk-offcanvas-close" data-uk-close></a>
                <jdoc:include type="modules" name="offcanvas" style="master3" />
            </div>
        </div>
        <?php } ?>
        
        <?php
        if ( $this->countModules( 'offcanvas-menu' ) )
        {
            $offcanvas = $config->getOffcanvasParams( 'offcanvas-menu' );
        ?>
        <div id="offcanvas-menu" data-uk-offcanvas="<?php echo $offcanvas->attrs; ?>">
            <div class="uk-offcanvas-bar<?php echo $offcanvas->class; ?>">
                <a class="uk-offcanvas-close" data-uk-close></a>
                <jdoc:include type="modules" name="offcanvas-menu" style="master3" />
            </div>
        </div>
        <?php } ?>
        
    </div>

    <?php
    /*
     * system debug info
     */
    if ( $this->countModules( 'debug' ) )
    {
    ?>
    <jdoc:include type="modules" name="debug" style="none" />
    <?php } ?>

</body>
</html>
