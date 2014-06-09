<?php
namespace DevBieres\CommonBundle\Controller;
/*
 * ----------------------------------------------------------------------------
 * « LICENCE BEERWARE » (Révision 42):
 * <thierry<at>lafamillebn<point>net> a créé ce fichier. Tant que vous conservez cet avertissement,
 * vous pouvez faire ce que vous voulez de ce truc. Si on se rencontre un jour et
 * que vous pensez que ce truc vaut le coup, vous pouvez me payer une bière en
 * retour. 
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" (Revision 42):
 * <thierry<at>lafamillebn<point>net> wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return. 
 * ----------------------------------------------------------------------------
 * Plus d'infos : http://fr.wikipedia.org/wiki/Beerware
 * ----------------------------------------------------------------------------
 */

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\HttpFoundation\Request;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 *
 */
abstract class BaseController extends Controller {
	
	/**
	 * Rapid access to isGranted
	 */
	protected function isGranted($role) {
          return $this->get('security.context')->isGranted($role);
	} // /isGranted

	/**
	 * Rapid access to trans
	 */
	protected function trans($message) { return $this->get('translator')->trans($message); }


	/**
	 * Rapid access to log (info)
	 */
	protected function info($message) {
               $this->get('logger')->info($message);
	} // /log

	/**
	 * Rapide access to session
	 */
	protected function getSession() { return $this->getRequest()->getSession(); }

	/**
	 * Rapid acces to store a message in flash
	 */
	private function setFlash($flash, $message, $trans = 1) {
	    if($trans) { $message = $this->trans($message); }
        $this->getSession()->getFlashBag()->add($flash, $message);
	}

    /**
	 * Some access
	 */
	protected function setFlashSuccess($message, $trans = 1) { $this->setFlash('success', $message, $trans); }
	protected function setFlashError($message, $trans = 1) { $this->setFlash('danger', $message, $trans); }
	protected function setFlashWarning($message, $trans = 1) { $this->setFlash('warning', $message, $trans); }

} // /BaseController
