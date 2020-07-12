<?php


namespace TestInpsyde\Wp\Plugin\Services;

use TestInpsyde\Wp\Plugin\TestInpsyde;
use TestInpsyde\Wp\Plugin\Traits\ConfigTrait;
use TestInpsyde\Wp\Plugin\Traits\ServiceTrait;
use TestInpsyde\Wp\Plugin\Traits\WPAttributeTrait;

/**
 * Class PageRendererService
 * @package TestInpsyde\Wp\Plugin\Services
 * @method TestInpsyde getContainer()
 */
class PageRendererService
{
    use ConfigTrait;
    use WPAttributeTrait;
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

    /**
     * Render custom page with corresponding pagename (slug)
     *
     * @param $pagename
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function render($pagename)
    {
        /** @var ViewService $viewService */
        $viewService = $this->getContainer()->getService(ViewService::class);

        // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
        echo $viewService->render('views/'.$pagename);
        exit;
    }
}
