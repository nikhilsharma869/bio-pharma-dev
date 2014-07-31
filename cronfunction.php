<?php

include('wp-config.php'); 

$query = array(
            "DeveloperKey" =>'WDTZ3306DNVH4RJZJ379',
            "Keywords" => 'Biotech',
            "CountryCode" =>'US',
            "PostedWithin" => '7',
            "PageNumber" => 1,
            "PerPage" => 10,
            "Location"=>'Maryland'
        );

$query1 = array(
            "DeveloperKey" =>'WDTZ3306DNVH4RJZJ379',
            "Keywords" => 'Pharma',
            "CountryCode" =>'US',
            "PostedWithin" => '7',
            "PageNumber" => 1,
            "PerPage" => 10,
            "Location"=>'Maryland'
        );

$query2 = array(
            "DeveloperKey" =>'WDTZ3306DNVH4RJZJ379',
            "Keywords" => 'Medical Device',
            "CountryCode" =>'US',
            "PostedWithin" => '7',
            "PageNumber" => 1,
            "PerPage" => 10,
            "Location"=>'Maryland'
        );


addjods($query);
addjods($query1);
addjods($query2); 
insertindeedjob('7','US','Maryland','10','1','971316256849183','Biotech');
insertindeedjob('7','US','Maryland','10','1','971316256849183','Pharma');
insertindeedjob('7','US','Maryland','10','1','971316256849183','Medical Device');


function get_job_list() {
	$my_file = 'job_list.txt';
	$handle = fopen($my_file, 'r');
	$data = fread($handle,filesize($my_file));
	return $data;
}

//echo get_job_list();

function addjods($query)
 {
	 $url = "http://api.careerbuilder.com/v1/jobsearch?".http_build_query($query);

	$vals=development($url);
	$xml = simplexml_load_string($vals);

	 $builder = new Wpjb_Module_Ajax_CareerBuilder();
	 $job_list_data = '';
	 $temp_arr = array();
	
	foreach($xml->Results->JobSearchResult as $res )
	{
	
		$from_txt_data = explode("|||", get_job_list());
		if(!in_array($res->DID,$temp_arr) && !in_array($res->DID,$from_txt_data)) {
			$jobs=job((string)$res->DID);
			$builder->_insertJob($jobs);

			$job_list_data .= $res->DID . "|||";
			array_push($temp_arr, $res->DID);
		}
	}
	
	$my_file = 'job_list.txt';
	$handle = fopen($my_file, 'a') or die('Cannot open file:  '.$my_file);
	fwrite($handle, $job_list_data);

}

function development($url)
{
     
      $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $data = curl_exec($ch);
        curl_close($ch);
        return $data;

}

 function job($did)
    {
        $query = array(
            "DeveloperKey" =>'WDHB1W66YHJ5Y2SJS030',
            "DID" => $did
        );
        $url = "http://api.careerbuilder.com/v1/job?".http_build_query($query);
        $xml = simplexml_load_string(development($url));

        return $xml;
    }



function insertindeedjob($posted,$country,$location,$max,$added,$publisher,$keyword)
    {
  
        $url = "http://api.indeed.com/ads/apisearch?publisher=";
        $url.= $publisher."&co=".$country."&limit=";
        $url.= $max."&l=".urlencode($location)."&fromage=".$posted;
        $url.= "&q=".urlencode($keyword);
        $url.= "&v=2";
         $builder = new Wpjb_Module_Ajax_CareerBuilder();

        $str = file_get_contents($url);
        $xml = new SimpleXMLElement($str);
        $found = intval($xml->totalresults);

    
            $all = $xml->xpath("//result");
            foreach($xml->results->result as $r) {
                $keys[] = (string)$r->jobkey;
            }
	    
		$job_list_data = '';
		$temp_arr = array();
		for($i = 0 ; $i < count($keys) ; $i++) {
			if($i != count($keys)) {
				$key .= $keys[$i].",";
			} else {
				$key .= $keys[$i];
			}


			$url = "http://api.indeed.com/ads/apigetjobs?publisher=$publisher&jobkeys=".$key."&v=2";
			$str = file_get_contents($url);
			$xml = new SimpleXMLElement($str);

			$all = $xml->xpath("//result");
			foreach($xml->results->result as $r) {

				$from_txt_data = explode("|||", get_job_list());
				if(!in_array($r->url,$temp_arr) && !in_array($r->url,$from_txt_data)) {
					$builder->_insertIndeedJob($r);
				}
				
				array_push($temp_arr, $r->url);
				$job_list_data .= $r->url . "|||";
			}
		} 

	$my_file = 'job_list.txt';
	$handle = fopen($my_file, 'a') or die('Cannot open file:  '.$my_file);
	fwrite($handle, $job_list_data);        
	
	
    }
    

?>

