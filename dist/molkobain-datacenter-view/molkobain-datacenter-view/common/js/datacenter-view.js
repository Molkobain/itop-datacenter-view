/*
 * Copyright (c) 2015 - 2019 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
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
				legend: {},
				dict: {},
				defaults: {
					tooltip_options: {
						show: 'mouseover',
						hide: 'mouseout',
						style: {
							name: 'molkobain-light-on-the-side',
							tip: {
								corner: 'rightMiddle',
							},
						},
						position: {
							corner: {
								target: 'leftMiddle',
								tooltip: 'rightMiddle',
							},
							adjust: {
								x: -38,
							},
						},
					},
				},
			},

			enums: {
				assembly_type: {
					mounted: 'mounted',
					unmounted: 'unmounted',
				},
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

				this._initializeLegend();
				this._initializeViews();
				this._initializeUnmounted();
				this._initializeElements();
				this._initializeTooltips();
			},
			// - Make the markup & events binding for the legend
			_initializeLegend: function()
			{
				var me = this;

				// Make markup
				for(var sClass in this.options.legend.classes)
				{
					var oClass = this.options.legend.classes[sClass];
					var oItemElem = this._cloneTemplate('legend-item')
						.attr('data-class', sClass)
						.attr('data-count', oClass.count)
						.text(oClass.title + ' (' + oClass.count + ')')
						.appendTo( this.element.find('.mdv-legend ul') );
				}

				// Bind highlight effect on hover
				this.element.find('.mdv-legend ul > li').hover(
					function(){
						var sObjClass = $(this).attr('data-class');
						me.element.find('.mdv-device[data-class!="' + sObjClass + '"]').addClass('mdv-fade-for-highlighting');
					},
					function(){
						var sObjClass = $(this).attr('data-class');
						me.element.find('.mdv-device').removeClass('mdv-fade-for-highlighting');
					}
				);
			},
			// - Make the markup & events binding  for views (eg. rack panels, enclosure panel, ...)
			_initializeViews: function()
			{
				// Meant for overloading.
			},
			// - Make the markup & events binding  for unmounted elements to be displayed in
			_initializeUnmounted: function()
			{
				// Devices
				this._buildUnmountedContainer('device');
			},
			// - Make the markup & events binding  for elements (mounted or not) and display them where they belong
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
					$(this).qtip( { content: sContent, show: 'mouseover', hide: 'mouseout', style: { name: 'molkobain-dark', tip: 'bottomMiddle' }, position: { corner: { target: 'topCenter', tooltip: 'bottomMiddle' }, adjust: { y: -15}} } );

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

				var oTemplate = this.element.find('.mhf-templates > .mdv-' + sCode);
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
					.find('.mhf-ph-icon')
					.html('<img src="' + this._getObjectDatum(sTypeForElementCategory).icon + '" />');

				oContainer
					.find('.mhf-ph-title')
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
