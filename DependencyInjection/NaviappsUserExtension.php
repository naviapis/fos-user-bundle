<?php

namespace Naviapps\Bundle\UserBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class NaviappsUserExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        if (!empty($config['profile'])) {
            $this->loadProfile($config['profile'], $container, $loader);
        }

        if (!empty($config['registration'])) {
            $this->loadRegistration($config['registration'], $container, $loader);
        }

        if (!empty($config['change_password'])) {
            $this->loadChangePassword($config['change_password'], $container, $loader);
        }

        if (!empty($config['resetting'])) {
            $this->loadResetting($config['resetting'], $container, $loader);
        }

        if (!empty($config['deactivation'])) {
            $this->loadDeactivation($config['deactivation'], $container, $loader);
        }
    }

    private function loadProfile(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        $loader->load('profile.xml');

        $this->remapParametersNamespaces($config, $container, array(
            'form' => 'naviapps_user.profile.form.%s',
        ));

        $container->setAlias('naviapps_user.profile.form.flow', $config['form']['flow']);
    }

    private function loadRegistration(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        $loader->load('registration.xml');

        $this->remapParametersNamespaces($config, $container, array(
            'form' => 'naviapps_user.registration.form.%s',
        ));

        $container->setAlias('naviapps_user.registration.form.flow', $config['form']['flow']);
    }

    private function loadChangePassword(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        $loader->load('change_password.xml');

        $this->remapParametersNamespaces($config, $container, array(
            'form' => 'naviapps_user.change_password.form.%s',
        ));

        $container->setAlias('naviapps_user.change_password.form.flow', $config['form']['flow']);
    }

    private function loadResetting(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        $loader->load('resetting.xml');

        $this->remapParametersNamespaces($config, $container, array(
            'form' => 'naviapps_user.resetting.form.%s',
        ));

        $container->setAlias('naviapps_user.resetting.form.flow', $config['form']['flow']);
    }

    private function loadDeactivation(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        $loader->load('deactivation.xml');

        $this->remapParametersNamespaces($config, $container, array(
            'form' => 'naviapps_user.deactivation.form.%s',
        ));

        $container->setAlias('naviapps_user.deactivation.form.flow', $config['form']['flow']);
    }

    protected function remapParameters(array $config, ContainerBuilder $container, array $map)
    {
        foreach ($map as $name => $paramName) {
            if (array_key_exists($name, $config)) {
                $container->setParameter($paramName, $config[$name]);
            }
        }
    }

    protected function remapParametersNamespaces(array $config, ContainerBuilder $container, array $namespaces)
    {
        foreach ($namespaces as $ns => $map) {
            if ($ns) {
                if (!array_key_exists($ns, $config)) {
                    continue;
                }
                $namespaceConfig = $config[$ns];
            } else {
                $namespaceConfig = $config;
            }
            if (is_array($map)) {
                $this->remapParameters($namespaceConfig, $container, $map);
            } else {
                foreach ($namespaceConfig as $name => $value) {
                    $container->setParameter(sprintf($map, $name), $value);
                }
            }
        }
    }
}
