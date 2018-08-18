<?php
declare(strict_types=1);

use Itineris\Preflight\YoastSEO\PreflightYoastSEO;

if (! class_exists('WP_CLI')) {
    return;
}

PreflightYoastSEO::run();
