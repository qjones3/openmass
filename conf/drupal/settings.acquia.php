<?php

$databases = array();

$settings['hash_salt'] = '${drupal.hash_salt}';
$settings['update_free_access'] = FALSE;
$settings['container_yamls'][] = __DIR__ . '/services.yml';

$settings['file_public_path'] = '${drupal.settings.file_public_path}';
$settings['file_private_path'] = '${drupal.settings.file_private_path}';

$settings['trusted_host_patterns'] = array(
  '^${acquia.accountname}dev.prod.acquia-sites.com',
  '^${acquia.accountname}stg.prod.acquia-sites.com',
  '^${acquia.accountname}cd.prod.acquia-sites.com',
  '^pilot\.mass\.gov$',
);

// Include the Acquia database connection and other config.
if (file_exists('/var/www/site-php')) {
  require '/var/www/site-php/${acquia.accountname}/${acquia.accountname}-settings.inc';
}

// Use our own config sync directory.
$config_directories = array();
$config_directories[CONFIG_SYNC_DIRECTORY] = '${drupal.config_sync_directory}';

//// Add an htaccess prompt on dev.
//// @see https://docs.acquia.com/articles/password-protect-your-non-production-environments-acquia-hosting#phpfpm

// Make sure Drush keeps working.
// Modified from function drush_verify_cli()
$cli = (php_sapi_name() == 'cli');

// PASSWORD-PROTECT NON-PRODUCTION SITES (i.e. staging/dev)
if (!$cli && (isset($_ENV['AH_NON_PRODUCTION']) && $_ENV['AH_NON_PRODUCTION'])) {
  $username = 'massgov';
  $password = 'for the commonwealth';
  if (!(isset($_SERVER['PHP_AUTH_USER']) && ($_SERVER['PHP_AUTH_USER']==$username && $_SERVER['PHP_AUTH_PW']==$password))) {
    header('WWW-Authenticate: Basic realm="This site is protected"');
    header('HTTP/1.0 401 Unauthorized');
    // Fallback message when the user presses cancel / escape
    echo 'Access denied';
    exit;
  }
}

// Set variable to indicate if we are in "Edit Domain".
// @see https://kbv2.acquia.com/articles/best-practices-setting-edit-domain
$forwarded_host = (empty($_SERVER['HTTP_X_FORWARDED_HOST'])) ? $_SERVER['HTTP_HOST'] : $_SERVER['HTTP_X_FORWARDED_HOST'];
$config['is_edit_domain'] = (strpos($forwarded_host, 'edit') !== FALSE) ? TRUE : FALSE;
