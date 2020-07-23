<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Nestle implements FilterInterface
{
    // @controller_filter as in  		https://codeigniter.com/user_guide/incoming/filters.html
    // @subject [controller, method] = 	config('Nestle')->pagebuildupArr
    // @subject namespace 				config('Nestle')->contentcontrollerNS
    
    public function before(RequestInterface $request)
    // @return [ "contentcontroller"=> fully qualified class name, "contentmethod"=> string, "parameterArray"=> array ] 
    {
        // split content controller / method / parameters from request uri
	    $uri = $request->uri;   
	    $pagebuildupArr = config('Nestle')->pagebuildupArr;	// ["page","nest"];
	    $contentUriArr = array_values(array_diff($uri->getSegments(), $pagebuildupArr));
	    
	    // validate controller
	    $CC = array_shift($contentUriArr);
	    if(isset($CC))
	    {
		    $contentContrName = config('Nestle')->contentcontrollerNS . ucfirst($CC);
		}
					
		// validate method
		$CM = array_shift($contentUriArr);
		if(isset($CM)
			&& class_exists($contentContrName) 
			&& method_exists($contentContrName, $CM)
		){}
		else
		{
			$contentContrName = config('Nestle')->defaultContent[0];
			$CM = config('Nestle')->defaultContent[1];
		}
		
	    	// arrange parameters
	    	$contentParameterArr = $contentUriArr;
		
		return [
			"contentcontroller" => $contentContrName,
			"contentmethod" => $CM,
			"parameterArray" => $contentParameterArr
		];
    }

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // method required by implemented interface
        // Do something here
    }
}
