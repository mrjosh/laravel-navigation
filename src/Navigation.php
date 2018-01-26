<?php

namespace Josh\Components\Navigation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use function Composer\Autoload\includeFile;

class Navigation
{
    /**
     * Collection instance
     *
     * @var array
     */
    protected $collection;

    /**
     * Request instance
     *
     * @var Request
     */
    protected $request;

    /**
     * Group name
     *
     * @var string
     */
    protected $group = 'global';

    /**
     * Navigation constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * set group name
     *
     * @param $name
     * @param \Closure $callback
     */
    public function group($name, \Closure $callback)
    {
        $this->group = $name;

        $this->addCollection($name,new Collection($name));

        call_user_func($callback);
    }

    /**
     * Add nav item
     *
     * @param $name
     * @param \Closure $callback
     */
    public function register($name, \Closure $callback = null)
    {
        $item = new Item($name);

        $item->title(Lang::get("navigation." . $this->group . ".$name"));

        $item->route($name);

        if(! is_null($callback)){

            call_user_func($callback,$item);
        }

        $item->checkForMatch($this->getRequest());

        $this->addToCollection($this->group,$item);
    }

    /**
     * Add item to navigator
     *
     * @param $group
     * @param Item $item
     * @return mixed
     */
    public function addToCollection($group,Item $item)
    {
        return $this->getCollection($group)->add($item);
    }

    /**
     * Get a collection
     *
     * @param $group
     * @return mixed
     */
    public function getCollection($group)
    {
        return $this->collection[$group];
    }

    /**
     * @return array
     */
    public function getCollections()
    {
        return $this->collection;
    }

    /**
     * set a collection
     *
     * @param $name
     * @param mixed $collection
     */
    public function addCollection($name,Collection $collection)
    {
        $this->collection[$name] = $collection;
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Load routes file
     *
     * @param $path
     */
    public function loadFile($path)
    {
        includeFile($path);
    }
}