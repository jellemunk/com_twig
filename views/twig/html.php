<?php

require_once( JPATH_LIBRARIES.'/Twig/Autoloader.php');
class ComTwigViewTwigHtml extends ComDefaultViewHtml
{
    protected $_twigpath; //twigpath sets the scope, you can not load templates outside this directory 
    protected $_twigfile;

    public function display()
    {
        
        //set default if the parent class didn't provide a template path.
        if(!$this->_twigpath){
            $this->_twigpath = JPATH_BASE.'/components/com_' . $this->getIdentifier()->package . '/views/' . $this->getName() . '/tmpl';
        } 
        if(!$this->_twigfile){
            $this->_twigfile = $this->getLayout() .'.html';
        }

        //only load twig if the template exists..
        if(file_exists($this->_twigpath . '/' . $this->_twigfile)){

            //setup
            Twig_Autoloader::register();
            $loader = new Twig_Loader_Filesystem($this->_twigpath);
            $twig = new Twig_Environment($loader, array(
                 'debug' => true
            ));
            $twig->addFilter('token', new Twig_Filter_Function('JUtility::getToken'));
            //make sure auto-loading of the view data still happens.
            parent::display();
            return $twig->render($this->_twigfile, $this->_data);
        }
        else{

            return parent::display();
        }
    	
    }
}