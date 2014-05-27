<?php

namespace Novius\Blocks;

use Fuel\Core\Format;

class Display {

    public static function available() {
        return array_filter(array(
            // Get configured displays
            'views' => \Config::load('novius_blocks::displays', true),
            // Get user created displays
            'model' => \Novius\Blocks\Model_Display::find('all'),
        ));
    }
}
