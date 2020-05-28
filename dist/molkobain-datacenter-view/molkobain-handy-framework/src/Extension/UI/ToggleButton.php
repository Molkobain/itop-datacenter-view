<?php
/**
 * Copyright (c) 2015 - 2019 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\HandyFramework\UI;

/**
 * Class ToggleButton
 *
 * @package Molkobain\iTop\Extension\HandyFramework\Helper\UI
 * @since 1.2.0
 */
class ToggleButton
{
	const DEFAULT_ON = false;
	const DEFAULT_ENABLED = true;

	/** @var int $iIdCounter */
	protected static $iIdCounter = 0;

	/** @var string $sInputName */
	protected $sInputName;
	/** @var string $sInputId */
	protected $sInputId;
	/** @var bool $bOn */
	protected $bOn;
	/** @var bool $bEnabled */
	protected $bEnabled;
	/** @var string $sOnLabel */
	protected $sOnLabel;
	/** @var string $sOffLabel */
	protected $sOffLabel;
	/** @var string $sJSOnChangeCallback */
	protected $sJSOnChangeCallback;

	/**
	 * ToggleButton constructor.
	 *
	 * @param string $sInputName
	 * @param bool $bOn
	 * @param string $sInputId
	 */
	public function __construct($sInputName, $bOn = self::DEFAULT_ON, $sInputId = null)
	{
		$this->sInputName = $sInputName;
		$this->bOn = (bool) $bOn;
		$this->bEnabled = static::DEFAULT_ENABLED;
		$this->sInputId = (empty($sInputId)) ? $this::GenerateInputID() : $sInputId;
	}


	//--------------------
	// Getters / Setters
	//--------------------

	/**
	 * @return string
	 */
	public function GetInputName()
	{
		return $this->sInputName;
	}

	/**
	 * @param string $sInputName
	 *
	 * @return ToggleButton
	 */
	public function SetInputName($sInputName)
	{
		$this->sInputName = $sInputName;
		return $this;
	}

	/**
	 * @return string
	 */
	public function GetInputId()
	{
		return $this->sInputId;
	}

	/**
	 * @param string $sInputId
	 *
	 * @return ToggleButton
	 */
	public function SetInputId($sInputId)
	{
		$this->sInputId = $sInputId;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function IsOn()
	{
		return $this->bOn;
	}

	/**
	 * @param bool $bOn
	 *
	 * @return ToggleButton
	 */
	public function SetOn($bOn)
	{
		$this->bOn = (bool) $bOn;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function IsEnabled()
	{
		return $this->bEnabled;
	}

	/**
	 * @param bool $bEnabled
	 *
	 * @return ToggleButton
	 */
	public function SetEnabled($bEnabled)
	{
		$this->bEnabled = (bool) $bEnabled;
		return $this;
	}

	/**
	 * @return string
	 */
	public function GetOnLabel()
	{
		return $this->sOnLabel;
	}

	/**
	 * @param string $sOnLabel
	 *
	 * @return ToggleButton
	 */
	public function SetOnLabel($sOnLabel)
	{
		$this->sOnLabel = $sOnLabel;
		return $this;
	}

	/**
	 * @return string
	 */
	public function GetOffLabel()
	{
		return $this->sOffLabel;
	}

	/**
	 * @param string $sOffLabel
	 *
	 * @return ToggleButton
	 */
	public function SetOffLabel($sOffLabel)
	{
		$this->sOffLabel = $sOffLabel;
		return $this;
	}

	/**
	 * @return string
	 */
	public function GetJSOnChangeCallback()
	{
		return $this->sJSOnChangeCallback;
	}

	/**
	 * @param string $sJSOnChangeCallback
	 *
	 * @return ToggleButton
	 */
	public function SetJSOnChangeCallback($sJSOnChangeCallback)
	{
		$this->sJSOnChangeCallback = $sJSOnChangeCallback;
		return $this;
	}


	//----------
	// Helpers
	//----------

	/**
	 * Returns the HTML markup for the button
	 *
	 * @return string
	 */
	public function Render()
	{
		// Prepare parameters
		// - Is already ON
		$sInputChecked = ($this->bOn) ? 'checked' : '';
		// - Is enabled
		$sInputDisabled = ($this->bEnabled) ? '' : 'disabled';
		// - Optional labels, depend on the theme
		$sOffTagAtt = (!empty($this->sOffLabel)) ? 'data-off-label="' . $this->sOffLabel . '"' : '';
		$sOnTagAtt = (!empty($this->sOnLabel)) ? 'data-on-label="' . $this->sOnLabel . '"' : '';
		// - Optional JS callback
		// Note: escaping html chars to avoid breaking the quotes around the attribute's value
		$sOnChangeAtt = (!empty($this->sJSOnChangeCallback)) ? 'onchange="javascript: ' . htmlspecialchars($this->sJSOnChangeCallback) . '"' : '';

		$sHtml =
			<<<HTML
<span class="mhf-toggle-button mhf-tb-flat">
	<input class="mhf-tb-input" id="{$this->sInputId}" name="{$this->sInputName}" type="checkbox" {$sOnChangeAtt} {$sInputChecked} {$sInputDisabled} />
	<label class="mhf-tb-button" {$sOffTagAtt} {$sOnTagAtt} for="{$this->sInputId}">
</span>
HTML;

		return $sHtml;
	}

	/**
	 * Generates a unique ID for a button
	 *
	 * @return string
	 */
	protected static function GenerateInputID()
	{
		return 'mhf-tb-' . time() . '-' . static::GetNextId();
	}

	/**
	 * Returns the next ID for this kind of button
	 *
	 * @return int
	 */
	protected static function GetNextId()
	{
		return ++static::$iIdCounter;
	}
}