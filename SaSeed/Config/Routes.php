<?php
/**
* General Routes
*
* This file holds basic route settings for the whole application.
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2015/08/28
* @version 1.16.1026
* @license SaSeed\license.txt
*/

// WEB CONTEXT ROUTES
define('WebJSViewPath', 'js/');
define('WebCSSViewPath', 'css/');
define('WebImgViewPath', 'img/');

// LOCAL ROUTES
$path = dirname(__FILE__);
$basePath = substr($path, 0, strpos($path, 'SaSeed'));
define('ConfigPath', $basePath.'SaSeed/Config/');
define('ViewPath', $basePath.'public_html/');
define('ImgPath', ViewPath.'img/');
define('TemplatesPath', ViewPath.'/templates/');
define('MainJsPath', ViewPath.'js/');
define('MainCssPath', ViewPath.'css/');
