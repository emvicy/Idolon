<?php

namespace Idolon\Controller;


use App\Controller;
use MVC\Config;
use MVC\DataType\DTRequestIn;
use MVC\DataType\DTRoute;

class Index extends Controller
{
    /**
     * @param \MVC\DataType\DTRequestIn $oDTRequestIn
     * @param \MVC\DataType\DTRoute     $oDTRoute
     * @throws \ReflectionException
     */
    public function __construct(DTRequestIn $oDTRequestIn, DTRoute $oDTRoute)
    {
        // get token
        $sToken = (array_first($oDTRequestIn->get_pathArray()) ?? '');
        $aConfig = (Config::MODULE('Idolon')[$sToken] ?? array());

        // handle due to token config
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

    /**
     * @throws \ReflectionException
     */
    public function __destruct ()
    {
        parent::__destruct();
    }
}
