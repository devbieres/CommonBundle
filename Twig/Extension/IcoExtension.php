<?php
namespace DevBieres\CommonBundle\Twig\Extension;

class IcoExtension extends \Twig_Extension {

     public function getFilters() {
	     return array(
		     new \Twig_SimpleFilter(
			     'ico', 
			     array($this, 'getFontAwesomeFilter'), 
			     array('is_safe' => array('html'))
		    )
	     );
     } // /getFilters

     public function getFontAwesomeFilter($icon) {
         //return sprintf("<span class='glyphicon glyphicon-%s'></span>", $icon);
         return 
             sprintf("<i class='fa fa-%s' ></i>", $icon);
     } // getGlyphFilter

     public function getName() { return 'devbieres.twig.ico_extension'; }

} // /IcoExtension
