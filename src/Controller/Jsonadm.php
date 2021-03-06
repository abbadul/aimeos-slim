<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016
 * @package Slim
 * @subpackage Controller
 */


namespace Aimeos\Slim\Controller;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;


/**
 * Aimeos controller for the JSON REST API
 *
 * @package Slim
 * @subpackage Controller
 */
class Jsonadm
{
	/**
	 * Deletes the resource object or a list of resource objects
	 *
	 * @param ContainerInterface $container Dependency injection container
	 * @param ServerRequestInterface $request Request object
	 * @param ResponseInterface $response Response object
	 * @param array $args Associative list of route parameters
	 * @return ResponseInterface $response Modified response object with generated output
	 */
	public static function deleteAction( ContainerInterface $container, ServerRequestInterface $request, ResponseInterface $response, array $args )
	{
		return self::createClient( $container, $request, $response, $args )->delete( $request, $response );
	}


	/**
	 * Returns the requested resource object or list of resource objects
	 *
	 * @param ContainerInterface $container Dependency injection container
	 * @param ServerRequestInterface $request Request object
	 * @param ResponseInterface $response Response object
	 * @param array $args Associative list of route parameters
	 * @return ResponseInterface $response Modified response object with generated output
	 */
	public static function getAction( ContainerInterface $container, ServerRequestInterface $request, ResponseInterface $response, array $args )
	{
		return self::createClient( $container, $request, $response, $args )->get( $request, $response );
	}


	/**
	 * Updates a resource object or a list of resource objects
	 *
	 * @param ContainerInterface $container Dependency injection container
	 * @param ServerRequestInterface $request Request object
	 * @param ResponseInterface $response Response object
	 * @param array $args Associative list of route parameters
	 * @return ResponseInterface $response Modified response object with generated output
	 */
	public static function patchAction( ContainerInterface $container, ServerRequestInterface $request, ResponseInterface $response, array $args )
	{
		return self::createClient( $container, $request, $response, $args )->patch( $request, $response );
	}


	/**
	 * Creates a new resource object or a list of resource objects
	 *
	 * @param ContainerInterface $container Dependency injection container
	 * @param ServerRequestInterface $request Request object
	 * @param ResponseInterface $response Response object
	 * @param array $args Associative list of route parameters
	 * @return ResponseInterface $response Modified response object with generated output
	 */
	public static function postAction( ContainerInterface $container, ServerRequestInterface $request, ResponseInterface $response, array $args )
	{
		return self::createClient( $container, $request, $response, $args )->post( $request, $response );
	}


	/**
	 * Creates or updates a single resource object
	 *
	 * @param ContainerInterface $container Dependency injection container
	 * @param ServerRequestInterface $request Request object
	 * @param ResponseInterface $response Response object
	 * @param array $args Associative list of route parameters
	 * @return ResponseInterface $response Modified response object with generated output
	 */
	public static function putAction( ContainerInterface $container, ServerRequestInterface $request, ResponseInterface $response, array $args )
	{
		return self::createClient( $container, $request, $response, $args )->put( $request, $response );
	}


	/**
	 * Returns the available HTTP verbs and the resource URLs
	 *
	 * @param ContainerInterface $container Dependency injection container
	 * @param ServerRequestInterface $request Request object
	 * @param ResponseInterface $response Response object
	 * @param array $args Associative list of route parameters
	 * @return ResponseInterface $response Modified response object with generated output
	 */
	public static function optionsAction( ContainerInterface $container, ServerRequestInterface $request, ResponseInterface $response, array $args )
	{
		return self::createClient( $container, $request, $response, $args )->options( $request, $response );
	}


	/**
	 * Returns the resource controller
	 *
	 * @param ContainerInterface $container Dependency injection container
	 * @param ServerRequestInterface $request Request object
	 * @param ResponseInterface $response Response object
	 * @param array $args Associative list of route parameters
	 * @return \Aimeos\Controller\JsonAdm\Iface JSON admin controller
	 */
	protected static function createClient( ContainerInterface $container, ServerRequestInterface $request, ResponseInterface $response, array $args )
	{
		$resource = ( isset( $args['resource'] ) ? $args['resource'] : null );
		$site = ( isset( $args['site'] ) ? $args['site'] : 'default' );
		$lang = ( isset( $args['lang'] ) ? $args['lang'] : 'en' );

		$templatePaths = $container->get( 'aimeos' )->getCustomPaths( 'admin/jsonadm/templates' );

		$context = $container->get( 'aimeos_context' )->get( false, $args, 'backend' );
		$context->setI18n( $container->get( 'aimeos_i18n' )->get( array( $lang, 'en' ) ) );
		$context->setLocale( $container->get( 'aimeos_locale' )->getBackend( $context, $site ) );

		$view = $container->get( 'aimeos_view' )->create( $context->getConfig(), $request, $response, $args, $templatePaths, $lang );
		$context->setView( $view );

		return \Aimeos\Admin\JsonAdm\Factory::createClient( $context, $templatePaths, $resource );
	}
}
