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
use Symfony\Component\HttpFoundation\Request;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 *
 */
abstract class EntityController extends BaseController {

	/**
	 * Must be and EntityService and IEntityFormService
	 */
	abstract function getService();


	/**
	 * Return the list
	 */
	protected function _findAll() { 
        // get list
		$cols = $this->getService()->findAll();

		// return
		return array("cols" => $cols);
	} // /_findAll


	/**
	 * Handle some form action
	 */
	protected function _formAction(
			Request $request, 
			$method = "POST", 
			$url_action = '',
			$url_return = '',
			$id=-1
	) {
			// Get an  Entity
			if($id == -1) {
					$entity = $this->getService()->getNew();
			} else {
                    $entity = $this->getService()->findOneById($id);
					if (!$entity) {
						// TODO : Mettre un retour vers une page par défaut ?
                        throw $this->createNotFoundException('Unable to find entity');
                    }
			}

			// Get the form
			$form = $this->createForm(
					$this->getService()->getForm(),
					$entity,
					array(
							'action' => $this->generateUrl($url_action, array('id' => (($id != -1) ? $id : ""))),
							'method' => $method
					)
			); // /form

			// ONLY IF POST or PUT
			if($request->getMethod()[0] == 'P') {
			    // Handle the request
			    $form->handleRequest($request);

			    // First Validation
			    if($form->isValid()) {
					// Record threw the service
					$entity = $this->getService()->save($entity);
					// Return
					return $this->redirect($this->generateUrl($url_return));
				} // /FV
			} // /if post

			// Back to the template
		    return array(
				'entity' => $entity,
				'form' => $form->createView(),
				'submenu' => 'edit'
			);

	} // /_formAction

} // /EntityController
