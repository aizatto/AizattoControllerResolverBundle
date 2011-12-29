<?php

namespace Aizatto\Bundle\ControllerResolverBundle;

use Symfony\Bundle\FrameworkBundle\Controller\ControllerResolver as BaseControllerResolver;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class ControllerResolver extends BaseControllerResolver {

  protected function createController($controller) {
    if (false !== strpos($controller, '::')) {
      return parent::createController($controller);
    }

    $count = substr_count($controller, ':');
    if (1 != $count) {
      return parent::createController($controller);
    }

    list($bundle, $controller) = explode(':', $controller);
    $bundles = $this->container->get('kernel')->getBundle($bundle, false);
    $class = null;
    foreach ($bundles as $b) {
      $try = $b->getNamespace().'\\Controller\\'.$controller.'Controller';
      if (!class_exists($try)) {
        $logs[] = sprintf('Unable to find controller "%s:%s" - class "%s" does not exist.', $bundle, $controller, $try);
      } else {
        $class = $try;
        break;
      }
    }

    if ($class == null) {
      throw new \Exception(sprintf('Unable to find %s', $try));
    }

    $controller = new $class();
    if ($controller instanceof ContainerAwareInterface) {
      $controller->setContainer($this->container);
    }

    return array($controller, 'getResponse');
  }

}
