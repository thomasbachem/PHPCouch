<?php
/**
 * A base class for extension that implements the PHPCouch Registry interface.
 *
 * @package    PHPCouch
 * @subpackage Tests
 *
 * @author     Simon Thulbourn <simon+github@thulbourn.com>
 * @copyright  authors
 *
 * @since      1.0.0
 */

use phpcouch\Phpcouch;
use phpcouch\Exception;
use phpcouch\connection;
use phpcouch\adapter;

error_reporting(E_ALL | E_STRICT);

require '../lib/phpcouch/Phpcouch.php';

?>