<?php namespace TestInpsyde\Wp\Plugin\Tests\Unit;

use Brain\Monkey;
use Codeception\Stub;
use Illuminate\Contracts\Container\BindingResolutionException;
use TestInpsyde\Wp\Plugin\Services\ViewService;
use TestInpsyde\Wp\Plugin\TestInpsyde;
use TestInpsyde\Wp\Plugin\TestInpsyde as Testee;
use TestInpsyde\Wp\Plugin\Tests\UnitTestCase;
use function Brain\Monkey\Functions\expect;
use function Brain\Monkey\Actions\expectAdded as expectActionAdded;
use function Brain\Monkey\Filters\expectAdded as expectFilterAdded;
use TestInpsyde\Wp\Plugin\Tests\UnitTester;
use TestInpsyde\Wp\Plugin\Services\UserRemoteJsonService;


class TestInpsydeTest extends UnitTestCase
{
    /**
     * @var UnitTester
     */
    protected $tester;

    protected $config;

    protected function _before()
    {
        Monkey\setUp();
        $this->config = [
            'basePath' => 'http://test-inpsyde-plugin.docker/wp-content/plugins/test-inpsyde-plugin',
            'services' => [
                'A non-existing service',
                Stub::class,
            ],
            ViewService::class => [
            ],
        ];
    }

    protected function _after()
    {
        Monkey\tearDown();
    }

    // Test Constructor and service registration
    public function testInstanceWithConfig()
    {
        /** @var Testee $testeeInstance */
        $testeeInstance = $this->construct(Testee::class,
            [
                'config' => $this->config,
            ],
            [
            ]
        );

        // Test the property `basePath`
        $this->assertEquals('http://test-inpsyde-plugin.docker/wp-content/plugins/test-inpsyde-plugin',
            $testeeInstance->basePath);

        // Test a correct service to me initialized
        $tmpService = $testeeInstance->getService(ViewService::class);
        $this->assertInstanceOf(ViewService::class, $tmpService);

        // Test a non-existing service, an exception thrown
        $this->expectException(BindingResolutionException::class);
        $tmpService = $testeeInstance->getService('A non-existing service');

        // Test a global instnce created
        TestInpsyde::initInstanceWithConfig($this->config);
        $this->assertInstanceOf(Testee::class, Testee::getInstance());

        // Test global instance properties not changed after created
        $config['basePath'] = 'Another one';
        TestInpsyde::initInstanceWithConfig($this->config);
        $this->assertEquals('http://test-inpsyde-plugin.docker/wp-content/plugins/test-inpsyde-plugin',
            Testee::getInstance()->basePath);
    }

    // Test Init Plugin
    public function testInitPlugin()
    {
        $testeeInstance = $this->make(Testee::class,
            [
                'loadTextDomain' => function () {

                },
            ]
        );

        // Test action init with method `addCustomRewriteRules` added
        expect('add_action')->atLeast()->once()->with('init', [$testeeInstance, 'addCustomRewriteRules']);
        expect('add_action')->atLeast()->once()->with('wp_loaded', [$testeeInstance, 'renderCustomInpsydeResponse'],
            77);
        $testeeInstance->initPlugin();

    }
}
