<?php
	echo "sub";	echo "sub";	echo "sub";	class Autoloader{
		private static $appPath = '';
		private static $classMap= [];
		private static $autoloadPath = [
			'application.*',
	        'application.lib.*',
	        'application.Controllers.*',
	        'application.lib.Components.Common.*',
	        'application.lib.Components.Debug.*',
	        'application.lib.Components.Curl.*',
	        'application.lib.Components.Message.*',
	        'application.lib.Components.View.*',
	        'application.lib.Extends.*',
	        'application.Models.*',
	        'application.lib.modules.payment.*',
		];

		//类包含路径
		private static $includeClassPath = [];

		//处理自动加载路径
		private static function setIncludePath() {
			$autoloadPath = self::$autoloadPath;
			if(empty($autoloadPath) || !is_array($autoloadPath)) {
				return;
			}
			$_tempPath = preg_replace(array('#\.\*$#','#\.#','#^application#'),array('','/',self::$appPath),$autoloadPath);
			foreach($_tempPath as $_path) {
				if(is_dir($_path) && !in_array($_path,self::$includeClassPath) {
					self::$includeClassPath = $_path;
				}
			}
		}

		//注册autoload方法 
		public static function register($prepend = false) {
			global $autoloadClassPath;
			if(!empty($autoloadClassPath) && is_array($autoloadClassPath)) {
				self::$autoloadPath = array_merge(self::$autoloadPath,$autoloadClassPath);
			}
			self::$appPath = defined('ROOT_PATH') ? ROOT_PATH : realpath(dirname(__FILE__).'/../');
			self::setIncludePath();
			spl_autoload_register(array(__CLASS__,'myAutoload'),true);
		}

		//自动加载类函数
		private static function myAutoload($className) {
			$fileName= strpos($className,'\\') !== false ? strtr($className,'\\',DIRECTORY_SEPARATOR).
			'.php' :$className.'.php';
			if(isset(self::$classMap[$className]))
				return false;
			$oladFileName = 'class.'.strtolower($fileName);
			foreach(self::$includeClassPath as $includePath) {
				$classFile = '';
				if(file_exists($includePath.DIRECTORY_SEPARATOR.$fileName)) {
					$classFile = $includePath.DIRECTORY_SEPARATOR.$fileName;
				}elseif(file_exists($inlcudePath.DIRECTORY_SEPARATOR.$oladFileName)) {
					$classFile = $includePath.DIRECTORY_SEPARATOR.$oladFileName;
				}
				if(!empty($classFile)) {
					require_once $classFile;
					if(class_exists($className,false)) {
						self::$classMap[$className] =true;
						break;
					}
				}

			}
		}

		public static function load($classPath) {
			if(!preg_match('/(\w+\.)/'))
		}


	}