<?php

/**
 * A base class for extension that implements the PHPCouch Registry interface.
 *
 * @package    PHPCouch
 *
 * @author     David Zülke <dz@bitxtender.com>
 * @copyright  bitXtender GbR
 *
 * @since      1.0.0
 *
 * @version    $Id$
 */
abstract class PhpcouchConfigurable implements PhpcouchIRegistry
{
	/**
	 * @var        array An array of configuration options set on this object.
	 */
	protected $options = array();
	
	/**
	 * @var        array An array of configuration options that are read-only.
	 */
	protected $readonlies = array();
	
	/**
	 * Get a configuration value.
	 *
	 * @param      string The name of the configuration directive.
	 *
	 * @return     mixed The value of the directive, or null if not set.
	 *
	 * @author     David Zülke <dz@bitxtender.com>
	 * @since      1.0.0
	 */
	public function getOption($name, $default = null)
	{
		if(isset(self::$options[$name])) {
			return self::$options[$name];
		} else {
			return $default;
		}
	}

	/**
	 * Check if a configuration directive has been set.
	 *
	 * @param      string The name of the configuration directive.
	 *
	 * @return     bool Whether the directive was set.
	 *
	 * @author     David Zülke <dz@bitxtender.com>
	 * @since      1.0.0
	 */
	public function hasOption($name)
	{
		return isset(self::$options[$name]);
	}

	/**
	 * Check if a configuration directive has been set as read-only.
	 *
	 * @param      string The name of the configuration directive.
	 *
	 * @return     bool Whether the directive is read-only.
	 *
	 * @author     David Zülke <dz@bitxtender.com>
	 * @since      1.0.0
	 */
	public function isOptionReadonly($name)
	{
		return isset(self::$readonlies[$name]);
	}

	/**
	 * Set a configuration value.
	 *
	 * @param      string The name of the configuration directive.
	 * @param      mixed  The configuration value.
	 * @param      bool   Whether or not an existing value should be overwritten.
	 * @param      bool   Whether or not this value should be read-only once set.
	 *
	 * @return     bool   Whether or not the configuration directive has been set.
	 *
	 * @author     David Zülke <dz@bitxtender.com>
	 * @since      1.0.0
	 */
	public function setOption($name, $value, $overwrite = true, $readonly = false)
	{
		$retval = false;
		if(($overwrite || !isset(self::$options[$name])) && !isset(self::$readonlies[$name])) {
			self::$options[$name] = $value;
			if($readonly) {
				self::$readonlies[$name] = $value;
			}
			$retval = true;
		}
		return $retval;
	}

	/**
	 * Remove a configuration value.
	 *
	 * @param      string The name of the configuration directive.
	 *
	 * @return     bool true, if removed successfuly, false otherwise.
	 *
	 * @author     David Zülke <dz@bitxtender.com>
	 * @since      1.0.0
	 */
	public function removeOption($name)
	{
		$retval = false;
		if(isset(self::$options[$name]) && !isset(self::$readonlies[$name])) {
			unset(self::$options[$name]);
			$retval = true;
		}
		return $retval;
	}

	/**
	 * Import a list of configuration directives.
	 *
	 * @param      string An array of configuration directives.
	 *
	 * @author     David Zülke <dz@bitxtender.com>
	 * @since      1.0.0
	 */
	public function setOptions($data)
	{
		self::$options = array_merge(array_merge(self::$options, $data), self::$readonlies);
	}

	/**
	 * Get all configuration directives and values.
	 *
	 * @return     array An associative array of configuration values.
	 *
	 * @author     David Zülke <dz@bitxtender.com>
	 * @since      1.0.0
	 */
	public function getOptions()
	{
		return self::$options;
	}

	/**
	 * Clear the configuration.
	 *
	 * @author     David Zülke <dz@bitxtender.com>
	 * @since      1.0.0
	 */
	public function clearOptions()
	{
		$restore = array_intersect_assoc(self::$readonlies, self::$options);
		self::$options = $restore;
	}
}

?>