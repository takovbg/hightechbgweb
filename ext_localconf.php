<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Iteration.' . $_EXTKEY,
	'Sagendabooking',
	array(
		'Events' => 'list, show, edit, delete, update, new, create',
		
	),
	// non-cacheable actions
	array(
		'Events' => 'create, update, delete',
		
	)
);
