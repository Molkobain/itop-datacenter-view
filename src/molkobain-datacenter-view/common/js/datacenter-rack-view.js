/*
 * Copyright (c) 2015 - 2020 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

;
$(function()
{
	$.widget('molkobain.datacenter_rack_view', $.molkobain.datacenter_view,
		{
			options: {
				object_type: 'rack',
				defaults: {
					panel: 'front',
				},
			},

			// Constructor
			_create: function()
			{
				this._super();

				this.element.addClass('molkobain-datacenter-rack-view');
			},
			// Events bound via _bind are removed automatically
			// Revert other modifications here
			_destroy: function()
			{
				this.element.removeClass('molkobain-datacenter-rack-view');

				this._super();
			},
			// _setOptions is called with a hash of all options that are changing
			// Always refresh when changing options
			_setOptions: function()
			{
				this._superApply(arguments);
			},
			// _setOption is called for each individual option that is changing
			_setOption: function(key, value)
			{
				this._super(key, value);
			},

			// Initialize the widget
			// Inherited methods
			initialize: function()
			{
				this.enums.element_type.rack = 'rack';

				this._super();
			},
			// - Make the markup for views (eg. rack panels, enclosure panel, ...)
			_initializeViews: function()
			{
				this._initializePanels();
			},
			// - Make the markup for unmounted elements to be displayed in
			_initializeUnmountedPanels: function()
			{
				// Enclosures
				this._buildUnmountedPanelContainer('enclosure');

				// Devices
				this._super();
			},
			// - Make the markup for elements (mounted or not) and display them where they belong
			_initializeElements: function()
			{
				this._initializeEnclosures();
				this._initializeDevices();
			},
			// - Device. Overloaded to put in rack slot
			_initializeDevice: function(oDevice, oHostElem)
			{
				if((oHostElem === undefined) || (oHostElem === null))
				{
					oHostElem = this._getRackSlotElement(oDevice.position_v, oDevice.position_p);
					if(oHostElem === null)
					{
						oHostElem = this.element.find('.mdv-unmounted-type[data-type="' + this.enums.element_type.device + '"] .mdv-ut-body')
					}
				}

				return this._super(oDevice, oHostElem);
			},
			// Own methods
			// - Rack's panels, without elements
			_initializePanels: function()
			{
				for(var sPanelCode in this._getObjectDatum('panels'))
				{
					if(this.options.object_data.units_order === undefined)
					{
						this.options.object_data.units_order = this.options.defaults.units_order;
					}

					var oRackPanelElem = this._cloneTemplate('rack-panel', this.options.object_data)
						.attr('data-panel-code', sPanelCode)
						.appendTo(this.element.find('.mdv-views'));

					oRackPanelElem
						.find('.mdv-rp-title')
						.text(this._getObjectDatum('panels')[sPanelCode]);

					// Build slots
					var iTopIdx = (this._getObjectDatum('units_order') === this.enums.units_order.regular) ? this._getObjectDatum('nb_u') : 1 * -1 ;
					var iBottomIdx = (this._getObjectDatum('units_order') === this.enums.units_order.regular) ? 1 : this._getObjectDatum('nb_u') * -1 ;
					for(var iIdx = iTopIdx; iIdx >= iBottomIdx; iIdx--)
					{
						var iUnitIdx = Math.abs(iIdx);
						var oRackUnitElem = this._cloneTemplate('rack-unit')
	                        .attr('data-unit-number', iUnitIdx)
	                        .find('.mdv-ru-left')
	                        .text(iUnitIdx + 'U')
	                        .end();

						var oRackUnitInitialSlot = oRackUnitElem.find('.mdv-ru-slot')
							.attr('data-column-number', 1);
						for(var iHIdx = 2; iHIdx <= this._getObjectDatum('nb_cols'); iHIdx++)
						{
							oRackUnitInitialSlot.clone()
								.attr('data-column-number', iHIdx)
								.insertBefore(oRackUnitElem.find('.mdv-ru-right'));
						}

						oRackUnitElem.appendTo( oRackPanelElem.find('.mdv-rpv-middle') );
					}
				}
			},
			// - Rack's enclosures
			_initializeEnclosures: function()
			{
				for(var sAssemblyType in this.enums.assembly_type)
				{
					for(var iEnclosureIdx in this._getObjectDatum('enclosures')[sAssemblyType])
					{
						var oEnclosure = this._getObjectDatum('enclosures')[sAssemblyType][iEnclosureIdx];
						var oEnclosureElem = this._initializeEnclosure(oEnclosure);

						// Note: Url actually contains the hyperlink markup
						$('<div />')
							.addClass('mdv-element-note')
							.html(oEnclosure.url)
							.appendTo(oEnclosureElem);

						var oHostElem = this._getRackSlotElement(oEnclosure.position_v, oEnclosure.position_p);
						if( (sAssemblyType !== this.enums.assembly_type.mounted) || (oEnclosure.position_v === 0) || (oHostElem === null) )
						{
							oHostElem = this.element.find('.mdv-unmounted-type[data-type="' + this.enums.element_type.enclosure + '"] .mdv-ut-body');
						}
						oEnclosureElem.appendTo(oHostElem);

						// Put enclosures' elements
						for(var sEnclosureDevicesAssemblyType in this.enums.assembly_type)
						{
							for(var iDeviceIdx in oEnclosure.devices[sEnclosureDevicesAssemblyType])
							{
								var oDevice = oEnclosure.devices[sEnclosureDevicesAssemblyType][iDeviceIdx];
								var oDeviceHostElem = this._getEnclosureSlotElement(oDevice.position_v, oDevice.position_h, oDevice.position_p, oEnclosure.id);
								var bAddNoteToDevice = false;
								if( (sEnclosureDevicesAssemblyType !== this.enums.assembly_type.mounted) || (oDeviceHostElem === null) )
								{
									oDeviceHostElem = this.element.find('.mdv-unmounted-type[data-type="' + this.enums.element_type.device + '"] .mdv-ut-body');
									bAddNoteToDevice = true;
								}

								var oDeviceElem = this._initializeDevice(oDevice, oDeviceHostElem);
								if(bAddNoteToDevice === true)
								{
									// Note: Url actually contains the hyperlink markup
									$('<div />')
										.addClass('mdv-element-note')
										.html('<i class="fas fa-link" aria-hidden="true"></i>' + oEnclosure.url)
										.appendTo(oDeviceElem);
								}
							}
						}

						// Tooltip
						if (oEnclosure.tooltip !== undefined) {
							if (this.options.use_legacy_tooltips) {
								// Note: We need to do a deep copy
								var oQTipOptions = $.extend(
									true,
									{},
									this.options.defaults.tooltip_options,
									{ content: oEnclosure.tooltip.content }
								);
								oQTipOptions.position.adjust.x = -16;
								oEnclosureElem.find('.mdv-element-note').qtip(oQTipOptions);
							} else {
								oEnclosureElem.find('.mdv-element-note')
								.attr('data-tooltip-html-enabled', true)
								.attr('data-tooltip-placement', 'left')
								.attr('data-tooltip-distance-offset', '16')
								.attr('data-tooltip-theme', 'molkobain-light mdv-element-tooltip')
								.attr('data-tooltip-content', oEnclosure.tooltip.content);
							}
						}
					}
				}

				return oEnclosureElem;
			},

			// Getters
			// - Return the jQuery object for the iSlotNumber slot of the sPanelCode rack if found, null otherwise
			_getRackSlotElement: function(iSlotNumber, sPanelCode)
			{
				if(sPanelCode === undefined)
				{
					sPanelCode = this.options.defaults.panel;
				}

				var oSlotElem = this.element.find('.mdv-rack-panel[data-panel-code="' + sPanelCode + '"] .mdv-rack-unit[data-unit-number="' + iSlotNumber + '"] .mdv-ru-slot');
				if(oSlotElem.length === 0)
				{
					this._trace('Could not find rack slot "' + iSlotNumber + 'U" for panel "' + sPanelCode + '".');
					return null;
				}

				return oSlotElem;
			},
		}
	);
});
