# Idolon 

an image Server module for Emvicy2 (2.x) PHP Framework: https://github.com/emvicy/Emvicy/tree/2.x   
Image Variation Requests become very easy.

🛈 This module makes use of https://github.com/gueff/idolon .
For any Requirements see the Readme there.

## Overview

- [Installation](#Installation)
- [Usage](#Usage)
- [Examples](#Examples)


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

create a route which points to `\Idolon\Controller\Idolon::serve`

_route_  
~~~php
\MVC\Route::get(
    # will provide e.g. <img src="/idolon/emvicy/png/150/150/0/">
    sPath: '/idolon/*',
    sClassMethod: '\Idolon\Controller\Idolon::serve',
    sTag: 'idolon',
    mOptional: [

        // folder to look after existing images for this route
        'IDOLON_IMAGE_PATH' => $GLOBALS['aConfig']['MVC_BASE_PATH'] . '/public/',

        // cache folder for those images
        'IDOLON_CACHE_PATH' => $GLOBALS['aConfig']['MVC_CACHE_DIR'] . '/idolon/',

        // how much cached versions of an image
        'IDOLON_MAX_CACHE_FILES_FOR_IMAGE' => 20,

        // prevent creating bigger images than original
        'IDOLON_PREVENT_OVERSIZING' => true,
    ]
);
~~~
- you also find an example file in `Idolon/etc/routing/idolon.example`
- modify the route to your needs

------------------------------------------------------------------------------------------------------------------------

## Examples <a id="Examples"></a>

Due to the config given by route (additional), this will serve the Image `emvicy.png` from the public folder `/public/` in different variations:

~~~html
            <!-- request image with original width + height; auto-redirects with proper dimension ratio request if necessary -->
<img src="/idolon/emvicy/png/">

<!-- request image with width of 150px; height will be calculated; auto-redirects with proper dimension ratio request if necessary -->
<img src="/idolon/emvicy/png/150/">

<!-- request image with width of 150px and height of 172px; redirects with proper dimension ratio request if necessary -->
<img src="/idolon/emvicy/png/150/172/1/">

<!-- request image with width of 150px and height of 150px; NO redirect - serves it as it is requested -->
<img src="/idolon/emvicy/png/150/150/0/">

<!--smarty-->
<!--create different variations of image-->
{section name=counter start=10 step=10 loop=160}
<img
        src="/idolon/emvicy/png/{$smarty.section.counter.index}/{$smarty.section.counter.index}/0/"
        width="{$smarty.section.counter.index}"
        height="{$smarty.section.counter.index}"
>
{/section}
<!--/create different variations of image-->
<!--/smarty-->
~~~