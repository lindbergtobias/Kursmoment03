<?php
/**
* Helpers for theming, available for all themes in their template files and functions.php.
* This file is included right before the themes own functions.php

/**
* Prepend the base_url.
*/
function base_url($url) 
{
	return CTube::Instance()->request->base_url . trim($url, '/');
}

/**
* Create a url to an internal resource.
*/
function create_url($url=null) 
{
	return CTube::Instance()->request->CreateUrl($url);
}

/**
* Prepend the theme_url, which is the url to the current theme directory.
*/
function theme_url($url) 
{
	$tube = CTube::Instance();
	return "{$tube->request->base_url}themes/{$tube->config['theme']['name']}/{$url}";
}


/**
* Return the current url.
*/
function current_url() 
{
	return CTube::Instance()->request->current_url;
}

/**
* Print debuginformation from the framework.
*/
function get_debug() 
{
	// Only if debug is wanted.
	$tube = CTube::Instance();
	if(empty($tube->config['debug'])) 
	{
		return;
	}
  
	// Get the debug output
	$html = null;
	if(isset($tube->config['debug']['db-num-queries']) && $tube->config['debug']['db-num-queries'] && isset($tube->db)) 
	{
		$flash = $tube->session->GetFlash('database_numQueries');
		$flash = $flash ? "$flash + " : null;
		$html .= "<p>Database made $flash" . $tube->db->GetNumQueries() . " queries.</p>";
	}
	if(isset($tube->config['debug']['db-queries']) && $tube->config['debug']['db-queries'] && isset($tube->db)) 
	{
		$flash = $tube->session->GetFlash('database_queries');
		$queries = $tube->db->GetQueries();
		if($flash) 
		{
			$queries = array_merge($flash, $queries);
		}
		$html .= "<p>Database made the following queries.</p><pre>" . implode('<br/><br/>', $queries) . "</pre>";
	}
	if(isset($tube->config['debug']['timer']) && $tube->config['debug']['timer']) 
	{
		$html .= "<p>Page was loaded in " . round(microtime(true) - $tube->timer['first'], 5)*1000 . " msecs.</p>";
	}
	if(isset($tube->config['debug']['lydia']) && $tube->config['debug']['lydia']) 
	{
		$html .= "<hr><h3>Debuginformation</h3><p>The content of CTube:</p><pre>" . htmlent(print_r($tube, true)) . "</pre>";
	}
	if(isset($tube->config['debug']['session']) && $tube->config['debug']['session']) 
	{
		$html .= "<hr><h3>SESSION</h3><p>The content of CTube->session:</p><pre>" . htmlent(print_r($tube->session, true)) . "</pre>";
		$html .= "<p>The content of \$_SESSION:</p><pre>" . htmlent(print_r($_SESSION, true)) . "</pre>";
	}
	return $html;
}

/**
* Render all views.
*/
function render_views() 
{
	return CTube::Instance()->views->Render();
}

/**
* Get messages stored in flash-session.
*/
function get_messages_from_session() 
{
	$messages = CTube::Instance()->session->GetMessages();
	$html = null;
	if(!empty($messages)) 
	{
		foreach($messages as $val) 
		{
			$valid = array('info', 'notice', 'success', 'warning', 'error', 'alert');
			$class = (in_array($val['type'], $valid)) ? $val['type'] : 'info';
			$html .= "<div class='$class'>{$val['message']}</div>\n";
		}
	}
	return $html;
}
