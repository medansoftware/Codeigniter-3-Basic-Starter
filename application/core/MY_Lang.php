<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package Codeigniter
 * @subpackage Language
 * @category Libraries
 * @author Agung Dirgantara <agungmasda29@gmail.com>
 */

class MY_Lang extends HMVC_Lang
{
	/**
	 * Refactor: base language provided inside system/language
	 *
	 * @var string
	 */
	public $base_language;

	public $current_language;

	public $language_file_content = array();

	public $languages_path;

	public function __construct()
	{
		parent::__construct();

		$this->base_language = config_item('language');
		$this->current_language = array_key_exists('language', $_COOKIE)?$_COOKIE['language']:$this->base_language;
		$this->languages_path = FCPATH.'public/assets/languages';
	}

	/**
	 * Languages path
	 *
	 * @param      string  $path   Path to languages JSON files
	 */
	public function set_languages_path($path)
	{
		if (is_dir($this->languages_path))
		{
			$this->languages_path = $path;
		}
	}

	/**
	 * Get base language
	 *
	 * @return string
	 */
	public function get_base_language()
	{
		return $this->base_language;
	}

	/**
	 * Set current language
	 *
	 * @param string $language
	 */
	public function set_current_language($language = '')
	{
		if (in_array($language, $this->available_languages()))
		{
			$this->current_language = $language;
		}
		elseif (in_array($language, $this->system_languages()))
		{
			$this->current_language = $language;
		}
		else
		{
			$this->current_language = $this->base_language;
		}

		// set cookie language
		get_instance()->input->set_cookie(array(
			'name'   => 'language',
			'value'  => $this->current_language,
			'expire' => 86400,
			'path'   => '/',
			'secure' => FALSE
		));
	}

	/**
	 * Get current language
	 *
	 * @return string
	 */
	public function get_current_language()
	{
		$set_language = get_instance()->input->get('language');
		if (!empty($set_language))
		{
			$this->set_current_language($set_language);
		}

		return $this->current_language;
	}

	/**
	 * Valid JSON
	 *
	 * @return string
	 */
	public function valid_json($json)
	{
		json_decode($json);
		return (json_last_error() == JSON_ERROR_NONE);
	}

	// --------------------------------------------------------------------

	/**
	 * Load a language file, with fallback to english.
	 *
	 * @param	mixed	$langfile	Language file name
	 * @param	string	$idiom		Language name (english, etc.)
	 * @param	bool	$return		Whether to return the loaded array of translations
	 * @param 	bool	$add_suffix	Whether to add suffix to $langfile
	 * @param 	string	$alt_path	Alternative path to look for the language file
	 * @return	void|string[]	Array containing translations, if $return is set to TRUE
	 */
	public function load($langfile, $idiom = '', $return = FALSE, $add_suffix = TRUE, $alt_path = '', $_module = '')
	{
		$original_file_name = $langfile;

		if (is_array($langfile))
		{
			foreach ($langfile as $file)
			{
				$this->load($file);
			}

			return;
		}

		if (empty($idiom))
		{
			$idiom = $this->get_current_language();
		}

		$_module OR $_module = get_instance()->router->fetch_module();

		list($path, $langfile) = Modules::find($langfile.'_lang', $_module, 'language/'.$idiom.'/');

		if ($path === FALSE)
		{
			$langfile = str_replace('.php', '', $langfile);

			if ($add_suffix === TRUE)
			{
				$langfile = preg_replace('/_lang$/', '', $langfile) . '_lang';
			}

			$langfile .= '.php';

			if (empty($idiom) OR ! preg_match('/^[a-z_-]+$/i', $idiom))
			{
				$config = & get_config();
				$idiom = empty($config['language']) ? $this->base_language : $config['language'];
			}

			if ($return === FALSE && isset($this->is_loaded[$langfile]) && $this->is_loaded[$langfile] === $idiom)
			{
				return;
			}

			// load the default language first, if necessary
			// only do this for the language files under system/
			$basepath = SYSDIR . 'language/' . $this->base_language . '/' . $langfile;

			if (($found = file_exists($basepath)) === TRUE)
			{
				include($basepath);
			}

			// Load the base file, so any others found can override it
			$basepath = BASEPATH . 'language/' . $idiom . '/' . $langfile;

			if (($found = file_exists($basepath)) === TRUE)
			{
				include($basepath);
			}

			// Do we have an alternative path to look in?
			if ($alt_path !== '')
			{
				$alt_path .= 'language/' . $idiom . '/' . $langfile;
				if (file_exists($alt_path))
				{
					include($alt_path);
					$found = TRUE;
				}
			}
			else
			{
				foreach (get_instance()->load->get_package_paths(TRUE) as $package_path)
				{
					$language_path = $package_path.'language/' . $idiom . '/' . $langfile;
					if ($basepath !== $language_path && file_exists($language_path))
					{
						include($language_path);
						$found = TRUE;
						break;
					}
					else
					{
						if (file_exists($package_path.'language/' . $this->base_language . '/' . $langfile))
						{
							include($package_path.'language/' . $this->base_language . '/' . $langfile);
							$found = TRUE;
							$idiom = $this->base_language;
							log_message('info', 'Language file loaded: language/' . $idiom . '/' . $langfile.' - using default language:'.$this->base_language);
							break;
						}
					}
				}
			}

			if ($found !== TRUE)
			{
				// langfile with slash?
				if (is_array(explode('/', $original_file_name)))
				{
					$langfile = $original_file_name.'.json';
					$_module OR $_module = get_instance()->router->fetch_module();

					list($module_current_lang, $file) = Modules::find($langfile, $_module, 'languages/'.$idiom.'/');
					list($module_default_lang, $file) = Modules::find($langfile, $_module, 'languages/'.$this->base_language.'/');

					// check JSON language file in assets path by current language
					if (file_exists($this->languages_path.DIRECTORY_SEPARATOR.$idiom.'/'.$langfile))
					{
						$found = TRUE;
						$idiom = $idiom;

						if ($this->valid_json(file_get_contents($this->languages_path.DIRECTORY_SEPARATOR.$idiom.'/'.$langfile)))
						{
							foreach (json_decode(file_get_contents($this->languages_path.DIRECTORY_SEPARATOR.$idiom.'/'.$langfile)) as $key => $value)
							{
								$lang[$key] = $value;
							}
						}

						$this->language_file_content[$langfile][$idiom] = $lang;
					}
					// check JSON language file in assets path by default language
					elseif (file_exists($this->languages_path.DIRECTORY_SEPARATOR.$this->base_language.'/'.$langfile))
					{
						$found = TRUE;
						$idiom = $this->base_language;

						if ($this->valid_json(file_get_contents($this->languages_path.DIRECTORY_SEPARATOR.$idiom.'/'.$langfile)))
						{
							foreach (json_decode(file_get_contents($this->languages_path.DIRECTORY_SEPARATOR.$idiom.'/'.$langfile)) as $key => $value)
							{
								$lang[$key] = $value;
							}
						}

						$this->language_file_content[$langfile][$idiom] = $lang;
					}
					// Check JSON file in current module by current language
					elseif ($module_current_lang !== FALSE)
					{
						$found = TRUE;

						if ($this->valid_json(file_get_contents($module_current_lang.$file)))
						{
							foreach (json_decode(file_get_contents($module_current_lang.$file)) as $key => $value)
							{
								$lang[$key] = $value;
							}
						}

						$this->language_file_content[$langfile][$idiom] = $lang;
					}
					// Check JSON file in current module by default language
					elseif ($module_default_lang !== FALSE)
					{
						$found = TRUE;
						$idiom = $this->base_language;

						if ($this->valid_json(file_get_contents($module_default_lang.$file)))
						{
							foreach (json_decode(file_get_contents($module_default_lang.$file)) as $key => $value)
							{
								$lang[$key] = $value;
							}
						}

						$this->language_file_content[$langfile][$idiom] = $lang;
					}
					else
					{
						log_message('error', 'Unable to load the requested language file: languages/' . $idiom . '/' . $langfile);
					}
				}
				else
				{
					$langfile = str_replace(['_lang', '.php'], ['','.json'], $langfile);

					$_module OR $_module = get_instance()->router->fetch_module();
					list($module_current_lang, $langfile) = Modules::find($langfile, $_module, 'languages/'.$idiom.'/');
					list($module_default_lang, $langfile) = Modules::find($langfile, $_module, 'languages/'.$this->base_language.'/');

					// check JSON language file in assets path by current language
					if (file_exists($this->languages_path.DIRECTORY_SEPARATOR.$idiom.'/'.$langfile))
					{
						$found = TRUE;

						if ($this->valid_json(file_get_contents($this->languages_path.DIRECTORY_SEPARATOR.$idiom.'/'.$langfile)))
						{
							foreach (json_decode(file_get_contents($this->languages_path.DIRECTORY_SEPARATOR.$idiom.'/'.$langfile)) as $key => $value)
							{
								$lang[$key] = $value;
							}
						}

						$this->language_file_content[$langfile][$idiom] = $lang;
					}
					// check JSON language file in assets path by default language
					elseif (file_exists($this->languages_path.DIRECTORY_SEPARATOR.$this->base_language.'/'.$langfile))
					{
						$found = TRUE;
						$idiom = $this->base_language;

						if ($this->valid_json(file_get_contents($this->languages_path.DIRECTORY_SEPARATOR.$idiom.'/'.$langfile)))
						{
							foreach (json_decode(file_get_contents($this->languages_path.DIRECTORY_SEPARATOR.$idiom.'/'.$langfile)) as $key => $value)
							{
								$lang[$key] = $value;
							}
						}

						$this->language_file_content[$langfile][$idiom] = $lang;
					}
					// check JSON language file in module path by current language
					elseif ($module_current_lang !== FALSE)
					{
						$found = TRUE;

						if ($this->valid_json(file_get_contents($module_current_lang.$langfile)))
						{
							foreach (json_decode(file_get_contents($module_current_lang.$langfile)) as $key => $value)
							{
								$lang[$key] = $value;
							}
						}

						$this->language_file_content[$langfile][$idiom] = $lang;
					}
					// check JSON language file in module path by default language
					elseif ($module_default_lang !== FALSE)
					{
						$found = TRUE;
						$idiom = $this->base_language;

						if ($this->valid_json(file_get_contents($module_default_lang.$langfile)))
						{
							foreach (json_decode(file_get_contents($module_default_lang.$langfile)) as $key => $value)
							{
								$lang[$key] = $value;
							}
						}

						$this->language_file_content[$langfile][$idiom] = $lang;
					}
					else
					{
						log_message('error', 'Unable to load the requested language file: languages/' . $idiom . '/' . $langfile);
					}
				}
			}

			if (!isset($lang) OR ! is_array($lang))
			{
				if ($found)
				{
					log_message('error', 'Language file contains no data: languages/' . $idiom . '/' . $langfile);
				}

				if ($return === TRUE)
				{
					return array();
				}

				return;
			}

			if ($return === TRUE)
			{
				return $lang;
			}

			$this->is_loaded[$langfile] = $idiom;
			$this->language = array_merge($this->language, $lang);

			log_message('info', 'Language file loaded: languages/' . $idiom . '/' . $langfile);
			return TRUE;
		}
		else
		{
			if ($lang = Modules::load_file($langfile, $path, 'lang'))
			{
				if ($return) return $lang;
				$this->language = array_merge($this->language, $lang);
				$this->is_loaded[$langfile.EXT] = $idiom;
				unset($lang);
			}
		}

		return $this->language;
	}

	/**
	 * Language line
	 *
	 * Fetches a single line of text from the language array
	 *
	 * @param	string	$line		Language line key
	 * @param	bool	$log_errors	Whether to log an error message if the line is not found
	 * @return	string	Translation
	 */
	public function line($line, $log_errors = TRUE)
	{
		$value = isset($this->language[$line]) ? $this->language[$line] : FALSE;

		if ($value === FALSE)
		{
			$loaded_files = array_map(function($file) {
				return str_replace(['.php', '.json'], '', $file);
			}, array_keys($this->is_loaded));

			$languages = array();

			foreach ($loaded_files as $file)
			{
				$languages_file = $this->load($file, $this->base_language, TRUE);
				$languages = array_merge($languages, $languages_file);

				if (isset($languages_file[$line]))
				{
					// found key on file
					if ($log_errors)
					{
						log_message('error', 'Could not find the language line "'.$line.'" in file "'.$file.'" for "'.$this->current_language.'" language');
					}
				}
			}

			$value = isset($languages[$line]) ? $languages[$line] : FALSE;
		}

		// Because killer robots like unicorns!
		if ($value === FALSE && $log_errors === TRUE)
		{
			log_message('error', 'Could not find the language line "'.$line.'"');
		}

		return $value;
	}

	/**
	 * System languages
	 *
	 * @return array
	 */
	public function system_languages()
	{
		get_instance()->load->helper('directory');
		return array_merge(array_values(array_filter(array_map(function($language){
			return rtrim(stripslashes($language), '/');
		}, array_keys(directory_map(BASEPATH.'language'))))));
	}

	/**
	 * Available languages
	 *
	 * @return array
	 */
	public function available_languages()
	{
		if (is_dir($this->languages_path))
		{
			get_instance()->load->helper('directory');
			return array_values(array_filter(array_map(function($language){
				return rtrim(stripslashes($language), '/');
			}, array_keys(directory_map($this->languages_path)))));
		}

		return FALSE;
	}
}

/* End of file MY_Lang.php */
/* Location : ./application/core/MY_Lang.php */
