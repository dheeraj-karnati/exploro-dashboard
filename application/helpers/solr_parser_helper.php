<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Chen Ting
 *
 * Codeigniter Helper parse solr return results with facet
 *
 * @author		Chen Ting
 * @copyright	free to use
 * @link		
 * @since		Version 1.0
 * @filesource
 *
 * Heading
 *
 */


if ( ! function_exists('ping'))
{
	function ping($config, $timeout) { 
		$tB = microtime(true); 
		$fP = fSockOpen($config['host'],$config['port'], $timeout); 
		if (!$fP) { return false; } 
		$tA = microtime(true); 
		return true; 
	}
}

if ( ! function_exists('solrResult_json_parser'))
{
	function solrResult_json_parser($url,$facetinput)
	{	
		$json = file_get_contents($url);
		$json_o=json_decode($json);
		$count = $json_o->response->numFound;
		$results = $json_o->response->docs;

		$returnfacet= array();
		foreach ($facetinput as $key => $value) {
			$returnfacet[$value] = $json_o->facet_counts->facet_fields->$value;
		}

		return array('count' => $count, 'results' => $results, 'facet' => $returnfacet);
	}
}

if ( ! function_exists('solrResult_php_parser'))
{
	function solrResult_php_parser($url,$facetinput)
	{	
		$phpRes = file_get_contents($url);
		eval("\$result = " . $phpRes . ";");

		$count = $result['response']['numFound'];
		$phpResult =  $result['response']['docs'];

		$returnFacet = array();
		foreach ($facetinput as $key => $value) {
			$returnFacet[$value] = $result['facet_counts']['facet_fields'][$value];
		}

		return array('count' => $count, 'phpResults' => $phpResult, 'facet' => $returnFacet);
	}
}


?>