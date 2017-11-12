<?php

defined('NL') or define('NL', "\n");

defined('DS') or define('DS', DIRECTORY_SEPARATOR);

defined('DATE_SQL') or define('DATE_SQL', 'Y-m-d H:i:s');

require_once(__DIR__ . '/vendor/autoload.php');

//init_constants_from_yaml(__DIR__ . '/env.yml');

function dump($var)
{
	if (\Yii::$app instanceof Yii\console\Application)
	{
		\yii\helpers\VarDumper::dump($var);
		echo NL;
	}
	elseif (!empty(\Yii::$app->response->format) and \Yii::$app->response->format === \yii\web\Response::FORMAT_HTML)
	{
		echo '<div>';
		\yii\helpers\VarDumper::dump($var, 10, true);
		echo '</div>';
	}
	else
	{
		\yii\helpers\VarDumper::dump($var, 10, false);
	}
}

function dumpAsString($var)
{
	$output = '<div>';
	$output .= \yii\helpers\VarDumper::dumpAsString($var, 10, true);
	$output .= '</div>';
	return $output;
}

function app()
{
	return \Yii::$app;
}

function app_end()
{
	\Yii::$app->end();
}

function request()
{
	return \Yii::$app->request;
}

/**
 * 
 * @return \app\common\User
 */
function user()
{
	return \Yii::$app->user;
}

function icon($name, $options = [])
{
	return \kartik\icons\Icon::show($name, $options/*, Icon::FA*/);
}

/**
 * 
 * @param string $sql
 * @return \yii\db\Command
 */
function command($sql = null, $params = [])
{
	$db = \Yii::$app->db;
	
//	if ($db instanceof CDbConnection)
//		$connection = $db;
//	else
//		$connection = Yii::app()->$db;
	
	return $db->createCommand($sql, $params);
}

function todo()
{
	throw new Exception("Not yet implemented", 501);
}

/**
 * 
 * @param into $milliseconds
 */
function msleep($milliseconds)
{
	usleep($milliseconds * 1000);
}

/**
 * Checks if a string starts with another string
 * 
 * @param string $subject
 * @param string $search
 * @param bool $case_insensitivity
 * @return boolean
 */
function str_begins($subject, $search, $case_insensitivity = false)
{
	if ($case_insensitivity)
	{
		$subject = strtolower($subject);
		$search = strtolower($search);
	}

	if (substr($subject, 0, strlen($search)) === $search)
		return true;
	else
		return false;
}

/**
 * Checks if a string contains another string
 * 
 * @param string $subject
 * @param string $search
 * @param bool $case_insensitivity
 * @return boolean
 */
function str_contains($subject, $search, $case_insensitivity = false)
{
	if ($case_insensitivity)
		return (stripos($subject, $search) !== false);
	else
		return (strpos($subject, $search) !== false);
}

function init_constants_from_array($array, $prefix = '')
{
	foreach ($array as $k => $a)
	{
		$key = $prefix . strtoupper($k);
		
		if (is_array($a))
		{
			init_constants_from_array($a, $key . '_');
			continue;
		}

		defined($key) or define($key, $a);
	}
}

function init_constants_from_yaml($filename)
{
	// should this "fail" silently? or just stick to defaults?
	if (is_readable($filename))
	{	
		$yaml = file_get_contents($filename);
		$array = \Symfony\Component\Yaml\Yaml::parse($yaml);

		// for when I am looking at the same as the test suite
		if (!empty($_SERVER['SERVER_PORT']) and $_SERVER['SERVER_PORT'] === '8889')
			$array['yii']['env'] = 'test';

		init_constants_from_array($array);
	}

	defined('YII_SERVER') or define('YII_SERVER', 'live');
	
	defined('YII_SERVER_LIVE') or define('YII_SERVER_LIVE', YII_SERVER === 'live');
	defined('YII_SERVER_DEV') or define('YII_SERVER_DEV', YII_SERVER === 'dev');
	defined('YII_SERVER_LOCAL') or define('YII_SERVER_LOCAL', YII_SERVER === 'local');
	
	defined('YII_HOSTNAME') or define('YII_HOSTNAME', 'localhost');
}