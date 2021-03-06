<?php

class LocaleTest extends \PHPUnit_Framework_TestCase
{
	public function testGet()
	{
		$settings = require dirname( dirname( __DIR__ ) ) . '/src/aimeos-default.php';
		$settings['disableSites'] = false;

		$container = new \Slim\Container();
		$container['aimeos'] = new \Aimeos\Bootstrap();
		$container['aimeos_context'] = new \Aimeos\Slim\Base\Context( $container );
		$container['aimeos_config'] = new \Aimeos\Slim\Base\Config( $container, $settings );
		$container['mailer'] = \Swift_Mailer::newInstance( \Swift_SendmailTransport::newInstance() );

		$context = $container['aimeos_context']->get( false, array(), 'backend' );
		$object = new \Aimeos\Slim\Base\Locale( $container );

		$this->assertInstanceOf( '\Aimeos\MShop\Locale\Item\Iface', $object->get( $context, array( 'site' => 'unittest' ) ) );
	}


	public function testGetBackend()
	{
		$settings = require dirname( dirname( __DIR__ ) ) . '/src/aimeos-default.php';
		$settings['disableSites'] = false;

		$container = new \Slim\Container();
		$container['aimeos'] = new \Aimeos\Bootstrap();
		$container['aimeos_context'] = new \Aimeos\Slim\Base\Context( $container );
		$container['aimeos_config'] = new \Aimeos\Slim\Base\Config( $container, $settings );
		$container['mailer'] = \Swift_Mailer::newInstance( \Swift_SendmailTransport::newInstance() );

		$context = $container['aimeos_context']->get( false, array(), 'backend' );
		$object = new \Aimeos\Slim\Base\Locale( $container );

		$this->assertInstanceOf( '\Aimeos\MShop\Locale\Item\Iface', $object->getBackend( $context, 'unittest' ) );
	}
}
