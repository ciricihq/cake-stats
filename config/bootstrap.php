<?php

use Cake\Core\Configure;

/**
 * Stats's default configuration.
 */
Configure::write('Stats', [
    'singular_models' => false
]);

if (file_exists(CONFIG . 'stats.php')) {
    Configure::load('stats');
}
