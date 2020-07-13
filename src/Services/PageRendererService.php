<?php


namespace TestInpsyde\Wp\Plugin\Services;

use TestInpsyde\Wp\Plugin\TestInpsyde;
use TestInpsyde\Wp\Plugin\Traits\ConfigTrait;
use TestInpsyde\Wp\Plugin\Traits\ServiceTrait;

/**
 * Class PageRendererService
 * @package TestInpsyde\Wp\Plugin\Services
 * @method TestInpsyde getContainer()
 */
class PageRendererService
{
    use ConfigTrait;
    use ServiceTrait;

    /**
     * @inheritDoc
     */
    public function init()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
    }

    /**
     * Enqueue JS and CSS
     */
    public function enqueueScripts()
    {
        // JS
        wp_enqueue_script('jquery');
        wp_enqueue_script(
            'test-inpsyde-plugin-main',
            $this->getContainer()->baseUrl.'/assets/dist/js/main.js',
            ['jquery'],
            $this->getContainer()->version,
            true
        );

        // CSS
        wp_enqueue_style(
            'test-inpsyde-plugin-main',
            $this->getContainer()->baseUrl.'/assets/dist/css/main.css',
            [],
            $this->getContainer()->version
        );
    }

    /** @noinspection PhpFullyQualifiedNameUsageInspection */
    /**
     * Render custom page with corresponding pagename (slug)
     *
     * @param string $pagename Name (slug) of page to be rendered
     * @param array $params Array of params to put to views
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function render($pagename, $params = [])
    {
        /** @var ViewService $viewService */
        $viewService = $this->getContainer()->getService(ViewService::class);

        // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
        echo $viewService->render('views/page/'.$pagename, $params);
        exit;
    }
}
