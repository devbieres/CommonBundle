<?php
namespace DevBieres\CommonBundle\Form\Transformer;
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

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Transformer for Data Transformer
 * http://symfony.com/doc/current/cookbook/form/data_transformers.html (2.4)
 */
abstract class AbstractEntityToIdTransformer implements DataTransformerInterface
{

		/**
		 * FullName of the Entity
		 */
		abstract protected function getEntityFullName();

		/**
		 * @var ObjectManager
		 */
		private $om;

		public function __construct(ObjectManager $om) {
              $this->om = $om;
		} // _construct

		/**
		 * Transforms an object (Document) to a String (number)
		 * @param Document\null $document
		 * @return string
		 */
		public function transform($document) {
				if(null === $document) { return ""; }
				return $document->getId();
		} // /transform

		/**
		 * Transforms a string (id) to an object (document)
		 * @param string $id
		 * @return Document\null
		 * @throws TransformationFailedException
		 */
		public function reverseTransform($id) {
              if(! $id) {
                  return null;
			  } 

			  // Find the document
			  $doc = $this->om
					      ->getRepository($this->getEntityFullName())
						  ->findOneById($id);

			  // Is there one ?
			  if(null === $doc) {
					  throw new TransformationFailedException(
							  sprintf("No document found : '%s'", $id)
					  );
			  } // / null

			  // Return 
			  return $doc;

		} // reverseTransform
		

} // /DocumentToIdTransformer
