<?php

namespace Helthe\Bundle\TurbolinksBundle\Tests\DependencyInjection;

use Helthe\Bundle\TurbolinksBundle\DependencyInjection\HeltheTurbolinksExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class HeltheTurbolinksExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadDefault()
    {
        $container = new ContainerBuilder();
        $loader = new HeltheTurbolinksExtension();
        $loader->load(array(array()), $container);
        
        $this->assertTrue($container->hasParameter('helthe_turbolinks.listener.cross_domain.class'));
        $this->assertTrue($container->hasParameter('helthe_turbolinks.listener.redirect.class'));
        $this->assertTrue($container->hasParameter('helthe_turbolinks.listener.request_method.class'));
        $this->assertTrue($container->hasDefinition('helthe_turbolinks.listener.cross_domain'));
        $this->assertTrue($container->getDefinition('helthe_turbolinks.listener.cross_domain')->hasTag('kernel.event_subscriber'));
        $this->assertTrue($container->hasDefinition('helthe_turbolinks.listener.redirect'));
        $this->assertTrue($container->getDefinition('helthe_turbolinks.listener.redirect')->hasTag('kernel.event_subscriber'));
        $this->assertTrue($container->hasDefinition('helthe_turbolinks.listener.request_method'));
        $this->assertTrue($container->getDefinition('helthe_turbolinks.listener.request_method')->hasTag('kernel.event_subscriber'));
    }
}