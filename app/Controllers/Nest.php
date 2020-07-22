<?php namespace App\Controllers;

class Nest extends BaseController
{
	public $contentcontroller = []; // ["controller"=>NULL,"contentcontroller"=>NULL,"content"=>NULL,"contentmethod"=>NULL,"parameterlist"=>NULL];

	public $pagedata = [];
	
	public function __construct()
	{
		$this->pagedata = config('Nestle')->pagedata;
	}
	
	public function phphtml()
	{
		$this->pagedata = array_merge($this->pagedata,$this->contentcontroller);
		//echo "\n<br/> phphtml pagedata".__METHOD__.__LINE__." contentdata "; print_r($this->pagedata); 
		return view("nests/html", $this->pagedata);
	}
	
	public function head()
	{
		$this->pagedata = array_merge($this->pagedata, $this->contentcontroller);
		return view("nests/head", $this->pagedata);
	}
	
	public function body()
	{
		$this->pagedata = array_merge($this->pagedata, $this->contentcontroller);
		return view("nests/body", $this->pagedata);
	}

	public function header()
	{
		return view("nests/header");
	}

	public function footer()
	{
		return view("nests/footer");
	}
}