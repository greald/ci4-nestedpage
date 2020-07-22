<?php namespace App\Controllers;

use App\Filters\Nestle;
use App\Config\Routes;


class Page extends Nest
{
	protected function setContent($contentdata = [
		"controller"=>NULL,
		"contentcontroller"=>NULL,
		"contentmethod"=>NULL,
		"parameterlist"=>NULL
		])
	{
		$old = $this->contentcontroller;
		
		$this->contentcontroller["controller"]= 
		// page controller
			isset($contentdata["controller"]) 
			? $contentdata["controller"] 
			: get_class($this);
			
		$this->contentcontroller["contentcontroller"]=
		// content controller
			isset($contentdata["contentcontroller"]) && class_exists($contentdata["contentcontroller"])
			? $contentdata["contentcontroller"]
			: ( isset($old["contentcontroller"]) 
				? $old["contentcontroller"] 
				: get_class($this) );
				
		$this->contentcontroller["contentmethod"]=
		// controller method for content view
			isset($contentdata["contentmethod"]) && method_exists($this->contentcontroller["contentcontroller"] , $contentdata["contentmethod"])
			? $contentdata["contentmethod"]
			: ( isset($old["contentmethod"]) 
				? $old["contentmethod"] 
				: "bottomfloor" ); // "index" results in endless loop!
						
		$this->contentcontroller["parameterArray"]=
		// parameter array for content controller
			isset($contentdata["parameterArray"]) && ! is_null($contentdata["parameterArray"])
			? $contentdata["parameterArray"]
			: ( isset($old["parameterArray"]) 
				? $old["parameterArray"] 
				: [] );				
	}
	
	public function nest()
	{
		$req = $this->request;
		$zuri = (new Nestle)->before($req);
	    
	    $this->setContent($zuri);
		$this->pagedata = array_merge($this->pagedata, $this->contentcontroller);
		// echo "\n<br/> pagedata" . __METHOD__.__LINE__.print_r($this->pagedata, TRUE);
		
		return $this->phphtml();
	}
	
	public function index()
	{
		return $this->nest();
	}
	
	public function container()
	{
		$req = $this->request;
		$zuri = (new Nestle)->before($req);
	    
	    $this->setContent($zuri);
		$this->pagedata = array_merge($this->pagedata, $this->contentcontroller);
		// echo "\n<br/> container data".__METHOD__.__LINE__." pagedata "; print_r($this->pagedata); 
		
		return view("nests/container", $this->pagedata);
	}

	public function bottomfloor()
	{
		// default view code
		$this->pagedata = array_merge($this->pagedata, $this->contentcontroller);
		return view("nests/content", $this->pagedata);
	}
}