<?php

include_once '../../google-api-php-client-2.2.1/vendor/autoload.php';

/**
 * Retrieves a simple set of google results for a given plant id.
 */
//class GoogleResults implements IteratorAggregate {
class GoogleResults 
{ 
#-----------------------------------------------------------------------------------------------------------------------------#
	# Create one or more API keys at https://console.developers.google.com/apis/credentials
	const GCSE_API_KEY = 'AIzaSyD1KORf2kRrS7r6n5rT4nwL9QBGD8QCAgk';

	/* The search engine id is specific to each "custom search engine"
	* you have configured at https://cse.google.com/cse/all     
	* Remember that you must have enabled Custom Search API for the project that
	* contains your API Key.  You can do this at the following url:
	* https://console.developers.google.com/apis/api/customsearch.googleapis.com/overview?project=vegfetch-v01&duration=PT1H    

	* If you fail to enable the Custom Search API before you try to execute a search
	* the exception that is thrown will indicate this.  */
	const GCSE_SEARCH_ENGINE_ID = '016724384925099384635:s9jmb6xrf-w';

	private $service; # Holds the GoogleService for reuse
	private $optParamSEID; # Holds the optParam for our search engine id
#-----------------------------------------------------------------------------------------------------------------------------#
	/**
	* Creates a service object for our Google Custom Search.  The API key is 
	* permiently set, but the search engine id may be changed when performing 
	* searches in case you want to search across multiple pre-prepared engines.
	* 
	* @param string $appName       Optional name for this google search
	*/
	public function __construct($appName = "My_Search") 
	{
		$client = new Google_Client();
		$client->setApplicationName($appName); # application name is an arbitrary name

		# the developer key is the API Key for a specific google project
		$client->setDeveloperKey(self::GCSE_API_KEY);
		$this->service = new Google_Service_Customsearch($client); # create new service

		/* You must specify a custom search engine.  You can do this either by setting
		* the element "cx" to the search engine id, or by setting the element "cref"
		* to the public url for that search engine. For a full list of possible params see 
		* https://github.com/google/google-api-php-client-services/blob/master/src/Google/Service/Customsearch/Resource/Cse.php //*/
		$this->optParamSEID = array("cx"=>self::GCSE_SEARCH_ENGINE_ID);
	}
#-----------------------------------------------------------------------------------------------------------------------------#
	/**
	* A simplistic function to take a search term & search options and return an 
	* array of results.  You may want to 
	* 
	* @param string		$searchTerm     The term you want to search for
	* @param array		$optParams      See: For a full list of possible params see 
	* https://github.com/google/google-api-php-client-services/blob/master/src/Google/Service/Customsearch/Resource/Cse.php
	* @return array		An array of search result items
	*/
	public function getSearchResults($searchTerm, $optParams = array())
	{
		$items = array(); // return array containing search result items

		# Merge our search engine id into the $optParams
		# If $optParams already specified a 'cx' element, it will replace our default
		$optParams = array_merge($this->optParamSEID, $optParams);

		# set search term & params and execute the query
		$results = $this->service->cse->listCse($searchTerm, $optParams);

		# Since cse inherits from Google_Collections (which implements Iterator)
		# we can loop through the results by using `getItems()`
		// echo '<pre>$results=><hr>';
		foreach($results->getItems() as $k=>$item)
		{	//var_dump($item); //print_r($item);
			$items[] = $item;
		} //echo '</pre>';

		return $items;
	}
#-----------------------------------------------------------------------------------------------------------------------------#
}

$searchTerm = (isset($_GET['find'])) ? $_GET['find'] : 'samsung'; # cari barang apa 
$service = new GoogleResults();
$items = $service->getSearchResults($searchTerm);
echo '<pre>' . $searchTerm . ' | $results=><hr>'; print_r($items); echo '</pre>';
