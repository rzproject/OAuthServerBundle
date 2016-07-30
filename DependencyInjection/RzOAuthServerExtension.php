<?php

namespace Rz\OAuthServerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Sonata\EasyExtendsBundle\Mapper\DoctrineCollector;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class RzOAuthServerExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $config = $processor->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('admin.xml');
        $loader->load('orm.xml');

        $this->configureManagerClass($config, $container);
        $this->configureClass($config, $container);
        $this->configureAdminClass($config, $container);
        $this->configureController($config, $container);
        $this->configureTranslationDomain($config, $container);

        $this->registerDoctrineMapping($config);
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'rz_oauth_server';
    }

    /**
     * @param array                                                   $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @return void
     */
    public function configureClass($config, ContainerBuilder $container)
    {
        $container->setParameter('rz.oauth_server.admin.access_token.entity',    $config['class']['access_token']);
        $container->setParameter('rz.oauth_server.access_token.entity',          $config['class']['access_token']);

        $container->setParameter('rz.oauth_server.auth_code.entity',             $config['class']['auth_code']);

        $container->setParameter('rz.oauth_server.admin.client.entity',          $config['class']['client']);
        $container->setParameter('rz.oauth_server.client.entity',                $config['class']['client']);

        $container->setParameter('rz.oauth_server.refresh_token.entity',         $config['class']['refresh_token']);
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    public function configureManagerClass($config, ContainerBuilder $container)
    {
        $container->setParameter('rz.oauth_server.entity.manager.access_token.class',    $config['manager_class']['orm']['access_token']);
        $container->setParameter('rz.oauth_server.entity.manager.auth_code.class',       $config['manager_class']['orm']['auth_code']);
        $container->setParameter('rz.oauth_server.entity.manager.client.class',          $config['manager_class']['orm']['client']);
        $container->setParameter('rz.oauth_server.entity.manager.refresh_token.class',   $config['manager_class']['orm']['refresh_token']);
    }

    /**
     * @param array                                                   $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @return void
     */
    public function configureAdminClass($config, ContainerBuilder $container)
    {
        $container->setParameter('rz.oauth_server.admin.access_token.class',        $config['admin']['access_token']['class']);
        $container->setParameter('rz.oauth_server.admin.client.class',              $config['admin']['client']['class']);
    }

    /**
     * @param array                                                   $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @return void
     */
    public function configureTranslationDomain($config, ContainerBuilder $container)
    {
        $container->setParameter('rz.oauth_server.admin.access_token.translation_domain', $config['admin']['access_token']['translation']);
        $container->setParameter('rz.oauth_server.admin.client.translation_domain',       $config['admin']['client']['translation']);
    }

    /**
     * @param array                                                   $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @return void
     */
    public function configureController($config, ContainerBuilder $container)
    {
        $container->setParameter('rz.oauth_server.admin.access_token.controller',   $config['admin']['access_token']['controller']);
        $container->setParameter('rz.oauth_server.admin.client.controller',         $config['admin']['client']['controller']);
    }

    /**
     * @param array $config
     */
    public function registerDoctrineMapping(array $config)
    {
        foreach ($config['class'] as $type => $class) {
            if (!class_exists($class)) {
                return;
            }
        }

        $collector = DoctrineCollector::getInstance();

        # Access Token
        $collector->addAssociation($config['class']['access_token'], 'mapManyToOne', array(
            'fieldName' => 'client',
            'targetEntity' => $config['class']['client'],
            'cascade' => array(
                'persist',
            ),
            'mappedBy' => null,
            'inversedBy' => 'accessToken',
            'joinColumns' => array(
                array(
                    'name' => 'client_id',
                    'referencedColumnName' => 'id',
                ),
            ),
            'orphanRemoval' => false,
        ));

        $collector->addAssociation($config['class']['access_token'], 'mapManyToOne', array(
            'fieldName' => 'user',
            'targetEntity' => $config['class']['user'],
            'cascade' => array(
                'persist',
            ),
            'mappedBy' => null,
            'inversedBy' => 'accessToken',
            'joinColumns' => array(
                array(
                    'name' => 'user_id',
                    'referencedColumnName' => 'id',
                ),
            ),
            'orphanRemoval' => false,
        ));

        #Auth Code

        $collector->addAssociation($config['class']['refresh_token'], 'mapManyToOne', array(
            'fieldName' => 'client',
            'targetEntity' => $config['class']['client'],
            'cascade' => array(
                'persist',
            ),
            'mappedBy' => null,
            'inversedBy' => 'accessToken',
            'joinColumns' => array(
                array(
                    'name' => 'client_id',
                    'referencedColumnName' => 'id',
                ),
            ),
            'orphanRemoval' => false,
        ));

        $collector->addAssociation($config['class']['refresh_token'], 'mapManyToOne', array(
            'fieldName' => 'user',
            'targetEntity' => $config['class']['user'],
            'cascade' => array(
                'persist',
            ),
            'mappedBy' => null,
            'inversedBy' => 'accessToken',
            'joinColumns' => array(
                array(
                    'name' => 'user_id',
                    'referencedColumnName' => 'id',
                ),
            ),
            'orphanRemoval' => false,
        ));



        #Auth Code

        $collector->addAssociation($config['class']['auth_code'], 'mapManyToOne', array(
            'fieldName' => 'client',
            'targetEntity' => $config['class']['client'],
            'cascade' => array(
                'persist',
            ),
            'mappedBy' => null,
            'inversedBy' => 'accessToken',
            'joinColumns' => array(
                array(
                    'name' => 'client_id',
                    'referencedColumnName' => 'id',
                ),
            ),
            'orphanRemoval' => false,
        ));

        $collector->addAssociation($config['class']['auth_code'], 'mapManyToOne', array(
            'fieldName' => 'user',
            'targetEntity' => $config['class']['user'],
            'cascade' => array(
                'persist',
            ),
            'mappedBy' => null,
            'inversedBy' => 'accessToken',
            'joinColumns' => array(
                array(
                    'name' => 'user_id',
                    'referencedColumnName' => 'id',
                ),
            ),
            'orphanRemoval' => false,
        ));
    }
}
