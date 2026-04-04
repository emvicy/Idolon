<?php

namespace Idolon\Controller;


use App\Controller;
use MVC\DataType\DTRequestIn;
use MVC\DataType\DTRoute;

class Idolon extends Controller
{
    /**
     * @param \MVC\DataType\DTRequestIn $oDTRequestIn
     * @param \MVC\DataType\DTRoute     $oDTRoute
     * @return void
     * @throws \ReflectionException
     */
    public function serve(DTRequestIn $oDTRequestIn, DTRoute $oDTRoute)
    {
        // get token
        $sToken = (array_first($oDTRequestIn->get_pathArray()) ?? '');

        // get config out of routing additional
        $aConfig = $oDTRoute->get_additional();

        // handle due to config
        if (false === empty($aConfig))
        {
            new \Idolon\Model\Index(array(
                'bPreventOversizing' => $aConfig['IDOLON_PREVENT_OVERSIZING']
            ))
                ->setImagePath($aConfig['IDOLON_IMAGE_PATH'])
                ->setCachepath($aConfig['IDOLON_CACHE_PATH'])
                ->setIdolonToken($sToken)
                ->setMaxCacheFilesForImage($aConfig['IDOLON_MAX_CACHE_FILES_FOR_IMAGE'])
                ->run()
            ;
        }
    }
}
