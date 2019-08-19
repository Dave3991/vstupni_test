<?php declare(strict_types = 1);

namespace VstupniTest\App\Controller;

use Apitte\Core\Annotation\Controller\GroupPath;
use Apitte\Core\UI\Controller\IController;
/**
 * @GroupPath("/api")
 */
abstract class BaseController implements IController
{
}