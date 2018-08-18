<?php
declare(strict_types=1);

namespace Itineris\Preflight\YoastSEO\Checkers;

use Itineris\Preflight\Checkers\AbstractChecker;
use Itineris\Preflight\Config;
use Itineris\Preflight\ResultFactory;
use Itineris\Preflight\ResultInterface;
use WPSEO_Utils;

class DevelopmentMode extends AbstractChecker
{
    public const ID = 'yoast-seo-development-mode';
    public const DESCRIPTION = 'Ensure Yoast SEO is not in development mode.';

    /**
     * Run the check and return a result.
     *
     * Assume the checker is enabled and its config make sense.
     *
     * @param Config $config The config instance.
     *
     * @return ResultInterface
     */
    protected function run(Config $config): ResultInterface
    {
        if (! method_exists('WPSEO_Utils', 'is_development_mode')) {
            return ResultFactory::makeError($this, 'WPSEO_Utils::is_development_mode method not exist');
        }

        return WPSEO_Utils::is_development_mode()
            ? ResultFactory::makeFailure($this, 'Yoast SEO is in development mode')
            : ResultFactory::makeSuccess($this);
    }
}
