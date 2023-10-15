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
	$.widget('molkobain.datacenter_view',
		{
			options: {
				debug: false,
				object_type: 'rack',
				object_data: null,
				endpoint: null,
				legend: {},
				dict: {},
				use_legacy_tooltips: false,
				defaults: {
					rack_unit_slot_height: 18,
					panel_code: 'front',
					units_order: 'regular',
					// Only for legacy tooltips
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
								x: -35,
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
				element_type: {
					device: 'device',
					enclosure: 'enclosure',
				},
				units_order: {
					reverse: 'reverse',
					regular: 'regular',
				}
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

				if(this.options.endpoint === null)
				{
					this._trace('Could not initialize widget with no endpoint.');
					return false;
				}

				this._bindEvents();

				this._initializeLegend();
				this._initializeFilter();
				this._initializeViews();
				this._initializeUnmountedPanels();
				this._initializeElements();
				this._initializeTooltips();
				this._updateUnmountedPanels();
			},
			// - Bind external events
			_bindEvents: function()
			{
				var me = this;

				// Refresh view
				this.element.bind('mdv.refresh_view', function(){
					return me._onRefreshView();
				});
				// Save options
				this.element.bind('mdv.save_options', function(){
					return me._onSaveOptions();
				});
				// Update unmounted panels
				// - A specific one
				this.element.bind('mdv.update_unmouted_panel', function(oEvent, oData){
					return me._onUpdateUnmountedPanel(oData);
				});
				// - All
				this.element.bind('mdv.update_unmouted_panels', function(){
					return me._onUpdateAllUnmountedPanels();
				});
				// Update device size
				this.element.bind('mdv.update_device_size', function(oEvent, oData){
					me._updateDeviceWidth(oData.device_elem, oData.host_elem, false);
					me._updateDeviceHeight(oData.device_elem);
				});
			},
			// - Make the markup & events binding for the legend
			_initializeLegend: function()
			{
				var me = this;

				// Return if no legend items
				if(this.options.legend.classes.length === 0)
				{
					return true;
				}

				// Make markup
				this.element.find('.mdv-legend .mhf-p-body')
				    .append( $('<ul></ul>') );

				for(var sClass in this.options.legend.classes)
				{
					var oClass = this.options.legend.classes[sClass];
					/* var oItemElem */
					this._cloneTemplate('legend-item')
						.attr('data-class', sClass)
						.attr('data-count', oClass.count)
						.find('.mdv-li-title')
						.text(oClass.title)
						.end()
						.find('.mdv-li-count')
						.text(oClass.count)
						.end()
						.appendTo( this.element.find('.mdv-legend ul') );
				}

				// Bind highlight effect on hover
				this.element.find('.mdv-legend ul > li').hover(
					function(){
						var sObjClass = $(this).attr('data-class');
						me.element.find('.mdv-device[data-class!="' + sObjClass + '"]').addClass('mdv-fade-for-highlighting');
					},
					function(){
						me.element.find('.mdv-device').removeClass('mdv-fade-for-highlighting');
					}
				);
			},
			// - Add listeners to the filter
			_initializeFilter: function()
			{
				var me = this;
				this.element.find('.mdv-filter')
				.find('.mdv-filter-clear-icon').on('click', function(){ me._onFilterClearIconClick($(this)); })
				.end()
				.find('.mdv-filter-input').on('keyup change', function(){ me._onFilterValueChanged($(this)); })
				.end();
			},
			// - Make the markup & events binding for views (eg. rack panels, enclosure panel, ...)
			_initializeViews: function()
			{
				// Meant for overloading.
			},
			// - Make the markup & events binding for unmounted elements to be displayed in
			_initializeUnmountedPanels: function()
			{
				// Devices
				this._buildUnmountedPanelContainer('device');
			},
			// - Make the markup & events binding for elements (mounted or not) and display them where they belong
			_initializeElements: function()
			{
				// Meant for overloading.
			},
			_initializeEnclosure: function(oEnclosure)
			{
				if(oEnclosure.panel_code === undefined)
				{
					oEnclosure.panel_code = this.options.defaults.panel_code; // Always front panel by default. Rear panel would be displayed only in Enclosure view.
				}
				if(oEnclosure.units_order === undefined)
				{
					oEnclosure.units_order = this.options.defaults.units_order;
				}

				var oEnclosureElem = this._cloneTemplate('enclosure', oEnclosure);

				// Build slots
				var iTopIdx = (oEnclosure.units_order === this.enums.units_order.regular) ? oEnclosure.nb_u : 1 * -1;
				var iBottomIdx = (oEnclosure.units_order === this.enums.units_order.regular) ? 1 : oEnclosure.nb_u * -1;
				for(var iVIdx = iTopIdx; iVIdx >= iBottomIdx; iVIdx--)
				{
					var iUnitIdx = Math.abs(iVIdx);
					var oEnclosureUnitElem = this._cloneTemplate('enclosure-unit')
						.attr('data-unit-number', iUnitIdx)
						.find('.mdv-eu-left')
						.text(iUnitIdx + 'U')
						.end();

					var oEnclosureUnitInitialSlot = oEnclosureUnitElem.find('.mdv-eu-slot')
						.attr('data-column-number', 1);
					for(var iHIdx = 2; iHIdx <= oEnclosure.nb_cols; iHIdx++)
					{
						oEnclosureUnitInitialSlot.clone()
							.attr('data-column-number', iHIdx)
							.insertBefore(oEnclosureUnitElem.find('.mdv-eu-right'));
					}

					oEnclosureUnitElem.appendTo(oEnclosureElem.children('.mdv-host-units-wrapper'));
				}

				// Full height of n Us plus the bottom-border of n-1 Us
				oEnclosureElem
					.css('height', 'calc(' + (oEnclosure.nb_u * this.options.defaults.rack_unit_slot_height) + 'px + ' + (oEnclosure.nb_u - 1) + 'px)');

				return oEnclosureElem;
			},
			// - Host's devices
			_initializeDevices: function()
			{
				for(var sAssemblyType in this.enums.assembly_type)
				{
					for(var iDeviceIdx in this._getObjectDatum('devices')[sAssemblyType])
					{
						var oDevice = this._getObjectDatum('devices')[sAssemblyType][iDeviceIdx];
						this._initializeDevice(oDevice);
					}
				}
			},
			// - Device. Overload for specific host search
			_initializeDevice: function(oDevice, oHostElem)
			{
				if((oHostElem === undefined) || (oHostElem === null))
				{
					oHostElem = this.element.find('.mdv-unmounted-type[data-type="' + this.enum.element_type.device + '"] .mdv-ut-body');
				}

				var oDeviceElem = this._cloneTemplate('device', oDevice);

				// Note: Url actually contains the hyperlink markup
				oDeviceElem
					.find('.mdv-d-name')
					.html(oDevice.url);

				// Dynamic height to occupy desired Us
				this._updateDeviceHeight(oDeviceElem);

				// Tooltip
				var bIsDeviceInUnmountedPanel = oHostElem.closest('.mdv-unmounted-type').length > 0;
				if (oDevice.tooltip !== undefined) {
					if (this.options.use_legacy_tooltips) {
						// Note: We need to do a deep copy
						var oQTipOptions = $.extend(
							true,
							{},
							this.options.defaults.tooltip_options,
							{ content: oDevice.tooltip.content }
						);
						// Note: We don't use the .closest() yet for performance reasons. If this goes recurse, we might want to consider it though.
						if (bIsDeviceInUnmountedPanel) {
							oQTipOptions.position.adjust.x = -16;
						}
						oDeviceElem.qtip(oQTipOptions);
					} else {
						oDeviceElem.attr('data-tooltip-html-enabled', true)
						.attr('data-tooltip-placement', 'left')
						.attr('data-tooltip-distance-offset', bIsDeviceInUnmountedPanel ? '24' : '42')
						.attr('data-tooltip-theme', 'molkobain-light mdv-element-tooltip')
						.attr('data-tooltip-content', oDevice.tooltip.content);
					}
				}

				oDeviceElem.appendTo(oHostElem);

				// Dynamic width to occupy desired cols
				// Note: We do this after the element is append, otherwise we can access the device's dimensions through JS
				this._updateDeviceWidth(oDeviceElem, oHostElem);

				return oDeviceElem;
			},
			// - Instanciate tooltips on elements
			_initializeTooltips: function()
			{
				var me = this;

				// Set a timeout a give extensibility a chance to put tooltip as well (not the best way of doing it I know)
				setTimeout(
					function(){
						me.element.find('[data-toggle="tooltip"][title!=""]').each(function(){
							// Put tooltip
							var sContentRaw = $(this).attr('title');
							if (me.options.use_legacy_tooltips) {
								var sContent = $('<div />').text(sContentRaw).html();
								$(this).qtip( { content: sContent, show: 'mouseover', hide: 'mouseout', style: { name: 'molkobain-dark', tip: 'bottomMiddle' }, position: { corner: { target: 'topMiddle', tooltip: 'bottomMiddle' }, adjust: { y: -5}} } );
							} else {
								$(this).attr('data-tooltip-placement', 'top');
								$(this).attr('data-tooltip-content', sContentRaw);
							}

							// Remove native title
							$(this).attr('title', '');
						});
					},
					300
				);

			},
			// - Update unmounted panels after they have been initialized and filled with elements
			_updateUnmountedPanels: function()
			{
				this._onUpdateAllUnmountedPanels();
			},

			// Event handlers
			// - Refresh view from server with current options
			_onRefreshView: function()
			{
				var me = this;

				this._showLoader();
				$.post(
					this.options.endpoint,
					this.element.find('.mdv-options-form').serialize(),
					'html'
				)
					.done(function(sResponse){
						me.element.parent().html(sResponse);
					})
					.fail(function(){
						// TODO: Show generic error message
					})
					.always(function(){
						me._hideLoader();
					});

			},
			// - Save current options without refreshing the view
			_onSaveOptions: function()
			{
				$.post(
					this.options.endpoint,
					this.element.find('.mdv-options-form').serialize(),
					'html'
				);
			},
			// - Called when all unmounted panels are updated (element added / removed)
			_onUpdateAllUnmountedPanels: function()
			{
				var me = this;
				this.element.find('.mdv-unmounted-type').each(function(){
					me._onUpdateUnmountedPanel($(this).attr('data-type'));
				});
			},
			// - Called when an unmounted panel is updated (element added / removed)
			_onUpdateUnmountedPanel: function(sPanelType)
			{
				var oPanelElem = this.element.find('.mdv-unmounted-type[data-type="' + sPanelType + '"]');

				// Update element count
				var oSpotElem = oPanelElem.find('.mdv-uth-spot');
				var iElementCount = oPanelElem.find('.mdv-ut-body > .mdv-element:visible').length;

				oSpotElem.text(iElementCount);
				if(iElementCount === 0)
				{
					oSpotElem.addClass('mdv-hidden');
				}
				else
				{
					oSpotElem.removeClass('mdv-hidden');
				}
			},
			// - Called when user clicks on the clear icon of the filter
			_onFilterClearIconClick: function()
			{
				this.element.find('.mdv-filter .mdv-filter-input').val('').trigger('change');
			},
			// - Called when filter changed due to user or event
			_onFilterValueChanged: function()
			{
				var aCheckedAttributes = ['data-name', 'data-serial-number', 'data-asset-number'];
				var sFilterText = this._getFilterValue().toLowerCase().latinise();

				if(sFilterText === '')
				{
					this.element.find('.mdv-device').removeClass('mdv-fade-for-highlighting');
					this.element.find('.mdv-filter .mdv-filter-clear-icon').hide();
				}
				else
				{
					this.element.find('.mdv-filter .mdv-filter-clear-icon').show();
					this.element.find('.mdv-device').each(function(){
						var bMatching = false;

						for(var iIdx in aCheckedAttributes)
						{
							var sValue = $(this).attr(aCheckedAttributes[iIdx]);
							if(typeof sValue === 'undefined')
							{
								continue;
							}

							if(sValue.toLowerCase().latinise().indexOf(sFilterText) >= 0)
							{
								bMatching = true;
								break;
							}
						}

						if(bMatching)
						{
							$(this).removeClass('mdv-fade-for-highlighting');
						}
						else
						{
							$(this).addClass('mdv-fade-for-highlighting');
						}
					});
				}
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
			// - Return the jQuery object for the iSlotNumber slot of the iEnclosureId enclosure if found, null otherwise
			_getEnclosureSlotElement: function(iUnitNumber, iColumnNumber, sPanelCode, iEnclosureId)
			{
				if(sPanelCode === undefined)
				{
					sPanelCode = this.options.defaults.panel_code;
				}

				var oSlotElem = this.element.find('.mdv-enclosure[data-id="' + iEnclosureId + '"][data-panel-code="' + sPanelCode + '"] .mdv-enclosure-unit[data-unit-number="' + iUnitNumber + '"] .mdv-eu-slot[data-column-number="' + iColumnNumber + '"]');
				if(oSlotElem.length === 0)
				{
					this._trace('Could not find enclosure slot "' + iUnitNumber + 'U / Col ' + iColumnNumber + '" for "' + iEnclosureId + '".');
					return null;
				}

				return oSlotElem;
			},
			// - Get raw filter value from input (not lowercased nor latinized)
			_getFilterValue: function()
			{
				return this.element.find('.mdv-filter .mdv-filter-input').val();
			},

			// Helpers
			// - Return a clone jQuery object from the template identified by .mdv-<sCode>
			_cloneTemplate: function(sCode, oData)
			{
				// Default values
				if(oData === undefined)
				{
					oData = {};
				}

				var oTemplate = this.element.find('> .mhf-templates > .mdv-' + sCode);
				if(oTemplate.length === 0)
				{
					this._trace('Could not find template for "' + sCode + '".');
					return false;
				}
				var oElem = oTemplate.clone();

				// Set data
				for(var sProperty in oData)
				{
					var value = oData[sProperty];
					if((typeof value === 'string') || (typeof value === 'number') || (typeof value === 'boolean'))
					{
						oElem.attr('data-'+sProperty.replace('_', '-'), value);
					}
				}

				return oElem;
			},
			// - Add markup for unmounted container for elements of type sType
			_buildUnmountedPanelContainer: function(sType)
			{
				var sTypeForElementCategory = sType + 's';
				var sTypeForDictEntry = sType.charAt(0).toUpperCase() + sType.slice(1) + 's';

				var oContainer = this._cloneTemplate('unmounted-type')
                    .attr('data-type', sType)
                    .appendTo( this.element.find('.mdv-unmounted') );

				oContainer
					.find('.mhf-ph-icon')
					.prepend('<img src="' + this._getObjectDatum(sTypeForElementCategory).icon + '" alt="' + sTypeForDictEntry + '" />');

				oContainer
					.find('.mhf-ph-title')
					.attr('title', this._getDictEntry('Molkobain:DatacenterView:Unmounted:' + sTypeForDictEntry + ':Title+'))
					.attr('data-toggle', 'tooltip')
					.text(this._getDictEntry('Molkobain:DatacenterView:Unmounted:' + sTypeForDictEntry + ':Title'));
			},
			// - Update device width regarding its host
			_updateDeviceWidth: function(oDeviceElem, oHostElem, bStoreOriginalWidth)
			{
				// Default values
				if(bStoreOriginalWidth === undefined)
				{
					bStoreOriginalWidth = true;
				}

				if(oHostElem.hasClass('mdv-hu-slot'))
				{
					var iHostColWidth = oHostElem.outerWidth(); // Don't round width otherwise the computed width will be too short
					var iHostNbCols = parseInt(oHostElem.closest('.mdv-host-panel').attr('data-nb-cols'));
					var iDeviceNbCols = parseInt(oDeviceElem.attr('data-nb-cols'));

					// Correct device nb cols in case it is in an host with less columns
					if(iDeviceNbCols > iHostNbCols)
					{
						iDeviceNbCols = iHostNbCols
					}
					oDeviceElem.css('width', 'calc(' + iHostColWidth + 'px * ' + iDeviceNbCols + ' - 1px)');
				}

				if(bStoreOriginalWidth)
				{
					oDeviceElem.attr('data-original-width', oDeviceElem.css('width'));
				}
			},
			// - Update device height regarding its metadata
			_updateDeviceHeight: function(oDeviceElem)
			{
				oDeviceElem.css('height', 'calc(' + (oDeviceElem.attr('data-nb-u') * this.options.defaults.rack_unit_slot_height) + 'px + ' + (oDeviceElem.attr('data-nb-u') - 1) + 'px)');
			},
			_showLoader: function()
			{
				this.element.find('.mhf-loader').removeClass('mhf-hide');
			},
			_hideLoader: function()
			{
				this.element.find('.mhf-loader').addClass('mhf-hide');
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
