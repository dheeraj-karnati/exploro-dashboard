<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * solr_url.php
 * 
 * personal helper for create solr query url
 *
 * @author		Chen Ting
 * @copyright	free to use
 * @link		
 * @since		Version 2.0
 * @filesource
 */

// ------------------------------------------------------------------------
/*
features
1. Support muiltple solr source configuration: if u only use one solr API, u can put configuration into global variable, in my current i have to go to 3 defferent solr APIs.

2. the Library must call 3 methods: get_base_url(),getQuery(),echo_solr_url(). 
		get_base_url(): Generates basic solr url, ie:"http://10.0.15.72:8080/solrins/select/"
		getQuery(): Generates solr Query, ie: "?q=EnName_t:Academy%20AND%20Country_t:China"
		echo_solr_url(): Generates full URl and Print out. arg1=format, optional arg2=offset, optioanl arg3=limit 

3. Optional methods: getSort(), getFacet(), getFQ()
		getSort(): Support data Sort
		getFacet(): Support data Facet
		getFQ(): Support secondary search
*/

class Solr_url
{
	/*
	* get_base_url
	* only support select handler now
	* $config = array; ie:array('host' => '10.0.15.xx' , 'port' => '8080' , 'DB' => 'solrins');
	* return string
	*/
	public function get_base_url($config)
	{
		$this->base = "http://".$config['host'].":".$config['port']."/solr/exploro/"."/select/";
	}

	/*
	* getQuery: query string
	* 
	* $input = array('search field' => 'keywork' ) array('EnName_t' => 'Academy' , 'Country_t' => 'China' )
	* $operator = 'AND'/'OR'
	* return string
	*/
	public function getQuery($input,$operator)
	{
		$query='?q=';
		$last_key = end(array_keys($input));
		foreach ($input as $key => $value) {
			if ( $key != $last_key) {
				$query .= $key.":".$value."%20".$operator."%20";
			} else {
				$query .= $key.":".$value;
			}
		}

		$this->q = $query;
	}

	/*
	* getSort: results sort
	* 
	* $sort = 'search field'
	* $order = 'desc'/'asc'
	* return string
	*/
	public function getSort($sort,$order)
	{
		$this->sort = "&sort=".$sort."%20".$order;
	}

	/*
	* getFacet: get Facet
	* 
	* $facetInput = facet input
	* $sort(optional) = facet order
	* $miniCount(optional) = least count of facet
	*/
	public function getFacet($facetInput,$sort = Null,$miniCount = '1')
	{
		$facet = "&facet=on";
		foreach ($facetInput as $key => $value) {
			$facet .= "&facet.field=".$value;
		}
		$facet .= "&facet.mincount=".$miniCount;
		if (is_null($sort)) {
			# code...
		} else {
			foreach ($sort as $key => $value) {
				$facet .= "&f".$key."facet.sort=".$value;
			}
		}
		
		$this->facet = $facet;
	}

	/*
	* getSort: results sort
	* 
	* $fqInput array
	*/
	public function getFQ($fqInput)
	{
		$fquery ='';
		foreach ($fqInput as $key => $value) {
			$fquery .= "&fq=".$key.":".$value;
		}

		$this->fq = $fquery;
	}

	/*
	* Generate solr url from all function above
	* $format = json/xml/python/php
	* $offset: optional
	* $limit: optional
	*/
	public function echo_solr_url($format,$offset = "0",$limits = "10")
	{	
		if (isset($this->sort)) {$sort_url = $this->sort;} else {$sort_url = '';}
		if (isset($this->facet)) {$facet_url = $this->facet;} else {$facet_url = '';}
		if (isset($this->fq)) {$fq_url = $this->fq;} else {$fq_url = '';}
		
		$url = $this->base.''.$this->q."&wt=".$format."&version=2.2&indent=on&start=".$offset."&rows=".$limits."".$sort_url."".$facet_url."".$fq_url;

		return $url;
	}
	public function create_solr_url($format,$offset="0"){





    }
}



