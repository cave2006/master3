<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.master3
 *
 * @copyright   Copyright (C) 2018 Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\Filesystem\Path;
use Joomla\CMS\Language\LanguageHelper;

defined('_JEXEC') or die;

final class Master3Config
{
    
    /*
     * Instance
     */
    private static $instance = null;
    
    /*
     * Document object
     */
    private $doc = null;

    /*
     * Registry object
     */
    private $name = 'master3';

    /*
     * Registry object
     */
    private $params = null;
    
    
    /*
     * Get static Instance
     * 
     * @return object this
     */
    static public function getInstance()
    {
        if ( self::$instance === null)
        {
            self::$instance = new Master3Config();
        }

        return self::$instance;
    }
    
    
    /*
     * Constrictor
     */
    protected function __construct()
    {
        $this->doc = Factory::getDocument();
        
        $this->name = strtolower( $this->doc->template );
        $this->params = $this->doc->params;

        if ( !isset( $this->params ) )
        {
            $template = Factory::getApplication()->getTemplate( true );
            $this->name = strtolower( $template->template );
            $this->params = $template->params;
        }

        // param sections recompose
        $sections = [];
        
        foreach ( $this->params->get( 'sections' ) as $item )
        {
            $section = new \stdClass();
            $section->id = $item->form->id ? htmlspecialchars( $item->form->id, ENT_QUOTES, 'UTF-8' ) : $item->form->name;
            
            $section->class = [];
            $section->class[] = $item->form->padding;
            $section->class[] = $item->form->style;
            $section->class[] = isset( $item->form->light ) ? 'uk-light' : '';
            $section->class[] = htmlspecialchars( $item->form->class, ENT_COMPAT, 'UTF-8' );
            $section->class = implode( ' ', $section->class );
            
            $section->image = $item->form->image && Path::clean( JPATH_BASE . '/' . $item->form->image ) ? $item->form->image : '';
            if ( $section->image )
            {
                $section->class .= ' uk-background-cover';
            }
            
            $section->container = $item->form->container;

            $section->responsive = $item->form->responsive === 'stacked' ? '' : '@' . $item->form->responsive[0] ;
            
            $section->gridClass = [];
            $section->gridClass[] = $item->form->gutter;
            $section->gridClass[] = isset( $item->form->divider ) ? 'uk-grid-divider' : '';
            $section->gridClass[] = isset( $item->form->center ) ? 'uk-flex-center' : '';
            $section->gridClass = implode( ' ', $section->gridClass );
            
            $sections[ $item->form->name ] = $section;
            unset( $section );
        }
        
        $this->params->set( 'sections', $sections );

        
        // param modules recompose
        $modules = [];
        
        foreach ( $this->params->get( 'modules' ) as $item )
        {
            $module = new \stdClass();
            
            $module->class = [];
            $module->class[] = $item->form->display;
            $module->class[] = $item->form->moduleBox;
            $module->class[] = $item->form->moduleBox !== 'uk-panel' ? $item->form->modulePadding : '';
            $module->class[] = isset( $item->form->light ) ? 'uk-light' : '';
            $module->class[] = htmlspecialchars( $item->form->moduleClass, ENT_COMPAT, 'UTF-8' );
            $module->class = implode( ' ', $module->class );
            
            $module->align = $item->form->moduleAlign;
            $module->titleTag = $item->form->titleTag;
            $module->titleClass = htmlspecialchars( $item->form->titleClass, ENT_COMPAT, 'UTF-8' );
            $module->titleLink = htmlspecialchars( $item->form->titleLink, ENT_QUOTES, 'UTF-8' );
            
            $modules[ $item->form->id ] = $module;
            unset( $module );
        }
        
        $this->params->set( 'modules', $modules );

        
        // param menu recompose
        $menuItems = [];
        $navbarBoundary = $this->params->get( 'navbarBoundary' ) === 'justify';
        
        foreach ( $this->params->get( 'menuitems' ) as $item )
        {
            $menuItem = new \stdClass();
            
            $menuItem->cols = $item->form->gridColumns;
            $menuItem->divider = isset( $item->form->gridDivider ) && $item->form->gridDivider == true;
            $menuItem->subtitle = htmlspecialchars( $item->form->subtitle, ENT_COMPAT, 'UTF-8' );
            $menuItem->dropdownJustify = $navbarBoundary;
            $menuItem->first = true;
                
            $menuItems[ $item->form->menuid ] = $menuItem;
            unset( $menuItem );
        }
        
        $this->params->set( 'menuitems', $menuItems );

        
        // param offcanvas recompose
        $offcanvas = [];
        
        foreach ( $this->params->get( 'offcanvas' ) as $item )
        {
            $oc = new \stdClass();
            
            $oc->class = htmlspecialchars( $item->form->class, ENT_COMPAT, 'UTF-8' );
            
            $oc->attrs = [];
            $oc->attrs[] = 'mode:' . $item->form->mode;
            $oc->attrs[] = isset( $item->form->overlay ) ? 'overlay:true' : '';
            $oc->attrs[] = isset( $item->form->flip ) ? 'flip:true' : '';
            $oc->attrs = implode( ';', $oc->attrs );
            
            $offcanvas[ $item->form->posname ] = $oc;
            unset( $oc );
        }
        
        $this->params->set( 'offcanvas', $offcanvas );
    }


    /*
     * Get mime-type
     * 
     * @param string $file
     * 
     * @retutn string
     */
    protected function getMime( $file )
    {
        if ( function_exists( 'mime_content_type' ) )
        {
            return @mime_content_type( $file );
        }
        else
        {
            $ext = strtolower( pathinfo( $file, PATHINFO_EXTENSION ) );
            switch ( $ext )
            {
                case 'png': $mime = 'image/png'; break;
                
                case 'jpeg':
                case 'jpe':
                case 'jpg': $mime = 'image/jpeg'; break;
                
                case 'gif': $mime = 'image/gif'; break;
                
                case 'svg':
                case 'svgz': $mime = 'image/svg+xml'; break;
                
                case 'tiff':
                case 'tif': $mime = 'image/tiff'; break;

                case 'ico': $mime = 'image/vnd.microsoft.icon'; break;

                default: $mime = '';
            }
            return $mime;
        }
    }

    
    /*
     * Head section data
     * 
     * @return array
     */
    public function getHead()
    {
        $tpath = '/templates/' . $this->name;
        
        /*
         * load template css
         */
        $cssUikit = $this->params->get( 'cssUikit' );
        if ( $cssUikit !== 'none' )
        {
            $this->doc->addStyleSheet( $tpath . '/uikit/dist/css/' . $cssUikit, [], [ 'options' => [ 'version' => 'auto' ] ] );
        }
        
        if ( $this->params->get( 'cssTheme' ) )
        {
            $this->doc->addStyleSheet( $tpath . '/css/theme.css', [], [ 'options' => [ 'version' => 'auto' ] ] );
        }
        
        if ( $this->params->get( 'cssCustom' ) )
        {
            $this->doc->addStyleSheet( $tpath . '/css/custom.css', [], [ 'options' => [ 'version' => 'auto' ] ] );
        }

        $cssAddons = $this->params->get( 'cssAddons' );
        $cssAddons = explode( "\n", $cssAddons );
        foreach ( $cssAddons as $cssAddonFile )
        {
            $cssAddonFile = realpath( Path::clean( JPATH_ROOT . '/' . htmlspecialchars( trim( $cssAddonFile ) ) ) );
            if ( is_file( $cssAddonFile ) && strtolower( pathinfo( $cssAddonFile, PATHINFO_EXTENSION ) ) == 'css' )
            {
                $cssAddonFile = str_replace( '\\', '/', str_replace( JPATH_ROOT, '', $cssAddonFile ) );
                $this->doc->addStyleSheet( $cssAddonFile, [], [ 'options' => [ 'version' => 'auto' ] ] );
            }
        }

        
        /*
         * load template js
         */
        $jsUikit = $this->params->get( 'jsUikit' );
        if ( $jsUikit !== 'none' )
        {
            $this->doc->addScript( $tpath . '/uikit/dist/js/' . $jsUikit, [], [ 'options' => [ 'version' => 'auto' ] ] );
        }

        $jsIcons = $this->params->get( 'jsIcons' );
        if ( $jsIcons !== 'none' )
        {
            $this->doc->addScript( $tpath . '/uikit/dist/js/' . $jsIcons, [], [ 'options' => [ 'version' => 'auto' ] ] );
        }
        
        if ( $this->params->get( 'jsCustom' ) )
        {
            $this->doc->addScript( $tpath . '/js/custom.js', [], [ 'options' => [ 'version' => 'auto' ] ] );
        }

        $jsAddons = $this->params->get( 'jsAddons' );
        $jsAddons = explode( "\n", $jsAddons );
        foreach ( $jsAddons as $jsAddonFile )
        {
            $jsAddonFile = realpath( Path::clean( JPATH_ROOT . '/' . htmlspecialchars( trim( $jsAddonFile ) ) ) );
            if ( is_file( $jsAddonFile ) && strtolower( pathinfo( $cssAddonFile, PATHINFO_EXTENSION ) ) == 'js' )
            {
                $jsAddonFile = str_replace( '\\', '/', str_replace( JPATH_ROOT, '', $jsAddonFile ) );
                $this->doc->addScript( $jsAddonFile, [], [ 'options' => [ 'version' => 'auto' ] ] );
            }
        }


        /*
         * render head section
         */
        $out = [];
        $this->doc->setHtml5(true);
        $this->doc->setGenerator( '' );
        $head = $this->doc->getHeadData();
        $mediaVersion = $this->doc->getMediaVersion();
        
        /*
         * Metas
         */
        $out[ 'metas' ] = [];
        
        // charset
        $out[ 'metas' ][] = '<meta charset="' . $this->doc->getCharset() . '" />';
        
        // viewport
        $out[ 'metas' ][] = '<meta name="viewport" content="width=device-width, initial-scale=1">';
        
        // IE compatible
        $out[ 'metas' ][] = '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
        
        // base
        $out[ 'metas' ][] = '<base href="' . $this->doc->getBase() . '" />';
        
        // title
        $out[ 'metas' ][] = '<title>' . $head[ 'title' ] . '</title>';
        
        // meta description
        if ( $head[ 'description' ] )
        {
            $out[ 'metas' ][] = '<meta name="description" content="' . $head[ 'description' ] . '" />';
        }

        // meta tags
        foreach ( $head[ 'metaTags' ] as $attr => $vals )
        {
            foreach ( $vals as $name => $content )
            {
                if ( $attr == 'http-equiv' && $name != 'content-type' )
                {
                    $out[ 'metas' ][] = '<meta http-equiv="' . $name . '" content="' . htmlspecialchars( $content, ENT_COMPAT, 'UTF-8' ) . '" />';
                }
                elseif ( $attr != 'http-equiv' && !empty( $content ) )
                {
                    if ( is_array( $content ) )
                    {
                        foreach ( $content as $value )
                        {
                            $out[ 'metas' ][] = '<meta ' . $attr . '="' . $name . '" content="' . htmlspecialchars( $value, ENT_COMPAT, 'UTF-8' ) . '" />';
                        }
                    }
                    else
                    {
                        $out[ 'metas' ][] = '<meta ' . $attr . '="' . $name . '" content="' . htmlspecialchars( $content, ENT_COMPAT, 'UTF-8' ) . '" />';
                    }
                }
            }
        }
        
        // favicon
        $favicon = $this->params->get( 'favicon', '' );
        if ( $favicon && is_file( Path::clean( JPATH_BASE . '/' . $favicon ) ) )
        {
            $type = $this->getMime( Path::clean( JPATH_BASE . '/' . $favicon ) );
            $type = $type ? ' " type="' . $type . '"' : '';
            $out[ 'metas' ][] = '<link rel="shortcut icon" href="' . $favicon . $type . '>';
        }
        
        // favicon for apple devices
        $faviconApple = $this->params->get( 'faviconApple', '' );
        if ( $faviconApple && is_file( Path::clean( JPATH_BASE . '/' . $faviconApple ) ) )
        {
            $out[ 'metas' ][] = '<link rel="apple-touch-icon-precomposed" href="' . $faviconApple .'">';
        }

        // custom links
        if ( $head[ 'links' ] )
        {
            foreach ($head[ 'links' ] as $linkName => $linkParams )
            {
                $rel = $linkParams[ 'relation' ] ? ' ' . $linkParams[ 'relType' ] . '="' . $linkParams[ 'relation' ] . '"' : '';
                $buffer = '';
                $version = '';

                if ( $linkParams[ 'attribs' ] )
                {
                    foreach ( $linkParams[ 'attribs' ] as $attr => $val )
                    {
                        if ( $attr == 'version' )
                        {
                            $version = $val == 'auto' ? $mediaVersion : $val;
                        }
                        else
                        {
                            $buffer .= ' ' . $attr . '="' . htmlspecialchars( $val, ENT_COMPAT, 'UTF-8' ) . '"';
                        }
                    }
                }

                if ( $version )
                {
                    $version = '?' . $version;
                }

                $out[ 'metas' ][] = '<link' . $rel . ' href="' . $linkName . $version . '"' . $buffer . '>';
            }
        }

        // custom meta tags
        if ( $head[ 'custom' ] )
        {
            foreach ( $head[ 'custom' ] as $meta )
            {
                $out[ 'metas' ][] = $meta;
            }
        }

        
        /*
         * Styles
         */
        $out[ 'styles' ] = [];
        
        $fonts = $this->getFonts();
        if ( $fonts )
        {
            $out[ 'styles' ][] = $fonts[ 'link' ];
        }
        
        if ( $head[ 'styleSheets' ] )
        {
            foreach ( $head[ 'styleSheets' ] as $styleName => $stypeParams )
            {
                $version = isset( $stypeParams[ 'options' ][ 'version' ] ) ? $stypeParams[ 'options' ][ 'version' ] : '';
                $version = $version == 'auto' ? $mediaVersion : $version;
                $type = $stypeParams[ 'type' ] == 'text/css' ? '' : ' type="' . $stypeParams[ 'type' ] . '"';
                
                if ( $version )
                {
                    $version = '?' . $version;
                }
                
                $out[ 'styles' ][] = '<link rel="stylesheet" href="' . $styleName . $version . '"' . $type . '>';
            }
        }

        if ( $head[ 'style' ] )
        {
            foreach ( $head[ 'style' ] as $type => $style )
            {
                $typeAttr = $type == 'text/css' ? '' : ' type="' . $type . '"';
                $out[ 'styles' ][] = "<style" . $typeAttr . ">\n" . $style . "\n\t</style>";
            }
        }

        if ( $fonts )
        {
            $out[ 'styles' ][] = "<style>\n" . $fonts[ 'style' ] . "\n\t</style>";
        }

        
        /*
         * Scripts
         */
        $out[ 'scripts' ] = [];
        
        if ( $head[ 'scripts' ] )
        {
            foreach ( $head[ 'scripts' ] as $scriptName => $scriptParams )
            {
                $version = isset( $scriptParams[ 'options' ][ 'version' ] ) ? $scriptParams[ 'options' ][ 'version' ] : '';
                $version = $version == 'auto' ? $mediaVersion : $version;
                $type = $scriptParams[ 'type' ] == 'text/javascript' ? '' : ' type="' . $scriptParams[ 'type' ] . '"';
                
                if ( $version )
                {
                    $version = '?' . $version;
                }
                
                $out[ 'scripts' ][] = '<script src="' . $scriptName . $version . '"' . $type . '></script>';
            }
        }

        if ( $head[ 'script' ] )
        {
            foreach ( $head[ 'script' ] as $type => $script )
            {
                $typeAttr = $type == 'text/javascript' ? '' : ' type="' . $type . '"';
                $out[ 'scripts' ][] = "<script" . $typeAttr . ">\n" . $script . "\n\t</script>";
            }
        }

        
        /*
         * Output
         */
        $out[ 'metas' ] = trim( implode( "\n\t", $out[ 'metas' ] ) ) . "\n\n";
        $out[ 'styles' ] = trim( implode( "\n\t", $out[ 'styles' ] ) ) . "\n\n";
        $out[ 'scripts' ] = trim( implode( "\n\t", $out[ 'scripts' ] ) ) . "\n\n";

        return $out;
    }


    /*
     * Google Fonts links
     * 
     * @return array
     */
    protected function getFonts()
    {
        $fontsList = [
            0 => $this->params->get( 'fontHtml', '' ),
            1 => $this->params->get( 'fontHeading', '' ),
            2 => $this->params->get( 'fontLogo', '' ),
            3 => $this->params->get( 'fontNavbar', '' ),
            4 => $this->params->get( 'fontPre', '' )
        ];
        
        $tmp = $fontsList;
        if ( !array_diff( $tmp, [''] ) )
        {
            return [];
        }
        unset( $tmp );
        
        $variants = implode( ',', $this->params->get( 'fontsVariants', 'regular' ) );
        $variants = $variants === 'regular' ? '' : ':' . $variants;
        
        $subsets = implode( ',', $this->params->get( 'fontsSubsets', 'latin' ) );
        $subsets = $subsets === 'latin' ? '' : '&amp;subset=' . $subsets;
        
        $tmpLink = [];
        $tmpStyle = [];
        $htmlFont = '';
        $css = [
            0 => 'html',
            1 => 'h1,h2,h3,h4,h5,h6,.uk-h1,.uk-h2,.uk-h3,.uk-h4,.uk-h5,.uk-h6',
            2 => '.uk-logo',
            3 => '.uk-navbar-nav>li>a,.uk-navbar-item,.uk-navbar-toggle',
            4 => 'pre,pre code,:not(pre)>code,:not(pre)>kbd,:not(pre)>samp'
        ];

        foreach ( $fontsList as $i => $font )
        {
            $font = htmlspecialchars( trim( $font ) );
            
            if ( $i == 0 )
            {
                $htmlFont = $font;
            }

            $font_ = str_replace( ' ', '+', $font );
            $font_ = $font_ ? $font_ . $variants : '';
            if ( $font_ && array_search( $font_, $tmpLink, true) === false )
            {
                $tmpLink[] = $font_;
            }

            if ( $font !== '' )
            {
                $tmpStyle[] = $css[ $i ] . "{font-family:'{$font}'}";
            }
            elseif ( $i > 0 && $htmlFont !== '')
            {
                $tmpStyle[] = $css[ $i ] . "{font-family:'{$htmlFont}'}";
            }
        }

        $head[ 'link' ] = '<link rel="stylesheet" href="//fonts.googleapis.com/css?family=' . implode( '|', $tmpLink ) . $subsets . '">';

        $head[ 'style' ] = implode( "\n", $tmpStyle );
        
        return $head;
    }


    /*
     * Logo positions render
     * 
     * @return text/html
     */
    public function getLogo()
    {
        $lang = Factory::getLanguage();
        $langDefault = $lang->getDefault();
        $langActive = $lang->getTag();

        $langSef = '';
        if ( $langActive !== $langDefault )
        {
            $langList = LanguageHelper::getLanguages();
            foreach ( $langList as $langItem )
            {
                if ( $langItem->lang_code === $langActive )
                {
                    $langSef = $langItem->sef . '/';
                    break;
                }
            }
        }
        
        $isMain = ( Uri::current() == Uri::base() ) || ( Uri::current() == Uri::base() . $langSef );
        $logotag = $isMain ? 'span' : 'a';
        $logohref = $isMain ? '' : ' href="/' . $langSef . '"';
        $out = '';
        
        if ( $this->doc->countModules( 'logo' ) )
        {
            $out .= "<{$logotag}{$logohref} class=\"uk-logo uk-display-inline-block\">";
            $out .= '<jdoc:include type="modules" name="logo" style="none" />';
            $out .= "</{$logotag}>";
        }
        else
        {
            $logoFile = $this->params->get( 'logoFile', '' );
            $siteTitle = $this->params->get( 'siteTitle', '' );
            
            if ( $logoFile || $siteTitle )
            {
                $out .= "<{$logotag}{$logohref} class=\"uk-logo uk-flex-inline uk-flex-middle\">";

                if ( $logoFile )
                {
                    $mime = $this->getMime( Path::clean( JPATH_BASE . '/' . $logoFile ) );
                    if ( $mime == 'image/svg' || $mime == 'image/svg+xml' )
                    {
                        $out .= file_get_contents( Path::clean( JPATH_BASE . '/' . $logoFile ) );
                    }
                    else
                    {
                        $out .= "<img src=\"{$logoFile}\" alt=\"{$siteTitle}\">";
                    }
                }

                if ( $siteTitle )
                {
                    $out .= '<span' . ( $logoFile ? ' class="uk-display-inline-block uk-margin-small-left"' : '' ) . '>' . $siteTitle . '</span>';
                }

                $out .= "</{$logotag}>";
            }
        }

        return $out;            
    }


    /*
     * Get component buffer
     * 
     * @return text/html
     */
    public function getSystemOutput()
    {
        $isMain = Uri::current() == Uri::base();

        if ( $isMain && $this->params->get( 'noComponentMain', false ) )
        {
            return '';
        }

        $out = $this->doc->getBuffer( 'component' );
        
        $clean = $out;
        $clean = htmlspecialchars( strip_tags( $clean ) );
        $clean = str_replace( "\t", '', $clean );
        $clean = str_replace( "\n", '', $clean );
        $clean = trim( $clean );
        
        return $clean ? $out : '';
    }


    /*
     * Get classes for <body> tag
     * 
     * @return string
     */
    public function getBodyClasses()
    {
        $app = Factory::getApplication();
        $out = [];
        
        $out[] = 'option--' . $app->input->getCmd( 'option', '' );
        $out[] = 'view--' . $app->input->getCmd( 'view', '' );
        $out[] = 'layout--' . $app->input->getCmd( 'layout', '' );
        $out[] = 'task--' . $app->input->getCmd( 'task', '' );
        $out[] = 'Itemid--' . $app->input->getCmd( 'Itemid', '' );
        
        return implode( ' ', $out );
    }

    /*
     * Get section params
     * 
     * @param string $sectionName
     * 
     * @return oject
     */
    public function getSectionParams( $sectionName )
    {
        $sections = $this->params->get( 'sections' );
        
        if ( isset( $sections[ $sectionName ] ) )
        {
            $section = $sections[ $sectionName ];
        }
        else
        {
            $section = new \stdClass();
            $section->class = 'uk-section uk-section-default';
            $section->container = 'uk-container';
            $section->image = '';
            $section->responsive = '@m';
            $section->gridClass = '';
        }

        if ( $sectionName === 'navbar' )
        {
            $section->class .= ' uk-navbar-container' . ( $this->params->get( 'navbarTransparent', 0 ) ? ' uk-navbar-transparent' : '' );
            
            $section->sticky = $this->params->get( 'navbarSticky', 0 ) ? ' data-uk-sticky' : '';
            
            $section->dropbarMode = false;
            $navbarMode = [];
            
            if ( $this->params->get( 'navbarClickMode', 0 ) )
            {
                $navbarMode[] = 'mode:click';
            }
            
            if ( $this->params->get( 'navbarDropbar', 0 ) )
            {
                $section->dropbarMode = true;
                $section->container .= ' uk-position-relative';
                
                $navbarMode[] = 'dropbar:true';
                
                if ( $this->params->get( 'navbarDropbarPush', 0 ) )
                {
                    $navbarMode[] = 'dropbar-mode:push';
                }
            }

            $boundary = $this->params->get( 'navbarBoundary', '' );
            if ( $boundary && $boundary !== 'justify' )
            {
                $navbarMode[] = 'boundary-align:true';
                $navbarMode[] = 'align:' . $boundary;
            }

            $section->navbarMode = $navbarMode ? '="' . implode( ';', $navbarMode ) . '"' : '';
        }

        if ( $sectionName === 'main' )
        {
            $section->sidebarGridSize = $this->params->get( 'sbWidth', '1-5' );
            $section->sidebarAClass = $this->params->get( 'sbPosA', 1 ) ? 'uk-flex-first ' : '';
            $section->sidebarBClass = $this->params->get( 'sbPosB', 1 ) ? 'uk-flex-first ' : '';
            
            $countSidebarA = $this->doc->countModules( 'sidebar-a' );
            $countSidebarB = $this->doc->countModules( 'sidebar-b' );
            
            if ( !$countSidebarA && !$countSidebarB )
            {
                $section->mainGridSize = '1-1';
                $section->responsive = '';
            }
            else
            {
                switch ( $section->sidebarGridSize )
                {
                    case '1-6':
                        $section->mainGridSize = $countSidebarA && $countSidebarB ? '4-6' : '5-6';
                        break;
                    case '1-5':
                        $section->mainGridSize = $countSidebarA && $countSidebarB ? '3-5' : '4-5';
                        break;
                    case '1-4':
                        $section->mainGridSize = $countSidebarA && $countSidebarB ? '1-2' : '3-4';
                        break;
                    case '1-3':
                        $section->mainGridSize = $countSidebarA && $countSidebarB ? '1-3' : '2-3';
                        break;
                    case '2-5':
                        $section->mainGridSize = $countSidebarA && $countSidebarB ? '1-5' : '3-5';
                        break;
                    case '1-2':
                        $section->mainGridSize = '1-1';
                        break;
                }
            }
        }
        
        $section->id = $sectionName;

        return $section;
    }

    
    /*
     * Get modile params
     * 
     * @param string $moduleId
     * 
     * @return array
     */
    public function getModuleParams( $moduleId )
    {
        $modules = (array)$this->params->get( 'modules' );
        
        if ( isset( $modules[ $moduleId ] ) )
        {
            $module = $modules[ $moduleId ];
        }
        else
        {
            $module = new \stdClass();
            $module->class = 'uk-panel';
            $module->align = '';
            $module->titleTag = 'module';
            $module->titleClass = '';
            $module->titleLink = '';
        }
        
        $module->id = $moduleId;
        
        return $module;
    }


    /*
     * Get off-canvas toggle sfx class
     * 
     * @retutn string
     */
    public function getOffcanvasToggle()
    {
        return $this->params->get( 'offtoggle', '@m' );
    }


    /*
     * Get menuitem params
     * 
     * @param int $itemId
     * 
     * @retutn array
     */
    public function getMenuItemParams( $itemId )
    {
        $menuItems = (array)$this->params->get( 'menuitems' );
    
        if ( isset( $menuItems[ $itemId ] ) )
        {
            $menuItem = $menuItems[ $itemId ];
        }
        else
        {
            $menuItem = new \stdClass();
            $menuItem->cols = 1;
            $menuItem->divider = false;
            $menuItem->subtitle = '';
            $menuItem->dropdownJustify = false;
            $menuItem->first = false;
        }

        $menuItem->id = $itemId;
        
        return $menuItem;
    }


    /*
     * Get off-canvas params
     * 
     * @param string $position
     * 
     * @retutn array
     */
    public function getOffcanvasParams( $position )
    {
        $offcanvas = (array)$this->params->get( 'offcanvas' );
        
        if ( isset( $offcanvas[ $position ] ) )
        {
            $oc = $offcanvas[ $position ];
        }
        else
        {
            $oc = new \stdClass();
            $oc->class = '';
            $oc->attrs = 'mode:slide;overlay:true';
        }
        
        $oc->id = $position;
        
        return $oc;
    }


    /*
     * Get DUA params
     * 
     * @retutn string
     */
    public function getDUA()
    {
        return (int) $this->params->get( 'denyUserAuthorization', 0 );
    }

}