<?php
/**
 * Copyright (c) 2015 - 2018 Molkobain.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

Dict::Add('EN US', 'English', 'English', array(
	// Classes
	// - Rack
	'Class:Rack/Attribute:nb_u+' => 'Height in units (U) of the rack',
	// - Enclosure
	'Class:Enclosure/Attribute:nb_u+' => 'Height in units (U) of the enclosure',
	'Class:Enclosure/Attribute:position_v' => 'Position',
	'Class:Enclosure/Attribute:position_v+' => 'Vertical position (U) of the enclosure in the rack (Must be the bottom position, not top)',
	// - Datacenter device
	'Class:DatacenterDevice/Attribute:nb_u+' => 'Height in units (U) of the device',
	'Class:DatacenterDevice/Attribute:position_v' => 'Position',
	'Class:DatacenterDevice/Attribute:position_v+' => 'Vertical position (U) of the device in the enclosure (or rack if mounted directly on it). Must be the bottom position, not top.',

	// UI
	'Molkobain:DatacenterView:Tabs:View:Title' => 'Graphical view',
	// - Legend
	'Molkobain:DatacenterView:Legend:Title' => 'Legend',
	// - Tooltip
	'Molkobain:DatacenterView:Element:Tooltip:Fieldset:base-info' => 'Base information',
	'Molkobain:DatacenterView:Element:Tooltip:Fieldset:more-info' => 'More information',
	// - Rack
	'Molkobain:DatacenterView:Rack:Panel:Front:Title' => 'Front',
	// - Unmounted elements
	'Molkobain:DatacenterView:Unmounted:Enclosures:Title' => 'Unmounted enclosures',
	'Molkobain:DatacenterView:Unmounted:Enclosures:Title+' => 'Attached to this rack but no position set (Edit the enclosure to do so)',
	'Molkobain:DatacenterView:Unmounted:Devices:Title' => 'Unmounted devices',
	'Molkobain:DatacenterView:Unmounted:Devices:Title+' => 'Attached to this rack / enclosure but no position set (Edit the device to do so)',
));
