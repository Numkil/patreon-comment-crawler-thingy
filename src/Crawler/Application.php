<?php

namespace Crawler;

use Cilex\Provider\Console\ContainerAwareApplication as BaseApplication;

/**
 * Class Application
 * @package Crawler
 */
class Application extends BaseApplication
{

    const VERSION = '@app_version@';

    public static $logo = 'crawler';

    public function __construct($name = 'UNKNOWN', $version = 'UNKNOWN')
    {
        parent::__construct('crawler', self::VERSION);
    }

    public function getHelp()
    {
        return self::$logo . parent::getHelp();
    }

}