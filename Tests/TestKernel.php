<?php

namespace BOMO\IcalBundle\Tests;


use BOMO\IcalBundle\BOMOIcalBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;

class TestKernel extends Kernel
{
    protected $servicesDefinitionPath;

    public function __construct($servicesDefinitionPath)
    {
        parent::__construct('test', true);
        $this->servicesDefinitionPath = $servicesDefinitionPath;
    }



    public function registerBundles(): iterable
    {
        return array(
            new FrameworkBundle(),
            new BOMOIcalBundle(),
        );
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(function (ContainerBuilder $container) use ($loader) {
            $container->loadFromExtension('framework', array(
                'secret' => 'foo',
            ));
        });

        $loader->load($this->servicesDefinitionPath);
    }

    public function getCacheDir() :string
    {
        return sys_get_temp_dir().'/cache'.spl_object_hash($this);
    }

    public function getLogDir() :string
    {
        return sys_get_temp_dir().'/logs'.spl_object_hash($this);
    }
}
