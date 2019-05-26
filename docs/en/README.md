# IPSymconZidoo
[![Version](https://img.shields.io/badge/Symcon-PHPModul-red.svg)](https://www.symcon.de/service/dokumentation/entwicklerbereich/sdk-tools/sdk-php/)
[![Version](https://img.shields.io/badge/Symcon%20Version-5.0%20%3E-green.svg)](https://www.symcon.de/forum/threads/38222-IP-Symcon-5-0-verf%C3%BCgbar)


Module for IP-Symcon from version 5.x. Allows communication with a Zidoo Player

## Documentation

**Table of Contents**

1. [Features](#1-features)
2. [Requirements](#2-requirements)
3. [Installation](#3-installation)
4. [Function reference](#4-functionreference)
5. [Configuration](#5-configuration)
6. [Annex](#6-annex)

## 1. Features

The module can be used to send commands to a Zidoo player from IP-Symcon (version 5 or higher).


  

## 2. Requirements

 - IP-Symcon 5.x
 - Zidooplayer
 - the Master Branch is designed for the current IP-Symcon version.
 - For IP-Symcon versions smaller than 4.1 the branch _Old-Version_ has to be selected

## 3. Installation

### a. Loading the module

Open the IP Console's web console with _http:// <IP-Symcon IP> :3777/console/_.

Then click on the module store icon (IP-Symcon > 5.1) in the upper right corner.

![Store](img/store_icon.png?raw=true "open store")

In the search field type

```
Zidoo
```  


![Store](img/module_store_search_en.png?raw=true "module search")

Then select the module and click _Install_

![Store](img/install_en.png?raw=true "install")


#### Install alternative via Modules instance (IP-Symcon < 5.1)

Open the IP Console's web console with _http:// <IP-Symcon IP> :3777/console/_.

_Open_ the object tree .

![Objektbaum](img/object_tree.png?raw=true "Objektbaum")	

Open the instance _'Modules'_ below core instances in the object tree of IP-Symcon (>= Ver 5.x) with a double-click and press the _Plus_ button.

![Modules](img/modules.png?raw=true "Modules")	

![Plus](img/plus.png?raw=true "Plus")	

![ModulURL](img/add_module.png?raw=true "Add Module")
 
Enter the following URL in the field and confirm with _OK_:

```
https://github.com/Wolbolar/IPSymconZidoo
```  
	         
Then an entry for the module appears in the list of the instance _Modules_

By default, the branch _master_ is loaded, which contains current changes and adjustments.
Only the _master_ branch is kept current.

![Master](img/master.png?raw=true "master") 

If an older version of IP-Symcon smaller than version 5.1 is used, click on the gear on the right side of the list.
It opens another window,

![SelectBranch](img/select_branch_en.png?raw=true "select branch") 

here you can switch to another branch, for older versions smaller than 5.1 select _Old-Version_ .

### b. Configuration in IP-Symcon



## 4. Function reference

### Zidoo:




## 5. Configuration:

### Zidoo:

| Property    | Type    | Value        | Description                               |
| :---------: | :-----: | :----------: | :---------------------------------------: |
| Host        | string  |              | IP Adress Zidoo                           |




## 6. Annnex

###  a. Functions:

#### Zidoo:

`Zidoo_PowerOn(integer $InstanceID)`

Power On

`Zidoo_PowerOff(integer $InstanceID)`

Power off


###  b. GUIDs and data exchange:

#### Zidoo:

GUID: `{BE1A36C2-C8D5-02CA-5FF0-1EF0D8ACF5D7}` 