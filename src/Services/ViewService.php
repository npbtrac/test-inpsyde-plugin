<?php

namespace TestInpsyde\Wp\Plugin\Services;

use Exception;
use TestInpsyde\Wp\Plugin\Traits\ConfigTrait;
use TestInpsyde\Wp\Plugin\Traits\ServiceTrait;

class ViewService
{
    use ConfigTrait;
    use ServiceTrait;

    public $basePath;
    public $baseUrl;

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->basePath = $this->getContainer()->basePath;
        $this->baseUrl = $this->getContainer()->baseUrl;
    }

    /**
     * Render a view file
     *
     * @param $viewFilePath
     * @param array $params
     *
     * @return string|void
     * @throws Exception
     */
    public function render($viewFilePath, $params = [])
    {
        global $wp_query;

        $extension = '.php';
        // phpcs:ignore WordPress.PHP.DontExtract.extract_extract
        $wp_query->query_vars['viewParams'] = $params;

        if (strpos($viewFilePath, '/') === 1) {
            return load_template($viewFilePath.$extension, false);
        }

        $templateContent = locate_template($viewFilePath.$extension, true, false);
        // phpcs:ignore PSR2.ControlStructures.ControlStructureSpacing.SpacingAfterOpenBrace
        if ( ! empty($templateContent)) {
            return $templateContent;
        }

        if (file_exists($this->basePath.DIRECTORY_SEPARATOR.$viewFilePath.$extension)) {
            return load_template($this->basePath.DIRECTORY_SEPARATOR.$viewFilePath.$extension, false);
        }

        throw new Exception(sprintf(
            "View file not working: %s.\n",
            $viewFilePath.$extension
        ));
    }
}
