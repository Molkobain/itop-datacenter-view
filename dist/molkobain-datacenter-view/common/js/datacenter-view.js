/*
 * Copyright (c) 2015 - 2018 Molkobain.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

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
	$.widget('molkobain.datacenter_view',
		{
			options: {
				debug: false,
				object_type: 'rack',
				object_data: null,
				enums: {
					assembly: {
						mounted: 'mounted',
						unmounted: 'unmounted',
					},
				},
				dict: {},
			},

			// Constructor
			_create: function()
			{
				this._super();

				this.element.addClass('molkobain-datacenter-view');

				// Initiliazing widget
				this.initialize();
			},
			// Events bound via _bind are removed automatically
			// Revert other modifications here
			_destroy: function()
			{
				this.element.removeClass('molkobain-datacenter-view');

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
			initialize: function()
			{
				if(this.options.object_data === null)
				{
					this._trace('Could not initialize widget with no data.');
					return false;
				}

				this._initializeViews();
				this._initializeUnmounted();
				this._initializeElements();
				this._initializeTooltips();
			},
			// - Make the markup for views (eg. rack panels, enclosure panel, ...)
			_initializeViews: function()
			{
				// Meant for overloading.
			},
			// - Make the markup for unmounted elements to be displayed in
			_initializeUnmounted: function()
			{
				// Devices
				this._buildUnmountedContainer('device');
			},
			// - Make the markup for elements (mounted or not) and display them where they belong
			_initializeElements: function()
			{
				// Meant for overloading.
			},
			// - Instanciate tooltips on elements
			_initializeTooltips: function()
			{
				this.element.find('[data-toggle="tooltip"][title!=""]').each(function(){
					// Put tooltip
					var sContent = $('<div />').text($(this).attr('title')).html();
					$(this).qtip( { content: sContent, show: 'mouseover', hide: 'mouseout', style: { name: 'dark', tip: 'bottomMiddle' }, position: { corner: { target: 'topCenter', tooltip: 'bottomMiddle' }, adjust: { y: -15}} } );

					// Remove native title
					$(this).attr('title', '');
				});
			},

			// Getters
			// - Return a single datum from the object_data set
			_getObjectDatum: function(sCode)
			{
				if(this.options.object_data[sCode] === undefined)
				{
					this._trace('Could not find object datum for "' + sCode + '".');
					return false;
				}

				return this.options.object_data[sCode];
			},
			// - Return the dictionary entry identified by sCode if found, sCode otherwise
			_getDictEntry: function(sCode)
			{
				return (this.options.dict[sCode] !== undefined) ? this.options.dict[sCode] : sCode;
			},

			// Helpers
			// - Return a clone jQuery object from the template identified by .mdv-<sCode>
			_cloneTemplate: function(sCode)
			{
				var oElem = null;

				var oTemplate = this.element.find('.mdv-templates > .mdv-' + sCode);
				if(oTemplate.length === 0)
				{
					this._trace('Could not find template for "' + sCode + '".');
					return false;
				}
				else
				{
					oElem = oTemplate.clone();
				}

				return oElem;
			},
			// - Add markup for unmounted container for elements of type sType
			_buildUnmountedContainer: function(sType)
			{
				var sTypeForElementCategory = sType + 's';
				var sTypeForDictEntry = sType.charAt(0).toUpperCase() + sType.slice(1) + 's';

				var oContainer = this._cloneTemplate('unmounted-type')
                    .attr('data-type', sType)
                    .appendTo( this.element.find('.mdv-unmounted') );

				oContainer
					.find('.mdv-ut-icon')
					.html('<img src="' + this._getObjectDatum(sTypeForElementCategory).icon + '" />');

				oContainer
					.find('.mdv-ut-name')
					.attr('title', this._getDictEntry('Molkobain:DatacenterView:Unmounted:' + sTypeForDictEntry + ':Title+'))
					.attr('data-toggle', 'tooltip')
					.text(this._getDictEntry('Molkobain:DatacenterView:Unmounted:' + sTypeForDictEntry + ':Title'));
			},
			// Display trace in js console
			_trace: function(sMessage)
			{
				if(window.console && this.options.debug === true)
				{
					console.log('Molkobain datacenter view: ' + sMessage);
				}
			},
		}
	);
});
