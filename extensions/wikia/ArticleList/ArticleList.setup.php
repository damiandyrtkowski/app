<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Damian
 * Date: 04.09.13
 * Time: 11:16
 * To change this template use File | Settings | File Templates.
 */

$app = F::app();
$dir = dirname(__FILE__) . '/';


$app->registerClass('ArticleList', $dir . 'ArticleList.class.php');
$app->registerClass('ArticleListSpecialController', $dir . 'ArticleListSpecialController.class.php');
$app->registerSpecialPage('ArticleList', 'ArticleListSpecialController');
$app->registerExtensionMessageFile('ArticleList', $dir . 'ArticleList.i18n.php');