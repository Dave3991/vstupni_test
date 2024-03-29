<?php declare(strict_types = 1);

namespace VstupniTest\App\Controller;

use Apitte\Core\Annotation\Controller\GroupPath;
/**
 * @GroupPath("/v1")
 */
abstract class BaseV1Controller extends BaseController
{
    public function getIpAddress(): string
    {
        $ip=$_SERVER['REMOTE_ADDR'];
        return $ip;
    }
}
