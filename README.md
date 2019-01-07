# iTop extension: molkobain-datacenter-view

### Description
Easily manage & visualize your racks, enclosures and datacenter devices.
* See at a glace where your devices are.
* Check which attached devices have no position set.

![Overview](https://raw.githubusercontent.com/Molkobain/itop-datacenter-view/develop/docs/mdv-overview-01.png)

Access device's main information on hover (customizable)
![Overview - Tooltip](https://raw.githubusercontent.com/Molkobain/itop-datacenter-view/develop/docs/mdv-overview-02.png)

Identify specific devices type by hovering the legend
![Overview - Legend](https://raw.githubusercontent.com/Molkobain/itop-datacenter-view/develop/docs/mdv-overview-03.png)

#### Advanced features in the paid version 🚀
* Drag & drop elements in the graphical view to easily set their position instead of manually editing each elements!
![Pro features - Rear panel](https://raw.githubusercontent.com/Molkobain/itop-datacenter-view/develop/docs/mdv-profeatures-drag-01.png)
* Rear panel support for racks
![Pro features - Rear panel](https://raw.githubusercontent.com/Molkobain/itop-datacenter-view/develop/docs/mdv-profeatures-panels-01.png)
* Consistency checks (optionals) on elements creation / update:
  * Overlapping elements
  * Malpositioned elements (outside rack's / enclosure's grid)
  * Total elements' height exceeds rack's / enclosure's capacity
![Pro features - Consistency checks](https://raw.githubusercontent.com/Molkobain/itop-datacenter-view/develop/docs/mdv-profeatures-consistency-01.png)
* Audit rules:
  * Production elements should have position set when attached to a rack or enclosure
  * Positioned elements should be attached to a rack or enclosure
  * Positioned elements should have *Rack units* attribute set
  * Positioned elements should not overlap another one
  * Positioned elements should not be outside its rack's or enclosure's (exceed height or malpositioned)

### Compatibility
Compatible with iTop 2.3+

### Dependencies
* Module `molkobain-handy-framework/1.0.0`
* Module `molkobain-console-tooltips/1.0.2`

*Note: All dependencies are included in the `dist/` folder, so all you need to do is follow the installation section below.*

### Installation
* Unzip the extension
* Copy the ``dist/molkobain-datacenter-view`` folder under ``<PATH_TO_ITOP>/extensions`` folder of your iTop
* Run iTop setup & select extension *Datacenter view*

*Your folders should look like this*

![Extensions folder](https://raw.githubusercontent.com/Molkobain/itop-datacenter-view/develop/docs/mdv-install.png)

### Configuration
No configuration needed.

#### Parameters
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

### How to
#### Position a device on a rack
A quick example to show how to manually position a device on a rack.

In this example, the *Rack 2* has a *Server* attached but is listed among the *unmounted* devices. This is because the *server* has no *position* set.
![How to - Unmounted device](https://raw.githubusercontent.com/Molkobain/itop-datacenter-view/develop/docs/mdv-howto-positionserver-01.png)

To fix this, edit the *server* and make sure it has both *position* and *rack units* (its height) set.
![How to - Edit device](https://raw.githubusercontent.com/Molkobain/itop-datacenter-view/develop/docs/mdv-howto-positionserver-02.png)

Save the object and go back to the *rack*. The *server* will now appear in the *front* panel!
![How to - Result](https://raw.githubusercontent.com/Molkobain/itop-datacenter-view/develop/docs/mdv-howto-positionserver-03.png)

### Licensing
This extension is under [MIT license](https://en.wikipedia.org/wiki/MIT_License).
