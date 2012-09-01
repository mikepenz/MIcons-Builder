<?php
	class ConfigManager
	{
	    public static function read($filename)
	    {
	    	if(file_exists($filename)) {
	        	$config = include $filename;
	        	return $config;
	    	} else {
	    		return false;
	    	}
	    }
	    public static function write($filename, array $config)
	    {
	        $config = var_export($config, true);
	        file_put_contents($filename, "<?php return $config ;");
	    }
	}
?>