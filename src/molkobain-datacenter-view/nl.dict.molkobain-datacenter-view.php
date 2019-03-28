<?php
/**
 * Copyright (c) 2015 - 2019 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */
Dict::Add('NL NL', 'Dutch', 'Nederlands', array(
	// Classes
	// - Rack
	'Class:Rack/Attribute:nb_u+' => 'Hoogte in units (U) waarover deze rack beschikt',
	// - Enclosure
	'Class:Enclosure/Attribute:nb_u' => 'Hoogte',
	'Class:Enclosure/Attribute:nb_u+' => 'Hoogte van deze behuizing in units (U)',
	'Class:Enclosure/Attribute:position_v' => 'Positie',
	'Class:Enclosure/Attribute:position_v+' => 'Verticale positie (U) van de behuizing in de rack. Vanaf beneden.',
	// - Datacenter device
	'Class:DatacenterDevice/Attribute:nb_u' => 'Hoogte',
	'Class:DatacenterDevice/Attribute:nb_u+' => 'Hoogte van dit toestel in units (U)',
	'Class:DatacenterDevice/Attribute:position_v' => 'Positie',
	'Class:DatacenterDevice/Attribute:position_v+' => 'Verticale positie (U) van dit toestel in de behuizing (of van de rack indien er rechtstreeks ingemonteerd). Vanaf beneden.',

	// UI
	'Molkobain:DatacenterView:Tabs:View:Title' => 'Grafische weergave',
	// - Legend
	'Molkobain:DatacenterView:Legend:Title' => 'Legende',
	// - Options
	'Molkobain:DatacenterView:Options:Title' => 'Opties',
	'Molkobain:DatacenterView:Options:Option:ShowObsolete' => 'Toon objecten die buiten dienst zijn',
	'Molkobain:DatacenterView:Options:Option:ShowObsolete+' => 'Deze waarde is enkel van toepassing op dit object',
	// - Tooltip
	'Molkobain:DatacenterView:Element:Tooltip:Fieldset:base-info' => 'Basisinfo',
	'Molkobain:DatacenterView:Element:Tooltip:Fieldset:more-info' => 'Meer info',
	// - Rack
	'Molkobain:DatacenterView:Rack:Panel:Front:Title' => 'Voorkant',
	// - Enclosure
	'Molkobain:DatacenterView:Enclosure:Panel:Front:Title' => 'Voorkant',
	// - Unmounted elements
	'Molkobain:DatacenterView:Unmounted:Enclosures:Title' => 'Ongemonteerde behuizingen',
	'Molkobain:DatacenterView:Unmounted:Enclosures:Title+' => 'Horend bij dit rack, maar positie nog niet bepaald (bewerk de behuizing om dit te doen)',
	'Molkobain:DatacenterView:Unmounted:Devices:Title' => 'Ongemonteerde toestellen',
	'Molkobain:DatacenterView:Unmounted:Devices:Title+' => 'Horend bij dit rack/behuizing, maar positie nog niet bepaald (bewerk het toestel om dit te doen)',
));
