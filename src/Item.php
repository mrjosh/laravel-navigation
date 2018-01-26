<?php

namespace Josh\Components\Navigation;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;

class Item
{
    /**
     * Name of item
     *
     * @var string
     */
    protected $name;

    /**
     * Title of item
     *
     * @var string
     */
    protected $title;

    /**
     * Route instance
     *
     * @var Route
     */
    protected $route;

    /**
     * Item uri
     *
     * @var string
     */
    protected $uri;

    /**
     * Icon class
     *
     * @var string
     */
    protected $icon;

    /**
     * Match item with request status
     *
     * @var bool
     */
    protected $match = false;

    /**
     * Sub item
     *
     * @var Item
     */
    protected $sub;

    /**
     * Item constructor.
     *
     * @param null $name
     */
    public function __construct($name = null)
    {
        $this->name = $name;
    }

    /**
     * set title for item
     *
     * @param $title
     * @return $this
     */
    public function title($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Add icon class
     *
     * @param $name
     * @return Item
     */
    public function icon($name)
    {
        $this->icon = $name;

        return $this;
    }

    /**
     * Add route
     *
     * @param $name
     * @throws \InvalidArgumentException
     */
    public function route($name)
    {
        $this->route = $this->findRoute($name);

        $this->uri($this->route->uri());
    }

    /**
     * Add uri
     *
     * @param $uri
     * @return Item
     */
    public function uri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * Set is item match with request uri
     *
     * @param $match
     * @return $this
     */
    public function match($match)
    {
        $this->match = $match;

        return $this;
    }

    /**
     * get url match status
     *
     * @return bool
     */
    public function isMatch()
    {
        return $this->match;
    }

    /**
     * Check route for match in request
     *
     * @param Request $request
     */
    public function checkForMatch(Request $request = null)
    {
        if(is_null($request)){

            $request = app('request');
        }

        $path = $request->path() == '/' ? '/' : '/' . $request->path();

        if(! is_null($this->route)){

            $this->route->bind($request);

            $match = preg_match($this->route->getCompiled()->getRegex(), rawurldecode($path));

            if( $match){

                $this->match(true);
            }
        } else {

            $match = preg_match("#^/" . $this->uri . "$#s", rawurldecode($path));

            if( $match){

                $this->match(true);
            }
        }
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->uri;
    }

    /**
     * Get name
     *
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get url
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getUrl()
    {
        return url($this->uri);
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get item icon
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Get item sub
     *
     * @return Item
     */
    public function getSub()
    {
        return $this->sub;
    }

    /**
     * Add sub for item
     *
     * @param $name
     * @param \Closure $callback
     * @return $this
     */
    public function sub($name,\Closure $callback)
    {
        $item = new Item($name);

        call_user_func($callback,$item);

        $item->checkForMatch();

        $this->sub = $item;

        return $item;
    }

    /**
     * Find the route
     *
     * @param $route
     * @return Route|null
     */
    protected function findRoute($route)
    {
        /** @var Router $router */
        $router = app('router');

        $router->getRoutes()->refreshNameLookups();

        if(is_null($route = $router->getRoutes()->getByName($route))){

            throw new \InvalidArgumentException("Route [$route] not defined.");
        }

        return $route;
    }
}