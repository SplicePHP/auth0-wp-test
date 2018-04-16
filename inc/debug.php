<?php
if (WP_DEBUG) {

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  /**
   * Get all the URL parameters
   *
   * @param $url
   *
   * @return array
   */
  function wp_url_paramz($url)
  {
    $query = explode('&', parse_url($url)['query']);
    $params = [];
    foreach ($query as $quer) {
      $params[explode('=', $quer)[0]] = explode('=', $quer)[1];
    }
    return $params;
  }

  function wp_a0_arr_dump($thing = 'not a thing')
  {
    echo '<pre>' . print_r($thing, TRUE) . '</pre>';
  }

  /**
   * Output all user meta
   *
   * @param int $uid
   */
  function wp_a0_usermeta($uid = 1)
  {
    echo '<pre>' . print_r(get_user_meta($uid), TRUE) . '</pre>';
    die();
  }

  /**
   * Output all options
   */
  function wp_a0_opts()
  {
    $opts = get_option('wp_auth0_settings');
    if (extension_loaded('xdebug')) {
      var_dump($opts);
    } else {
      wp_a0_arr_dump($opts);
    }
  }

  /**
   * Output an option
   *
   * wp_a0_opt( 'auth0_app_token' )
   */
  function wp_a0_opt($key)
  {
    return WP_Auth0_Options::Instance()->get($key);
  }

  /**
   * Set an option
   *
   * wp_a0_set_opt( 'passwordless_cdn_url', '//cdn.auth0.com/js/lock/11.3/lock.min.js' );
   * wp_a0_set_opt( 'passwordless_cdn_url', '//wp.localhost.test/lock.11.3.min.js' );
   */
  function wp_a0_set_opt($key, $val)
  {
    $opts = get_option('wp_auth0_settings');
    $opts[$key] = $val;
    update_option('wp_auth0_settings', $opts);
  }

  /**
   * Output stored token value
   */
  function wp_a0_token()
  {

    echo 'Starting...<hr>';
    $opts = WP_Auth0_Options::Instance();
    $token = $opts->get('auth0_app_token');
    echo $token . '<hr>';
    $secret = $opts->get('client_secret');
    echo $secret . '<hr>';
    echo '<pre>' . print_r(JWT::decode($token, $opts->get_client_secret_as_key(), array(
        $opts->get_client_signing_algorithm()
      )), TRUE) . '</pre>';
    die();
  }

  add_action('init', function () {

    // Auto-update the CDN URL
    if (isset($_GET['update_cdn'])) {
      if (current_user_can('manage_options')) {
        $cdn_url = empty($_GET['update_cdn']) ? '//cdn.auth0.com/js/lock/11.5/lock.min.js' : $_GET['update_cdn'];
        wp_a0_set_opt('cdn_url', $cdn_url);
        wp_a0_set_opt('passwordless_cdn_url', $cdn_url);
      }
    }

    // Do a specific DB migration
    if (!empty($_GET['do_migration'])) {
      if (current_user_can('manage_options')) {
        $migration_version = absint($_GET['do_migration']);
        echo 'Starting migration for v' . $migration_version . '<br>';
        $db_manager = new WP_Auth0_DBManager(WP_Auth0_Options::Instance());
        $db_manager->init();
        $db_manager->install_db(absint($_GET['do_migration']), '');
        echo 'Migration for v' . $migration_version . ' complete!';
      }
    }
  });
}