<?php
/**
* Holding an instance of CLydia to enable use of $this in subclasses.
*
* @package LydiaCore
*/
class CObject 
{

	   public $config;
	   public $request;
	   public $data;
	   public $db;
	   public $views;
	   public $session;
	
	   /**
	    * Constructor
	    */
	   protected function __construct() 
	   {
		   $tube = CTube::Instance();
		   $this->config   = &$tube->config;
		   $this->request  = &$tube->request;
		   $this->data     = &$tube->data;
		   $this->db       = &$tube->db;
		   $this->views    = &$tube->views;
		   $this->session  = &$tube->session;
	   }
	/**
	* Redirect to another url and store the session
	*/
	protected function RedirectTo($url) 
	{
		$tube = CTube::Instance();
		if(isset($tube->config['debug']['db-num-queries']) && $tube->config['debug']['db-num-queries'] && isset($tube->db)) 
		{
			$this->session->SetFlash('database_numQueries', $this->db->GetNumQueries());
		}
		if(isset($tube->config['debug']['db-queries']) && $tube->config['debug']['db-queries'] && isset($tube->db)) 
		{
			$this->session->SetFlash('database_queries', $this->db->GetQueries());
		}
		if(isset($tube->config['debug']['timer']) && $tube->config['debug']['timer']) 
		{
			$this->session->SetFlash('timer', $tube->timer);
		}
		$this->session->StoreInSession();
		header('Location: ' . $this->request->CreateUrl($url));
	}
}


