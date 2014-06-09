<?php
namespace DevBieres\CommonBundle\Services;
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

abstract class EntityService {

		/**
		 * Get the fullname of the entity
		 */
		protected abstract function getFullEntityName();

		/**
		 * Get a new entity based on the fullEntityName
		 */
		public function getNew() {
			 $str = $this->getFullEntityName();
             return new $str();
		} // /getNew


		/**
		 * Entity Manager
		 */
		private $em;
		public function getEM() { return $this->em; }
		public function setEM($value) { $this->em = $value; }

		/**
		 * Return the repository for the name in param
		 * @param $name full entity name
		 * /!\ Do not test if EM is set or not. Do not call it if no EM set ... /!\
		 */
		protected function getRepo($name = "") {
		    if($name == "") { $name = $this->getFullEntityName(); }
			return $this->getEM()->getRepository($name);
		} // /getRepo

		/**
		 * Save the entity and return it
		 */
		public function save($entity) {
              // Call the first hook
			  $entity = $this->preSave($entity);
			  // Save
			  $this->getEM()->persist($entity);
			  $this->getEM()->flush(); 
              // Call the second hook
			  $entity = $this->postSave($entity);
			  // return
			  return $entity;
		} // save

		/**
		 * Last chance before Saving
		 */
		protected function preSave($entity) { return $entity; }
		/**
		 * Last chance after Saving
		 */
		protected function postSave($entity) { return $entity; }


		/**
		 * Delete the entity
		 */
		public function delete($id) {
			  $entity = $this->findOneById($id);
			  // TODO : Test si existe pas ...
			  if($entity) {
                 // Call the first hook
			     $entity = $this->preDelete($entity);
			     // Save
			     $this->getEM()->remove($entity);
			     $this->getEM()->flush(); 
                 // Call the second hook
			     $this->postDelete($id);
			  }
		} // delete

		/**
		 * Last chance before Saving
		 */
		protected function preDelete($entity) { return $entity; }
		/**
		 * Last chance after Saving
		 */
		protected function postDelete($entity) { return $entity; }

		/**
		 * Return one entity
		 */
		public function findOneById($id) { return $this->getRepo()->findOneById($id); }
		/**
		 * Return all entities
		 */
		public function findAll() { 
			return $this->getRepo()->findAll();
		} // /findAll





} // /BaseService
