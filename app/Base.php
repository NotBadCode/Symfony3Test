<?php

namespace app;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;

/**
 * Class Base
 */
class Base
{
    protected $matcher;
    protected $controllerResolver;
    protected $argumentResolver;

    /**
     * Base constructor.
     * @inheritdoc
     * @param UrlMatcher         $matcher
     * @param ControllerResolver $controllerResolver
     * @param ArgumentResolver   $argumentResolver
     */
    public function __construct(UrlMatcher $matcher,
                                ControllerResolver $controllerResolver,
                                ArgumentResolver $argumentResolver)
    {
        $this->matcher            = $matcher;
        $this->controllerResolver = $controllerResolver;
        $this->argumentResolver   = $argumentResolver;
    }

    /**
     * @param Request $request
     * @inheritdoc
     * @return mixed|Response
     */
    public function handle(Request $request)
    {
        $this->matcher->getContext()->fromRequest($request);

        try {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));

            $controller = $this->controllerResolver->getController($request);
            $arguments  = $this->argumentResolver->getArguments($request, $controller);

            return call_user_func_array($controller, $arguments);
        } catch (ResourceNotFoundException $e) {
            return new Response('Not Found', 404);
        } catch (\Exception $e) {
            return new Response('An error occurred', 500);
        }
    }
}