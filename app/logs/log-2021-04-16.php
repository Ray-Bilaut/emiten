<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-04-16 19:50:13 --> $config['composer_autoload'] is set to TRUE but E:\xampp\htdocs\new_emiten\app\vendor/autoload.php was not found.
ERROR - 2021-04-16 19:50:13 --> Severity: error --> Exception: Class 'Dotenv\Dotenv' not found E:\xampp\htdocs\new_emiten\app\config\hooks.php 15
ERROR - 2021-04-16 19:50:44 --> $config['composer_autoload'] is set to TRUE but E:\xampp\htdocs\new_emiten\app\vendor/autoload.php was not found.
ERROR - 2021-04-16 19:50:44 --> Severity: error --> Exception: Class 'Dotenv\Dotenv' not found E:\xampp\htdocs\new_emiten\app\config\hooks.php 15
ERROR - 2021-04-16 19:50:45 --> $config['composer_autoload'] is set to TRUE but E:\xampp\htdocs\new_emiten\app\vendor/autoload.php was not found.
ERROR - 2021-04-16 19:50:45 --> Severity: error --> Exception: Class 'Dotenv\Dotenv' not found E:\xampp\htdocs\new_emiten\app\config\hooks.php 15
ERROR - 2021-04-16 19:53:31 --> $config['composer_autoload'] is set to TRUE but E:\xampp\htdocs\new_emiten\app\vendor/autoload.php was not found.
ERROR - 2021-04-16 19:53:31 --> Severity: error --> Exception: Class 'Dotenv\Dotenv' not found E:\xampp\htdocs\new_emiten\app\config\hooks.php 15
ERROR - 2021-04-16 19:53:31 --> $config['composer_autoload'] is set to TRUE but E:\xampp\htdocs\new_emiten\app\vendor/autoload.php was not found.
ERROR - 2021-04-16 19:53:31 --> Severity: error --> Exception: Class 'Dotenv\Dotenv' not found E:\xampp\htdocs\new_emiten\app\config\hooks.php 15
ERROR - 2021-04-16 19:53:32 --> $config['composer_autoload'] is set to TRUE but E:\xampp\htdocs\new_emiten\app\vendor/autoload.php was not found.
ERROR - 2021-04-16 19:53:32 --> Severity: error --> Exception: Class 'Dotenv\Dotenv' not found E:\xampp\htdocs\new_emiten\app\config\hooks.php 15
ERROR - 2021-04-16 19:59:07 --> Severity: Warning --> mysqli::query(): MySQL server has gone away E:\xampp\htdocs\new_emiten\sys\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2021-04-16 19:59:07 --> Severity: Warning --> mysqli::query(): Error reading result set's header E:\xampp\htdocs\new_emiten\sys\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2021-04-16 19:59:07 --> Query error: MySQL server has gone away - Invalid query: SELECT p.id AS podcast_id, t.title AS tag_title, t.slug_url AS tag_url
      FROM em_tag t
      JOIN em_tag_relation tr
      ON t.id = tr.tag_id
      JOIN 
      (
        SELECT id
        FROM em_podcast
        WHERE is_active = 1 AND is_delete = 0 AND publish_date <= "2021-04-16 19:59:05"
        ORDER BY publish_date DESC LIMIT 0,10
      ) p
      ON p.id = tr.podcast_id
      WHERE tr.podcast_id <> 0
ERROR - 2021-04-16 19:59:07 --> Query error: MySQL server has gone away - Invalid query: INSERT INTO `em_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('uev2mg0rbv6tb9i9l59qe9g00bst1kht', '::1', 1618577947, '__ci_last_regenerate|i:1618577942;visitorsession|s:32:\"4d97664f0aa26544d7c29a832847845e\";__ci_vars|a:1:{s:14:\"visitorsession\";i:1618579742;}')
ERROR - 2021-04-16 19:59:07 --> Severity: Warning --> Unknown: Cannot call session save handler in a recursive manner Unknown 0
ERROR - 2021-04-16 19:59:07 --> Severity: Warning --> Unknown: Failed to write session data using user defined save handler. (session.save_path: E:\xampp\tmp) Unknown 0
ERROR - 2021-04-16 19:59:07 --> Query error: MySQL server has gone away - Invalid query: SELECT RELEASE_LOCK('7954619efcab7bc9111b4b4028140c53') AS ci_session_lock
ERROR - 2021-04-16 19:59:07 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at E:\xampp\htdocs\new_emiten\sys\database\DB_driver.php:1782) E:\xampp\htdocs\new_emiten\sys\core\Common.php 570
ERROR - 2021-04-16 20:03:11 --> Severity: Warning --> mysqli::query(): MySQL server has gone away E:\xampp\htdocs\new_emiten\sys\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2021-04-16 20:03:11 --> Severity: Warning --> mysqli::query(): Error reading result set's header E:\xampp\htdocs\new_emiten\sys\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2021-04-16 20:03:11 --> Query error: MySQL server has gone away - Invalid query: SELECT GET_LOCK('7954619efcab7bc9111b4b4028140c53', 300) AS ci_session_lock
ERROR - 2021-04-16 20:03:11 --> Severity: Warning --> session_write_close(): Cannot call session save handler in a recursive manner Unknown 0
ERROR - 2021-04-16 20:03:11 --> Severity: Warning --> session_write_close(): Failed to write session data using user defined save handler. (session.save_path: E:\xampp\tmp) Unknown 0
ERROR - 2021-04-16 22:45:04 --> Severity: Notice --> Undefined variable: subscribe_bottom E:\xampp\htdocs\new_emiten\app\views\frontend\master.php 245
ERROR - 2021-04-16 22:46:06 --> Severity: Notice --> Undefined variable: subscribe_bottom E:\xampp\htdocs\new_emiten\app\views\frontend\master.php 245
ERROR - 2021-04-16 23:04:10 --> Severity: Notice --> Undefined variable: subscribe_bottom E:\xampp\htdocs\new_emiten\app\views\frontend\master.php 245
ERROR - 2021-04-16 23:10:07 --> Severity: Notice --> Undefined variable: topAds E:\xampp\htdocs\new_emiten\app\views\frontend\home_index.php 473
ERROR - 2021-04-16 23:10:07 --> Severity: Notice --> Trying to get property 'image_url' of non-object E:\xampp\htdocs\new_emiten\app\views\frontend\home_index.php 473
ERROR - 2021-04-16 23:10:07 --> Severity: Notice --> Undefined variable: topAds E:\xampp\htdocs\new_emiten\app\views\frontend\home_index.php 473
ERROR - 2021-04-16 23:10:07 --> Severity: Notice --> Trying to get property 'title' of non-object E:\xampp\htdocs\new_emiten\app\views\frontend\home_index.php 473
ERROR - 2021-04-16 23:22:11 --> Severity: Notice --> Undefined variable: subscribe_bottom E:\xampp\htdocs\new_emiten\app\views\frontend\master.php 245
ERROR - 2021-04-16 23:27:25 --> Severity: Notice --> Undefined variable: subscribe_bottom E:\xampp\htdocs\new_emiten\app\views\frontend\master.php 246
ERROR - 2021-04-16 23:27:37 --> Severity: Notice --> Undefined variable: subscribe_bottom E:\xampp\htdocs\new_emiten\app\views\frontend\master.php 246
ERROR - 2021-04-16 23:27:52 --> Severity: Notice --> Undefined variable: subscribe_bottom E:\xampp\htdocs\new_emiten\app\views\frontend\master.php 246
ERROR - 2021-04-16 23:31:25 --> Severity: Notice --> Undefined variable: subscribe_bottom E:\xampp\htdocs\new_emiten\app\views\frontend\master.php 246
