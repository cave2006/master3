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

$systemOutput = $config->getSystemOutput();

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
<?php echo $head[ 'metas' ]; ?>
	<?php echo $head[ 'styles' ]; ?>
	<?php echo $head[ 'scripts' ]; ?>
</head>
<body class="<?php echo $config->getBodyClasses(); ?>">
	<jdoc:include type="message" />
	<?php if ( $systemOutput ) { ?>
	<main id="content">
		<?php echo $systemOutput; ?>
	</main>
	<?php } ?>
</body>
</html>
