<?php

return array(
    'columns' => 12,

    // Callback to generate the list of available displays
    'available' => function() {
        return array_filter(array(
            // Get default displays
            'default' => \Config::load('novius_blocks::displays', true),
            // Get custom displays
            'custom' => \Novius\Blocks\Model_Display::find('all'),
        ));
    }
);
