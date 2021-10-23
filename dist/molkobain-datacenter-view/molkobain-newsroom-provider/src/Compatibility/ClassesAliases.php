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
 * itself can be an issue if 2 different extensions (eg. Datacenter view and Bubble caselogs) are on the same iTop but with different version of the Newsroom Provider.
 */

namespace Molkobain\iTop\Extension\NewsroomProvider\Common\Helper;

class ConfigHelper extends \Molkobain\iTop\Extension\NewsroomProvider\Helper\ConfigHelper
{

}

namespace Molkobain\iTop\Extension\NewsroomProvider\Console\Extension;

// Protection, only for iTop 2.4-2.7.
// - Since 3.0 the stylesheet is fixed and this API deprecated
// - We can't use ITOP_DESIGN_LATEST_VERSION as it is not loaded yet
if (version_compare(ITOP_VERSION, '3.0.0', '<'))
{
	class PageUIExtension extends \Molkobain\iTop\Extension\NewsroomProvider\Hook\Console\PageUIExtension
	{

	}
}
