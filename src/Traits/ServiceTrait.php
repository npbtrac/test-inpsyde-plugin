<?php


namespace TestInpsyde\Wp\Plugin\Traits;

use Illuminate\Container\Container;

trait ServiceTrait
{
    /**
     * @var Container|null
     */
    protected $container = null;

    abstract public function init();

    /**
     * @param Container $container
     * @noinspection PhpUnusedDeclarationInspection
     */
    public function setContainer(Container $container)
    {
        if (null === $this->container) {
            $this->container = $container;
        }
    }

    /**
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }
}
