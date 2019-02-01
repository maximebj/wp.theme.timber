<?php

namespace DysignTheme;

use DysignTheme\Core\Config;
use DysignTheme\Core\CPT;
use DysignTheme\Core\Features;
use DysignTheme\Core\ACF;
use DysignTheme\Core\Ajax;
use DysignTheme\Core\Plugins;
use DysignTheme\Core\API;
use DysignTheme\Core\Timber;

require_once(__DIR__ . '/vendor/autoload.php');
$timber = new \Timber\Timber();

class DysignTheme {

  public function run() {

    include get_template_directory() . '/core/config.php';
    include get_template_directory() . '/core/cpt.php';
    include get_template_directory() . '/core/features.php';
    include get_template_directory() . '/core/acf.php';
    include get_template_directory() . '/core/ajax.php';
    include get_template_directory() . '/core/plugins.php';
    include get_template_directory() . '/core/api.php';
    include get_template_directory() . '/core/timber.php';

    ( new Config )->execute();
    ( new CPT )->execute();
    ( new Features )->execute();
    ( new ACF )->execute();
    ( new Ajax )->execute();
    ( new Plugins )->execute();
    ( new API )->execute();
    ( new Timber )->execute();

  }
}

( new DysignTheme )->run();