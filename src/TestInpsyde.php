<?php


namespace TestInpsyde\Wp\Plugin;

use Exception;
use Illuminate\Container\Container;
use TestInpsyde\Wp\Plugin\Interfaces\WPPlugin;
use TestInpsyde\Wp\Plugin\Services\ViewService;
use TestInpsyde\Wp\Plugin\Traits\ServiceTrait;
use TestInpsyde\Wp\Plugin\Traits\ConfigTrait;
use TestInpsyde\Wp\Plugin\Traits\WPAttributeTrait;

class TestInpsyde extends Container implements WPPlugin
{
    use ConfigTrait;
    use WPAttributeTrait;

    const CUSTOM_ENDPOINT_NAME = 'custom-inpsyde';

    /** @noinspection PhpUnusedElementInspection */
    /**
     * @var string Base path to this plugin
     */
    public $basePath;

    /**
     * @var string Base url of the folder of this plugin
     */
    public $baseUrl;

    /**
     * Tamara_Checkout constructor.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->bindConfig($config);

        if (! empty($services = $config['services'] ?? null)) {
            $this->registerServices($services);
        }
    }

    /**
     * Register service providers set in config
     *
     * @param $services
     */
    protected function registerServices($services)
    {
        foreach ($services as $serviceClassname => $serviceConfig) {
            if (class_exists($serviceClassname)) {
                $this->bind(
                    $serviceClassname,
                    function ($container) use ($serviceClassname, $serviceConfig) {
                        $serviceInstance = new $serviceClassname();
                        if (method_exists($serviceInstance, 'bindConfig')) {
                            $serviceInstance->bindConfig($serviceConfig);
                        }

                        if (in_array(ServiceTrait::class, class_uses($serviceInstance))) {
                            /** @noinspection PhpUndefinedMethodInspection */
                            $serviceInstance->setContainer($container);
                            /** @noinspection PhpUndefinedMethodInspection */
                            $serviceInstance->init();
                        }

                        return $serviceInstance;
                    }
                );
            }
        }
    }

    /** @noinspection PhpFullyQualifiedNameUsageInspection */
    /**
     * @param $alias
     *
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getService($alias)
    {
        return $this->make($alias);
    }

    /** @noinspection PhpFullyQualifiedNameUsageInspection */
    /**
     * Get the `view` service
     *
     * @return ViewService
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function getServiceView()
    {
        return static::getInstance()->getService(ViewService::class);
    }

    /**
     * @param $config
     *
     * @throws Exception
     */
    public static function initInstanceWithConfig($config)
    {
        if (is_null(static::$instance)) {
            static::setInstance(new static($config));
        }

        if (! static::getInstance() instanceof static) {
            throw new Exception('No plugin initialized.');
        }
    }

    /**
     * Initialize all needed things for this plugin: hooks, assignments ...
     */
    public function initPlugin()
    {
        add_action('init', [$this, 'addCustomRewriteRules']);

        // We use `parse_query` hook for allowing widgets to be initialized
        add_action('parse_query', [$this, 'renderCustomInpsydeResponse'], 77);
    }

    /**
     * Do some needed things when activate plugin
     */
    public function activatePlugin()
    {
        // Add rewrite rules
        $this->addCustomRewriteRules();

        // Flush rewrite rules when activate plugins
        flush_rewrite_rules(false);
    }


    /**
     * @noinspection PhpUnusedDeclarationInspection
     */
    public function deactivatePlugin()
    {
        // The problem with calling flush_rewrite_rules() is that the rules instantly get regenerated, while your plugin's hooks are still active.
        delete_option('rewrite_rules');
    }

    /**
     * Add rewrite rule for Tamara IPN response page
     */
    public function addCustomRewriteRules()
    {
        add_rewrite_rule('custom-inpsyde/?$', 'index.php?pagename='.static::CUSTOM_ENDPOINT_NAME, 'top');
    }

    /** @noinspection PhpFullyQualifiedNameUsageInspection */
    /**
     * Handle response for custom endpoint
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function renderCustomInpsydeResponse()
    {
        $pagename = get_query_var('pagename');

        if (static::CUSTOM_ENDPOINT_NAME === $pagename) {
            /** @var ViewService $viewService */
            $viewService = $this->getService(ViewService::class);

            // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
            echo $viewService->render('views/'.$pagename);
            exit;
        }
    }
}
