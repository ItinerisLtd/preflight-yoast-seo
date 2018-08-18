<?php
declare(strict_types=1);

namespace Itineris\Preflight\YoastSEO\Test\Checkers;

use Codeception\Test\Unit;
use Itineris\Preflight\Checkers\AbstractChecker;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\Results\Success;
use Itineris\Preflight\Test\Checkers\AbstractCheckerTestTrail;
use Itineris\Preflight\YoastSEO\Checkers\DevelopmentMode;
use Mockery;
use WP_Mock;

class DevelopmentModeTest extends Unit
{
    use AbstractCheckerTestTrail;

    /**
     * @var \Itineris\Preflight\YoastSEO\Test\UnitTester
     */
    protected $tester;

    public function testErrorIfMethodNotExists()
    {
        WP_Mock::userFunction('Itineris\Preflight\YoastSEO\Checkers\method_exists')
               ->with('WPSEO_Utils', 'is_development_mode')
               ->andReturnFalse()
               ->once();

        $checker = new DevelopmentMode();

        $actual = $checker->check(
            new Config([])
        );

        $expected = ResultFactory::makeError($checker, 'WPSEO_Utils::is_development_mode method not exist');
        $this->assertEquals($expected, $actual);
    }

    public function testSuccess()
    {
        WP_Mock::userFunction('Itineris\Preflight\YoastSEO\Checkers\method_exists')
               ->with('WPSEO_Utils', 'is_development_mode')
               ->andReturnTrue()
               ->once();

        Mockery::mock('alias:WPSEO_Utils')
               ->expects('is_development_mode')
               ->withNoArgs()
               ->andReturnFalse()
               ->once();

        $checker = new DevelopmentMode();

        $result = $checker->check(
            new Config([])
        );

        $this->assertInstanceOf(Success::class, $result);
    }

    public function testFailure()
    {
        WP_Mock::userFunction('Itineris\Preflight\YoastSEO\Checkers\method_exists')
               ->with('WPSEO_Utils', 'is_development_mode')
               ->andReturnTrue()
               ->once();

        Mockery::mock('alias:WPSEO_Utils')
               ->expects('is_development_mode')
               ->withNoArgs()
               ->andReturnTrue()
               ->once();

        $checker = new DevelopmentMode();

        $actual = $checker->check(
            new Config([])
        );

        $expected = ResultFactory::makeFailure($checker, 'Yoast SEO is in development mode');

        $this->assertEquals($expected, $actual);
    }

    protected function getSubject(): AbstractChecker
    {
        return new DevelopmentMode();
    }
}
