<?php
declare(strict_types=1);

namespace Itineris\Preflight\YoastSEO;

use Itineris\Preflight\CheckerCollectionFactory;
use Itineris\Preflight\YoastSEO\Checkers\DevelopmentMode;
use WP_CLI;

class PreflightYoastSEO
{
    private const CHECKERS = [
        DevelopmentMode::class,
    ];

    /**
     * Begin package execution.
     */
    public static function run(): void
    {
        foreach (self::CHECKERS as $checker) {
            WP_CLI::add_wp_hook(CheckerCollectionFactory::REGISTER_HOOK, [$checker, 'register']);
        }
    }
}
