👋 [Available on Molkobain I/O](https://www.molkobain.com/product/datacenter-view/)

# iTop extension: molkobain-datacenter-view
* [Description](#description)
* [Advanced features](#advanced-features-in-the-paid-version-)
* [Online demo](#online-demo)
* [Compatibility](#compatibility)
* [Downloads](#downloads)
* [Installation](#installation)
* [Configuration](#configuration)
* [How to](#how-to)
* [Change log](CHANGELOG.md)

## Description
Easily manage & visualize your racks, enclosures and datacenter devices.
* See at a glace where your devices are.
* Check which attached devices have no position set.
* Toggle obsolete devices easily.
* Full support of english, french & dutch languages.

![Overview](docs/mdv-overview-01.png)

Access device's main information on hover (customizable)
![Overview - Tooltip](docs/mdv-overview-02.png)

Identify specific devices type by hovering the legend
![Overview - Legend](docs/mdv-overview-03.png)


### Advanced features in the paid version 🚀
* [Drag & Drop](#drag--drop)
* [Rear panel support](#rear-panel-support)
* [Consistency checks](#consistency-checks)
* [Audit rules](#audit-rules)
* [Reserved slots](#reserved-slots)
* [Custom classes](#custom-classes)
* [Zero-U devices](#zero-u-devices)
* [Misc. options](#misc-options)

👋 _Paid version is now available on [Molkobain I/O](https://www.molkobain.com/product/datacenter-view-extended/)!_

#### Drag & Drop
Drag & drop elements in the graphical view to easily set their position instead of manually editing each elements!
![Pro features - Rear panel](docs/mdv-profeatures-drag-01.png)

#### Rear panel support
* Available in both racks and enclosures
* Automatically shows occupancy on the opposite panel

![Pro features - Rear panel](docs/mdv-profeatures-panels-01.png)

#### Consistency checks
Optional consistency checks are made on elements during creation / update:
* Overlapping elements
* Malpositioned elements (outside rack's / enclosure's grid)
* Total elements' height exceeds rack's / enclosure's capacity

![Pro features - Consistency checks](docs/mdv-profeatures-consistency-01.png)

#### Audit rules
Comes with a bunch of audit rules to keep your datacenter vision clear:
* Production elements should have position set when attached to a rack or enclosure
* Positioned elements should be attached to a rack or enclosure
* Positioned elements should have *Rack units* attribute set
* Positioned elements should not overlap another one
* Positioned elements should not be outside its rack's or enclosure's (exceed height or malpositioned)

![Pro features - Audit rules](docs/mdv-profeatures-audit-01.png)

#### Reserved slots
Two new object classes to better describe your racks and enclosures:
* ReservedSlot: Reserve space in a rack / enclosure for any future usage or element.
* MiscEquipmentSlot: Mark space as used for patch panel or cable management for example.

![Pro features - Reserved slots](docs/mdv-profeatures-reservedslots-01.png)

#### Custom classes
You have some custom classes _(not derivating from DatacenterDevice)_ that you would like to use in racks and enclosures? No problem! Just register them in the `custom_device_classes` config. parameter, make sure they have the required attributes _(see documentation)_ and they will automatically appear. 👌

#### Zero-U devices
Manage devices with non standard size / positioning such as USB drives, vertical PDUs, non rackable devices, ... Just mark them as such to make them appaer in the bottom-right panel of their host, easy as pie!

![Pro features - Zero-U devices](docs/mdv-profeatures-zerou-01.png)

#### Misc. options
* Us order: Reverse Us order per rack / enclosure to fit your set-up
* Enclosure layout: Either display enclosure's elements or just the number of elements in it

## Online demo
You can try this extension on the online demo. There are already some racks, enclosures and devices mounted as an example. Just click on the links below to access it:
* [Administration console](http://mbc.itop.molkobain.com/pages/UI.php?operation=details&class=Rack&id=15&c[menu]=SearchCIs&auth_user=admin&auth_pwd=admin#tabbedContent_0=8) (admin / admin)

## Compatibility
Compatible with iTop 2.4+

## Dependencies
* Module `molkobain-handy-framework/1.2.3`
* Module `molkobain-console-tooltips/1.0.2`

*Note: All dependencies are included in the `dist/` folder, so all you need to do is follow the installation section below.*

## Downloads
Stable releases can be found either on the [releases page](https://github.com/Molkobain/itop-datacenter-view/releases) or on [Molkobain I/O](https://www.molkobain.com/product/datacenter-view/).

Downloading it directly from the *Clone or download* will get you the version under development which might be unstable.

## Installation
* Unzip the extension
* Copy the ``molkobain-datacenter-view`` folder under ``<PATH_TO_ITOP>/extensions`` folder of your iTop
* Run iTop setup & select extension *Datacenter view*

*Your folders should look like this*

![Extensions folder](docs/mdv-install.png)

## Configuration
No configuration needed, the extension can be used out of the box!

### Parameters
Some configuration parameters are available from the Configuration editor of the console:
* `enabled` Enable / disable the extension without having to uninstall it. Value can be `true` or `false`.
* `device_tooltip_attributes` Specify which attributes to display in the devices tooltip on hover. Must be an array of object classes pointing to an array of attributes (see example below).

*Default values:*
```
'enabled' => true,
'device_tooltip_attributes' => array(
    'DatacenterDevice' => array(
        'brand_id',
        'model_id',
        'serialnumber',
        'asset_number',
    ),
    'NetworkDevice' => array(
        'networkdevicetype_id',
        'brand_id',
        'model_id',
        'ram',
        'serialnumber',
        'asset_number',
    ),
    'Server' => array(
        'brand_id',
        'model_id',
        'osfamily_id',
        'cpu',
        'ram',
        'serialnumber',
        'asset_number',
    ),
),
```

## How to
### Free version (molkobain-datacenter-view)
#### Position a device on a rack
A quick example to show how to manually position a device on a rack.

In this example, the *Rack 2* has a *Server* attached but is listed among the *unmounted* devices. This is because the *server* has no *position* set.
![How to - Unmounted device](docs/mdv-howto-positionserver-01.png)

To fix this, edit the *server* and make sure it has both *position* and *rack units* (its height) set.
![How to - Edit device](docs/mdv-howto-positionserver-02.png)

Save the object and go back to the *rack*. The *server* will now appear in the *front* panel!
![How to - Result](docs/mdv-howto-positionserver-03.png)

#### Paid version (molkobain-datacenter-view-extended)
_Under construction_

## Contributors
I would like to give a special thank you to the people who contributed to this:
 - Bostoen, Jeffrey a.k.a @jbostoen
 - Makhlouf, Hadi
 - @danama

## Licensing
This extension is under [AGPLv3](https://en.wikipedia.org/wiki/GNU_Affero_General_Public_License).
