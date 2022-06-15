<button onclick="history.back()">Back</button>

# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).

## [Unreleased]

## [1.11.0] - 2022-04-12
### Added
  * Add warning message in graphical view when no height defined for racks / enclosures

## [1.10.2] - 2022-04-06
### Changed
  * Update german translations thanks to @ChristianBeer
  * Remove forced activation fo the newsroom

## [1.10.1] - 2022-01-19
### Changed
  * Fix crash in "Graphical view" tab if opened during object creation

## [1.10.0] - 2022-01-02
### Added
  * Add support for Czech and Sweidh thanks to @xmstspider
  * Add counter on unmounted panels

### Changed
  * Fix minor visual glitches
  * Remove compatibility with iTop 2.5 and older

## [1.9.0] - 2021-10-20
### Changed
  * Add compatibility with iTop 3.0+
  * Update dependencies

## [1.8.0] - 2021-03-31
### Added
  * Add german translations thanks to viwedis GmbH!

## [1.7.0] - 2020-06-14
### Added
  * Add filter panel to highlight devices based on their name / serial number / asset number

## [1.6.0] - 2020-06-03
### Added
  * Add "Location Type" typology and basic hierarchy to the "Location" class

### Changed
  * Update dependencies to include their fixes
  * Rework the "Enclosure" presentation
  * Fix elements' plate overflow in some corner cases
  * Update translations

## [1.5.6] - 2020-05-08
### Changed
  * Update dependencies to include their fixes

## [1.5.5] - 2020-03-04
### Changed
  * Update dependencies to include their fixes

## [1.5.3] - 2020-01-13
### Changed
  * Fix regression: Enclosure's mounted devices displayed as unmounted
  * Update dependencies to include their fixes

## [1.5.1] - 2019-07-24
### Changed
  * Update dependencies to include their fixes

## [1.5.0] - 2019-07-22
### Added
  * Include "Molkobain's newsroom provider" module to keep administrators informed on new extensions and updates (can be disabled in the conf. file) (iTop 2.6+ only)

## [1.4.1] - 2019-07-02
### Changed
  * Show explicit help cursor on tooltips
  * Fix elements displaying under the slot when height greater than 1U

## [1.4.0] - 2019-06-24
### Added
  * Add support for PDU in racks and enclosures

### Changed
  * Improve rack proportions to be more realistic and fit a 42U in a Full HD screen
  * Fix UI glitches on small screens

## [1.3.1] - 2019-06-19
### Changed
  * Change compatibility to iTop 2.4+
  * Fix glitch in elements' tooltip header when name is too long
  * Fix minor UI glitches

## [1.3.0] - 2019-05-26
### Added
  * Complete dutch translations thanks to @jbostoen
  * Add collapse / expand toggler on unmounted element panels

### Changed
  * Fix default background color on devices
  * Fix legend sorted by class names
  * Fix HTML attributes in element's tooltip

## [1.2.0] - 2019-03-28
### Added
  * Move object's rack_units attribute with position attributes in both properties and list display
  * Improve UI when no element attached to rack/enclosure
  * Improve extensibility

## [1.1.1] - 2019-03-05
### Changed
  * Fix obsolete devices displayed even with option disabled #3

## [1.1.0] - 2019-02-03
### Added
  * Add option to toggle obsolete devices

### Changed
  * Fix devices positioned off host's limits

## [1.0.0] - 2019-01-07
### Added
  * Initial release

[Unreleased]: https://github.com/Molkobain/itop-datacenter-view/compare/v1.11.0...HEAD
[1.11.0]: https://github.com/Molkobain/itop-datacenter-view/releases/tag/v1.11.0
[1.10.2]: https://github.com/Molkobain/itop-datacenter-view/releases/tag/v1.10.2
[1.10.1]: https://github.com/Molkobain/itop-datacenter-view/releases/tag/v1.10.1
[1.10.0]: https://github.com/Molkobain/itop-datacenter-view/releases/tag/v1.10.0
[1.9.0]: https://github.com/Molkobain/itop-datacenter-view/releases/tag/v1.9.0
[1.8.0]: https://github.com/Molkobain/itop-datacenter-view/releases/tag/v1.8.0
[1.7.0]: https://github.com/Molkobain/itop-datacenter-view/releases/tag/v1.7.0
[1.6.0]: https://github.com/Molkobain/itop-datacenter-view/releases/tag/v1.6.0
[1.5.6]: https://github.com/Molkobain/itop-datacenter-view/releases/tag/v1.5.6
[1.5.5]: https://github.com/Molkobain/itop-datacenter-view/releases/tag/v1.5.5
[1.5.3]: https://github.com/Molkobain/itop-datacenter-view/releases/tag/v1.5.3
[1.5.1]: https://github.com/Molkobain/itop-datacenter-view/releases/tag/v1.5.1
[1.5.0]: https://github.com/Molkobain/itop-datacenter-view/releases/tag/v1.5.0
[1.4.1]: https://github.com/Molkobain/itop-datacenter-view/releases/tag/v1.4.1
[1.4.0]: https://github.com/Molkobain/itop-datacenter-view/releases/tag/v1.4.0
[1.3.1]: https://github.com/Molkobain/itop-datacenter-view/releases/tag/v1.3.1
[1.3.0]: https://github.com/Molkobain/itop-datacenter-view/releases/tag/v1.3.0
[1.2.0]: https://github.com/Molkobain/itop-datacenter-view/releases/tag/v1.2.0
[1.1.1]: https://github.com/Molkobain/itop-datacenter-view/releases/tag/v1.1.1
[1.1.0]: https://github.com/Molkobain/itop-datacenter-view/releases/tag/v1.1.0
[1.0.0]: https://github.com/Molkobain/itop-datacenter-view/releases/tag/v1.0.0