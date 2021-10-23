<?php
/**
 * Copyright (c) 2015 - 2019 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\ConsoleTooltips\Console\Extension;

use DBObjectSet;
use iApplicationUIExtension;
use MetaModel;
use Molkobain\iTop\Extension\HandyFramework\Helper\ConfigHelper;
use utils;
use WebPage;

// Protection, only for iTop 2.7, tooltips are native starting iTop 3.0
if (ConfigHelper::IsRunningiTop30OrNewer() === false) {
	/**
	 * Class UIExtension
	 *
	 * @package Molkobain\iTop\Extension\ConsoleTooltips\Console\Extension
	 */
	class UIExtension implements iApplicationUIExtension
	{
		const DEFAULT_ENABLED = true;
		const DEFAULT_DECORATION_CLASS = 'mct-decoration-question';

		/**
		 * @inheritdoc
		 */
		public function OnDisplayProperties($oObject, WebPage $oPage, $bEditMode = false)
		{
			// Check if enabled
			if(MetaModel::GetConfig()->GetModuleSetting('molkobain-console-tooltips', 'enabled', static::DEFAULT_ENABLED) === false)
			{
				return;
			}

			// Get decoration class
			$sDecorationClass = MetaModel::GetConfig()->GetModuleSetting('molkobain-console-tooltips', 'decoration_class', static::DEFAULT_DECORATION_CLASS);

			// Add default decoration style
			$oPage->add_linked_stylesheet(utils::GetAbsoluteUrlModulesRoot().'molkobain-console-tooltips/web/css/default-theme.css');

			// Add decoration to labels
			$oPage->add_ready_script(
				<<<JS
    $('.ui-tabs-panel .label > span[title!=""]').each(function(){
        // Create decoration
        var oDecorationElem = $('<span></span>')
            .addClass('mct-decoration')
            .addClass('$sDecorationClass');
            
        // Attach to label
        oDecorationElem.appendTo($(this));
        
        // Create tooltip
        var sContent = $('<div />').text($(this).attr('title')).text()
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/(\\r\\n|\\n\\r|\\r|\\n)/g, '<br/>');
        oDecorationElem.qtip( { content: sContent, show: 'mouseover', hide: 'mouseout', style: { name: 'molkobain-dark', tip: 'bottomMiddle' }, position: { corner: { target: 'topMiddle', tooltip: 'bottomMiddle' }, adjust: { y: -15}} } );
        
        // Remove native title
        $(this).attr('title', '');
    });
JS
			);

			return;
		}

		/**
		 * @inheritdoc
		 */
		public function OnDisplayRelations($oObject, WebPage $oPage, $bEditMode = false)
		{
			// Do nothing
		}

		/**
		 * @inheritdoc
		 */
		public function OnFormSubmit($oObject, $sFormPrefix = '')
		{
			// Do nothing
		}

		/**
		 * @inheritdoc
		 */
		public function OnFormCancel($sTempId)
		{
			// Do nothing
		}

		/**
		 * @inheritdoc
		 */
		public function EnumUsedAttributes($oObject)
		{
			return array();
		}

		/**
		 * @inheritdoc
		 */
		public function GetIcon($oObject)
		{
			return '';
		}

		/**
		 * @inheritdoc
		 */
		public function GetHilightClass($oObject)
		{
			// Possible return values are:
			// HILIGHT_CLASS_CRITICAL, HILIGHT_CLASS_WARNING, HILIGHT_CLASS_OK, HILIGHT_CLASS_NONE
			return HILIGHT_CLASS_NONE;
		}

		/**
		 * @inheritdoc
		 */
		public function EnumAllowedActions(DBObjectSet $oSet)
		{
			// No action
			return array();
		}
	}
}

