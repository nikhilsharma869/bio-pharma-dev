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


function addjods($query)
 {
	 $url = "http://api.careerbuilder.com/v1/jobsearch?".http_build_query($query);

	$vals=development($url);
	$xml = simplexml_load_string($vals);

	 $builder = new Wpjb_Module_Ajax_CareerBuilder();

	foreach($xml->Results->JobSearchResult as $res )
	{
	      $jobs=job((string)$res->DID);
	       $builder->_insertJob($jobs);

	}

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
                $builder->_insertIndeedJob($r);
                }
        } 

        
    }
    

?>

