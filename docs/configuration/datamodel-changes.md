<button onclick="history.back()">Back</button>

# Datamodel changes

The extension alters the standard datamodel, below is a summary of these modifications to help you integrate it with your own extensions.

## Modified classes
### Location
#### Fields

| Code            | Change type           | Description                            |
|-----------------|-----------------------|----------------------------------------|
| locationtype_id | Added (force)         | External key to `LocationType`         |
| parent_id       | Added (if not exists) | Hierarchical key to self (`Location`)  |
| locations_list  | Added (if not exists) | Linked set to child `Location` objects |

### Rack
#### Fields

| Code | Change type         | Description         |
|------|---------------------|---------------------|
| nb_u | Replaced (redefine) | Height in units (U) |

### Enclosure
#### Fields

| Code       | Change type         | Description                                                                               |
|------------|---------------------|-------------------------------------------------------------------------------------------|
| nb_u       | Replaced (redefine) | Height in units (U)                                                                       |
| position_v | Added (define)      | Vertical position (U) of the enclosure in the rack (Must be the bottom position, not top) |

#### Presentation
The `details` zlist is completely redefined to propose a nice presentation.

### DatacenterDevice
#### Fields

| Code       | Change type         | Description                                                                                                                       |
|------------|---------------------|-----------------------------------------------------------------------------------------------------------------------------------|
| nb_u       | Replaced (redefine) | Height in units (U)                                                                                                               |
| position_v | Added (define)      | Vertical position (U) of the device in the enclosure (or rack if mounted directly on int). (Must be the bottom position, not top) |

#### Presentation
The `details` zlist is completely redefined to propose a nice presentation.

### PDU
#### Fields

| Code         | Change type    | Description                                                                                                                       |
|--------------|----------------|-----------------------------------------------------------------------------------------------------------------------------------|
| enclosure_id | Added (define) | `Enclosure` to which the `PDU` is attached to                                                                                     |
| nb_u         | Added (define) | Height in units (U)                                                                                                               |
| position_v   | Added (define) | Vertical position (U) of the device in the enclosure (or rack if mounted directly on int). (Must be the bottom position, not top) |

#### Presentation
The `details` zlist is completely redefined to propose a nice presentation.

## New classes
### LocationType

* Description: New typology to define the type of a `Location`, typically a room, a floor, a building, ...
* Parent: `Typology`

#### Fields

| Code           | Label     | Type               | Description                        |
|----------------|-----------|--------------------|------------------------------------|
| locations_list | Locations | AttributeLinkedSet | List of all locations of this type |

## Menus
### New menus

  * `Typology` menu: A badge dashlet is added in the first cell with ID `LocationType`. 