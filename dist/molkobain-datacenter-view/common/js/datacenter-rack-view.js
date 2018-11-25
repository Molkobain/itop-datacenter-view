/*
 * Copyright (c) 2015 - 2018 Molkobain.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

;
$(function()
{
	$.widget('molkobain.datacenter_rack_view', $.molkobain.datacenter_view,
		{
			options: {
				object_type: 'rack',
				enums: {
					assembly: {
						mounted: 'mounted',
						unmounted: 'unmounted',
					},
				},
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
			// - Make the markup for views (eg. rack panels, enclosure panel, ...)
			_initializeViews: function()
			{
				this._initializePanels();
			},
			// - Make the markup for unmounted elements to be displayed in
			_initializeUnmounted: function()
			{
				// Enclosures
				var oEnclosuresContainer = this._cloneTemplate('unmounted-type')
					.attr('data-type', 'enclosure')
					.appendTo( this.element.find('.mdv-unmounted') );

				// Devices
				this._super();
			},
			// - Make the markup for elements (mounted or not) and display them where they belong
			_initializeElements: function()
			{
				this._initializeEnclosures();
				this._initializeDevices();
			},
			// Own methods
			// - Rack's panels, without elements
			_initializePanels: function()
			{
				for(var sPanelCode in this._getObjectDatum('panels'))
				{
					var oRackPanelElem = this._cloneTemplate('rack-panel')
						.attr('data-class', this._getObjectDatum('class'))
						.attr('data-id', this._getObjectDatum('id'))
						.attr('data-code', sPanelCode)
						.attr('data-name', this._getObjectDatum('name'))
						.appendTo(this.element.find('.mdv-views'));

					oRackPanelElem
						.find('.mdv-rp-title')
						.text(this._getObjectDatum('panels')[sPanelCode]);

					for(var iUnitsIdx = 1; iUnitsIdx <= this._getObjectDatum('nb_u'); iUnitsIdx++)
					{
						var oRackUnitElem = this._cloneTemplate('rack-unit')
	                        .attr('data-unit-number', iUnitsIdx)
	                        .find('.mdv-ru-left')
	                        .text(iUnitsIdx + 'U')
	                        .end()
	                        .prependTo( oRackPanelElem.find('.mdv-rpv-middle') );
					}
				}
			},
			// - Rack's enclosures
			_initializeEnclosures: function()
			{
				for(var sAssemblyCode in this.options.enums.assembly)
				{
					for(var iEnclosureIdx in this._getObjectDatum('enclosures')[sAssemblyCode])
					{
						var oEnclosure = this._getObjectDatum('enclosures')[sAssemblyCode][iEnclosureIdx];
						var oEnclosureElem = this._cloneTemplate('enclosure')
						                         .attr('data-class', oEnclosure.class)
						                         .attr('data-id', oEnclosure.id)
						                         .attr('data-name', oEnclosure.name)
						                         .attr('data-rack-id', this._getObjectDatum('id'))
						                         .attr('data-position-v', oEnclosure.position_v);

						// Full height of n Us plus the bottom-border of n-1 Us
						oEnclosureElem
							.css('height', 'calc(' + (oEnclosure.nb_u * 100) + '% + ' + (oEnclosure.nb_u - 1) + 'px)');

						if(sAssemblyCode === this.options.enums.assembly.mounted)
						{
							oEnclosureElem.appendTo(this._getRackSlotElement(oEnclosure.position_v, oEnclosure.position_p));
						}
						else
						{
							oEnclosureElem.appendTo(this.element.find('.mdv-unmounted-type[data-type="enclosure"] .mdv-ut-content'));
						}

						// TODO: Put enclosures' elements
					}
				}
			},
			// - Rack's devices
			_initializeDevices: function()
			{
				for(var iDeviceIdx in this._getObjectDatum('devices').mounted)
				{
					var oDevice = this._getObjectDatum('devices').mounted[iDeviceIdx];
					var oDeviceElem = this._cloneTemplate('device')
						.attr('data-class', oDevice.class)
						.attr('data-id', oDevice.id)
						.attr('data-name', oDevice.name)
						.attr('data-rack-id', this._getObjectDatum('id'))
						.attr('data-position-v', oDevice.position_v);

					// Note: Url actually contains the hyperlink markup
					oDeviceElem
						.find('.mdv-d-name')
						.html(oDevice.url);

					oDeviceElem
						.css('height', 'calc(' + (oDevice.nb_u * 100) + '% + ' + (oDevice.nb_u - 1) + 'px)');

					oDeviceElem.appendTo( this._getRackSlotElement(oDevice.position_v, oDevice.position_p) );
				}
			},

			// Getters
			_getRackSlotElement: function(iSlotNumber, sPanelCode)
			{
				if(sPanelCode === undefined)
				{
					sPanelCode = this.options.defaults.panel;
				}

				var oSlotElem = this.element.find('.mdv-rack-panel[data-code="' + sPanelCode + '"] .mdv-rack-unit[data-unit-number="' + iSlotNumber + '"] .mdv-ru-slot');
				if(oSlotElem.length === 0)
				{
					this._trace('Could not find rack slot "' + iSlotNumber + 'U" for panel "' + sPanelCode + '".');
					return false;
				}

				return oSlotElem;
			},

			// Helpers
		}
	);
});
