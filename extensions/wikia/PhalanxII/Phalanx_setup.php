<?php

$wgExtensionCredits['other'][] = array(
	'name' => 'Phalanx II',
	'description' => 'Integrated spam control mechanism',
	'descriptionmsg' => 'phalanx-desc',
	'author' => array(
		'[http://community.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]',
		'[http://community.wikia.com/wiki/User:Macbre Maciej Brencz]',
		'[http://community.wikia.com/wiki/User:TOR Lucas \'TOR\' Garczewski]',
		'Bartek Łapiński',
		'[http://community.wikia.com/wiki/User:Grunny Daniel Grunwell (Grunny)]',
		'Władysław Bodzek',
		'Piotr Molski (moli@wikia-inc.com)',
		'Krzysztof Krzyżaniak (eloy@wikia-inc.com)',
		'Maciej Szumocki (szumo@wikia-inc.com)'
	)
);

$dir = __DIR__ . '/';
$app = F::app();

$classes = array(
	/* controllers */
	'PhalanxController'        => $dir . 'PhalanxController.class.php',
	/* models */
	'Phalanx'                  => $dir . 'classes/Phalanx.class.php',
	'PhalanxModel'             => $dir . 'models/PhalanxModel.php',
	'PhalanxUserModel'         => $dir . 'models/PhalanxUserModel.php',
	'PhalanxContentModel'      => $dir . 'models/PhalanxContentModel.php',
	'PhalanxTextModel'         => $dir . 'models/PhalanxTextModel.php',
	/* services */
	'PhalanxService'           => $dir . 'services/PhalanxService.class.php',
	/* hooks */
	'PhalanxUserBlock'         => $dir . 'hooks/PhalanxUserBlock.class.php',
	'PhalanxContentBlock'      => $dir . 'hooks/PhalanxContentBlock.class.php',
	'PhalanxTitleBlock'        => $dir . 'hooks/PhalanxTitleBlock.class.php',
	'PhalanxAnswersBlock'      => $dir . 'hooks/PhalanxAnswersBlock.class.php',
	'PhalanxWikiCreationBlock' => $dir . 'hooks/PhalanxWikiCreationBlock.class.php',
	'PhalanxHooks'	           => $dir . 'hooks/PhalanxHooks.class.php'
);

foreach ( $classes as $class_name => $class_path ) {
	$app->registerClass( $class_name, $class_path );
}

/*
 * hooks
 */
$phalanxhooks = array(
	'PhalanxUserBlock' =>
		array(
			'GetBlockedStatus'   => 'blockCheck',
			'UserCanSendEmail'   => 'userCanSendEmail',
			'AbortNewAccount'    => 'abortNewAccount',
			'cxValidateUserName' => 'validateUserName'
		),
	'PhalanxContentBlock' =>
		array(
			'EditFilter'         => 'editFilter',
			'AbortMove'          => 'abortMove',
		),
	'PhalanxTitleBlock' =>
		array(
			'SpecialMovepageBeforeMove'            => 'beforeMove',
			'EditFilter'                           => 'editFilter',
			'CreateDefaultQuestionPageFilter'      => 'checkTitle',
			'CreatePageTitleCheck'                 => 'checkTitle'
		),
	'PhalanxAnswersBlock' =>
		array(
			'CreateDefaultQuestionPageFilter'      => 'badWordsTest',
			'DefaultQuestion::filterWordsTest'     => 'filterWordsTest'
		),
	'PhalanxWikiCreationBlock' =>
		array(
			'AutoCreateWiki::checkBadWords'        => 'isAllowedText'
		),
	'PhalanxHooks' =>
		array(
			'ContributionsToolLinks'               => 'loadLinks'
		)
);

foreach ( $phalanxhooks as $class => $hooks ) {
	foreach ( $hooks as $name => $method ) {
		$app->registerHook( $name, $class, $method );
	}
}

/*
 * Fallback to previous version of Phalanx
 */
$fallback_classes = array(
	/* classes */
	'PhalanxFallback'          => $dir . 'fallback/Phalanx.class.php',
	/* hooks */
	'UserBlock'                => $dir . 'fallback/hooks/Phalanx.class.php',
	'ContentBlock'             => $dir . 'fallback/hooks/ContentBlock.class.php',
	'TitleBlock'               => $dir . 'fallback/hooks/TitleBlock.class.php',
	'QuestionTitleBlock'       => $dir . 'fallback/hooks/QuestionTitleBlock.class.php',
	'RecentQuestionsBlock'     => $dir . 'fallback/hooks/RecentQuestionsBlock.class.php',
	'WikiCreationBlock'        => $dir . 'fallback/hooks/WikiCreationBlock.class.php'
);

foreach ( $fallback_classes as $class_name => $class_path ) {
	$app->registerClass( $class_name, $class_path );
}

/**
 * messages
 */
$app->registerExtensionMessageFile('Phalanx', $dir . 'Phalanx.i18n.php');

/*
 * globals, rights etc
 */
$wgLogTypes[]                       	= 'phalanx';
$wgLogTypes[]                       	= 'phalanxemail';

$wgLogNames['phalanx']              	= 'phalanx-rule-log-name';
$wgLogNames['phalanxemail']         	= 'phalanx-email-rule-log-name';

$wgLogHeaders['phalanx']            	= 'phalanx-rule-log-header';
$wgLogHeaders['phalanxemail']       	= 'phalanx-email-rule-log-header';

$wgLogRestrictions['phalanx']       	= 'phalanx';
$wgLogRestrictions['phalanxemail']  	= 'phalanxemailblock';

$wgLogActions['phalanx/add']        	= 'phalanx-rule-log-add';
$wgLogActions['phalanx/edit']       	= 'phalanx-rule-log-edit';
$wgLogActions['phalanx/delete']     	= 'phalanx-rule-log-delete';
$wgLogActions['phalanxemail/add']   	= 'phalanx-rule-log-add';
$wgLogActions['phalanxemail/edit']  	= 'phalanx-rule-log-edit';
$wgLogActions['phalanxemail/delete'] 	= 'phalanx-rule-log-delete';

$wgAvailableRights[] = 'phalanxexempt';