<?php


namespace TestInpsyde\Wp\Plugin;

use Exception;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Container\Container;
use TestInpsyde\Wp\Plugin\Interfaces\WPPluginInterface;
use TestInpsyde\Wp\Plugin\Services\PageRendererService;
use TestInpsyde\Wp\Plugin\Services\UserRemoteJsonService;
use TestInpsyde\Wp\Plugin\Services\ViewService;
use TestInpsyde\Wp\Plugin\Traits\ServiceTrait;
use TestInpsyde\Wp\Plugin\Traits\ConfigTrait;
use TestInpsyde\Wp\Plugin\Traits\WPAttributeTrait;

/**
 * Class TestInpsyde
 * @package TestInpsyde\Wp\Plugin
 */
class TestInpsyde extends Container implements WPPluginInterface
{
    use ConfigTrait;
    use WPAttributeTrait;

    const CUSTOM_ENDPOINT_NAME = 'custom-inpsyde';

    /**
     * @var string Version of this plugin
     */
    public $version;

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

        // phpcs:ignore PSR2.ControlStructures.ControlStructureSpacing.SpacingAfterOpenBrace
        if ( ! empty($services = $config['services'] ?? null)) {
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

        // phpcs:ignore PSR2.ControlStructures.ControlStructureSpacing.SpacingAfterOpenBrace
        if ( ! static::getInstance() instanceof static) {
            throw new Exception('No plugin initialized.');
        }
    }

    /**
     * Initialize all needed things for this plugin: hooks, assignments ...
     */
    public function initPlugin()
    {
        // Load Text Domain
        $locale = determine_locale();
        $mofile = $locale.'.mo';
        load_textdomain($this->textDomain, $this->basePath.'/languages/'.$mofile);

        add_action('init', [$this, 'addCustomRewriteRules']);
        add_action('wp_ajax_get_single_user', [$this, 'renderSingleUserResponse']);
        add_action('wp_ajax_nopriv_get_single_user', [$this, 'renderSingleUserResponse']);

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
            // Set global $wp_query to 404 to avoid unwanted warnings
            global $wp_query;
            $wp_query->set_404();

            $users = $errorMessage = null;
            try {
                /** @var UserRemoteJsonService $userRemoteJsonService */
                $userRemoteJsonService = $this->getService(UserRemoteJsonService::class);
                $users                 = $userRemoteJsonService->getList();
            } catch (ClientException $clientException) {
                $errorMessage = WP_DEBUG ? $clientException->getMessage() :
                    __('There is problem with remote data', $this->textDomain);
            }


            /** @var PageRendererService $pageRendererService */
            $pageRendererService = $this->getService(PageRendererService::class);
            $pageRendererService->render($pagename, [
                'users'        => $users,
                'textDomain'   => $this->textDomain,
                'errorMessage' => $errorMessage,
            ]);
        }
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function renderSingleUserResponse()
    {
        if (isset($_GET['id'])) {
            $userId = intval($_GET['id']);
        }

        /** @var UserRemoteJsonService $userRemoteJsonService */
        $userRemoteJsonService = $this->getService(UserRemoteJsonService::class);
        $user                  = $userRemoteJsonService->getSingle($userId);

        /** @var PageRendererService $pageRendererService */
        $pageRendererService = $this->getService(PageRendererService::class);
        $pageRendererService->render('_view-user', [
            'user'       => $user,
            'textDomain' => $this->textDomain,
        ]);
    }
}
