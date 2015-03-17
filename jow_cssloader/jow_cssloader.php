<?php

/*
 * Jowwow css loader for Joomla 3.1+
 * @copyright Copyright (C) 2012-2015 - JowWow All rights reserved.</copyright>
 * @license  GNU General Public License version 2 or later; see LICENSE.txt
 * @version 2.2
 * @author JowWow http://jowwow.net
 * Note : All ini files need to be saved as UTF-8
 */

// No direct access.
defined('_JEXEC') or die;
jimport('joomla.filesystem.path');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

class plgSystemJow_CssLoader extends JPlugin {

	// Check for valid url
	public function getURL($showErrors) {

		// what url is requested?
		$url = $this->params->get('useUrl');

		// If its blank just return empty
		if (!$url) {
			return NULL;
		} elseif (!substr($url, -4 === '.css')) { // makes sure its only asking for a .css & not blank

			if ($showErrors) {
				$this->loadLanguage();
				JFactory::getApplication()->enqueueMessage(JText::sprintf('PLG_SYSTEM_JOW_CSSLOADER_ERROR_URL', $url), 'error');
			}
			return NULL;
		}

		// Check for valid URL file.
		$code = FALSE;
		// Set what we are looking for in the header response
		$options['http'] = array(
			'method' => "HEAD",
			'ignore_errors' => 1,
			'max_redirects' => 0
		);
		// Fetch Response
		// Michael Comment - Is this being used?  PhpStorm inspector shows $body unused
		$body = file_get_contents($url, NULL, stream_context_create($options));

		// Get response code.  Will return 200 if succesful
		sscanf($http_response_header[0], 'HTTP/%*d.%*d %d', $code);
		// Since it is valid Lets see if it exists
		if ($code !== 200) {
			// Only Display validation Error if showErrors is activa
			if ($showErrors) {
				$this->loadLanguage();
				JFactory::getApplication()->enqueueMessage(JText::sprintf('PLG_SYSTEM_JOW_CSSLOADER_ERROR_MISSING', $url),'error');
			}
			return NULL;
		}
		// Must be fine
		return $url;
	}

	// get single css file
	public function getFile() {
		// what file is requested?
		$useFile = $this->params->get('useFile');
		if ($useFile == '-1') {
			return NULL;
		}
		// use selected css file
		return $useFile;
	}

	// get all css files in specified folder
	public function getFolder() {
		// Lets get the pieces of the framework we need.
		$document = JFactory::getDocument();

		// what folder should we use?
		$useFolder = $this->params->get('useFolder');
		$dirname = dirname(JPATH_ROOT);
		// If nothing there then who cares
		if ($useFolder == '') {
			return;
		}
		
		// Get a list of files in the search path with the given filter.
		foreach (JFolder::files(JPath::clean(JPATH_ROOT . '/' . $useFolder), 'css', FALSE, TRUE) as $file) {
			$file = JPATH::clean(str_replace($dirname, '', $file) , '/' );
				$document->addStyleSheet($file);
			}
	}

	public function onBeforeRender() {
		// Lets get the pieces of the framework we need.
		$app = JFactory::getApplication();
		
		// Use this plugin only in site application
		if ($app->isSite()) {
			// Get preset values.
			$document = JFactory::getDocument();
			$showErrors = $this->params->get('showErrors');

			// call URL method
			$url = $this->getURL($showErrors);
			// add url if one is found
			if (!is_null($url)) {
				$document->addStyleSheet($url);
			}

			// Check for single file
			$useFile = $this->getFile($showErrors);
			var_dump($useFile);
			// add file if one is found
			if (!is_null($useFile)) {
				$document->addStyleSheet($useFile);
			}

			// Check for Folder
			// @TODO must use for each to go through each .css present.
			$this->getFolder();
		}
	}

}