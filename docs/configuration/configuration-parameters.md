<button onclick="history.back()">Back</button>

# Configuration parameters

  * `enabled` Enable / disable the graphical part of the extension without having to uninstall it (datamodel changes will remain). Value can be `true` or `false`.
  * `device_tooltip_attributes` Specify which attributes to display in the device [tooltip](../features/graphical-tab-overview.md) on hover. Must be an array of object classes pointing to an array of attributes (see example below).

*Default values:*
```
'molkobain-datacenter-view' => array(
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
),
```
