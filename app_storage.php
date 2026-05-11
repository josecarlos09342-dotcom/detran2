<?php
define('APP_STORAGE_DIR', sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'vercel-php-app');

function app_storage_seed_map() {
    return [
        'admin_ips.json' => "[]\n",
        'click_stats.json' => "{\n    \"consultar_clicks\": 0,\n    \"enter_clicks\": 0\n}\n",
        'consultados_log.json' => "[]\n",
        'pix_config.json' => "{}\n",
        'pix_config_admin.json' => "{}\n",
        'pix_last.json' => "[]\n",
        'pix_log.json' => "[]\n",
        'pix_log_oculto.json' => "[]\n",
        'pix_mode.txt' => "desativo\n",
        'search_log.json' => "[]\n",
        'stats.json' => "{\"index_clicks2\":0,\"pix_generated\":0}\n",
    ];
}

function app_storage_bootstrap() {
    static $bootstrapped = false;

    if ($bootstrapped) {
        return;
    }

    $bootstrapped = true;

    if (!is_dir(APP_STORAGE_DIR)) {
        @mkdir(APP_STORAGE_DIR, 0777, true);
    }

    foreach (app_storage_seed_map() as $file => $defaultContent) {
        $target = APP_STORAGE_DIR . DIRECTORY_SEPARATOR . $file;

        if (is_file($target)) {
            continue;
        }

        $source = __DIR__ . DIRECTORY_SEPARATOR . $file;

        if (is_file($source)) {
            @copy($source, $target);
            continue;
        }

        @file_put_contents($target, $defaultContent);
    }
}

function app_storage_path($file) {
    app_storage_bootstrap();

    return APP_STORAGE_DIR . DIRECTORY_SEPARATOR . basename($file);
}
