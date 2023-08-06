<?php
/**
 * Copyright (c) 2015 - 2020 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

/*
 * This file contains classes aliases since some of the namespaces have changed. This is not a problem for the extension
 * itself can be an issue if 2 different extensions (eg. Datacenter view and Bubble caselogs) are on the same iTop but with different version of the Handy Framework.
 */

namespace Molkobain\iTop\Extension\HandyFramework\Common\Helper;

class ConfigHelper extends \Molkobain\iTop\Extension\HandyFramework\Helper\ConfigHelper
{

}

class StringHelper extends \Molkobain\iTop\Extension\HandyFramework\Helper\StringHelper
{

}

class UIHelper extends \Molkobain\iTop\Extension\HandyFramework\Helper\UIHelper
{

}

namespace Molkobain\iTop\Extension\HandyFramework\Common\UI;

class ToggleButton extends \Molkobain\iTop\Extension\HandyFramework\UI\ToggleButton
{

}

namespace Molkobain\iTop\Extension\HandyFramework\Console\Extension;

// Protection against extended class not existing (iTop 3.0+)
if (class_exists('\\Molkobain\\iTop\\Extension\\HandyFramework\\Hook\\Console\\PageUIExtension')) {
	class PageUIExtension extends \Molkobain\iTop\Extension\HandyFramework\Hook\Console\PageUIExtension
	{

	}
} else {
	class PageUIExtension extends \Molkobain\iTop\Extension\HandyFramework\Hook\Console\PageUIBlockExtension
	{

	}
}

namespace Molkobain\iTop\Extension\HandyFramework\Portal\Extension;

class PortalUIExtension extends \Molkobain\iTop\Extension\HandyFramework\Hook\Portal\PortalUIExtension
{

}