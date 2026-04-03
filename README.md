# Idolon 

an image Server module for Emvicy2 (2.x) PHP Framework: https://github.com/emvicy/Emvicy/tree/2.x   
Image Variation Requests become very easy.

🛈 This module makes use of https://github.com/gueff/idolon .
For any Requirements see the Readme there.

## Overview

- [Installation](#Installation)
- [Usage](#Usage)


------------------------------------------------------------------------------------------------------------------------

## Installation <a id="Installation"></a>

_cd into the modules folder of your `Emvicy` copy; e.g.:_  
~~~bash
cd /var/www/html/modules/;
~~~

_clone `Idolon`_  
~~~bash
git clone --branch 1.x https://github.com/emvicy/Idolon.git Idolon;
~~~

------------------------------------------------------------------------------------------------------------------------

## Usage <a id="Usage"></a>

### 1. create a config file

create a new file by copying the example file to your primary config (say it is module `Foo`)

copy `etc/config/Idolon/config/_idolon.example` => to => `etc/config/Foo/config/_idolon.php`

_then require the file `_idolon.php` into your Environment config file, e.g. `develop.php`_  
~~~php
require_once realpath(__DIR__) . '/_idolon.php';
~~~

modify the config to your needs.

_config file `_idolon.php`_  
~~~php
<?php

// float numbers need to be presented C-style
setlocale(LC_NUMERIC, 'C');

#-----------------------------------------------------------------------------------------------------------------------
# general settings

$aConfig['MODULE']['Idolon'] = array();

// cache dir
$sIDOLON_CACHE_PATH = $aConfig['MVC_CACHE_DIR'] . '/Idolon/';

// how many variations of an image should be stored for maximum
$iIDOLON_MAX_CACHE_FILES_FOR_IMAGE = 10;

// if activated, an image cannot resize to higher values than its dimensions, but only to lower ones
// true: prevents resizing to higher x or y values than original has
$bIDOLON_PREVENT_OVERSIZING = true;

#-----------------------------------------------------------------------------------------------------------------------
# token

// Token "@image"
// This is the string directly located after domain which indicates an image request
// e.g. /@image/screenshot/png/200/100/1/
// Here in this example, "@image" ist the token
// Idolon will automatically listen for (/@image/) then.
$aConfig['MODULE']['Idolon']['@image'] = array(
    'IDOLON_IMAGE_PATH' => $aConfig['MVC_BASE_PATH'] . '/public/images/default/',

    // copy general settings
    'IDOLON_CACHE_PATH' => $sIDOLON_CACHE_PATH,
    'IDOLON_MAX_CACHE_FILES_FOR_IMAGE' => $iIDOLON_MAX_CACHE_FILES_FOR_IMAGE,
    'IDOLON_PREVENT_OVERSIZING' => $bIDOLON_PREVENT_OVERSIZING,
);
~~~

------------------------------------------------------------------------------------------------------------------------

## 2. activate Idolon via Event Listener

create a new file by copying the example file to your primary event (say it is module `Foo`)

copy `etc/config/Idolon/event/idolon.example` => to => `etc/config/Foo/event/idolon.php`

_event file `idolon.php`_  
~~~php 
<?php

#-------------------------------------------------------------
# declare bindings

$aEvent = [
    'mvc.controller.init.before' => array(

        // Start Idolon
        function() {
            new \Idolon\Controller\Index(
                \MVC\Request::in(),
                \MVC\Route::getCurrent()
            );
        }
    ),
];

#-------------------------------------------------------------
# process: bind the declared ones

\MVC\Event::processBindConfigStack($aEvent);
~~~

------------------------------------------------------------------------------------------------------------------------

## Example

Due to the Config, this will serve the Image `screenshot.png` from the public folder `/images/` with 750x352 px:

~~~html
<!-- request image with original width + height -->
<img src="/@image/screenshot/png/">

<!-- request image with width of 750px; height will be calculated -->
<img src="/@image/screenshot/png/750/">

<!-- request image with width of 750px and height of 352px; redirect with proper dimension request if necessary -->
<img src="/@image/screenshot/png/750/300/1/">
~~~

**Explanation**

- The Request `/@image/screenshot/png/750/352/1/`is made.
- The Event Listener (`\MVC\Event::BIND('mvc.controller.before', function(){..}`) checks the current Request.
- If the first string after the domain is `@image` this means an image request has been detected.
- So in this Example, the Request `/@image/screenshot/png/750/352/1/` will be handled by Idolon Module.


