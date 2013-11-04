<?php
namespace Obs\FormationBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Obs\FormationBundle\Entity\Article;
use Obs\FormationBundle\Entity\Commentaire;

class LoadArticleData implements FixtureInterface{
	
	/* (non-PHPdoc)
	 * @see \Doctrine\Common\DataFixtures\FixtureInterface::load()
	 */
	public function load(ObjectManager $manager) {
		$article1 = new Article();
		$article2 = new Article();
		
		$commentaire1 = new Commentaire();
		$commentaire2 = new Commentaire();
		$commentaire3 = new Commentaire();
		
		$article1->setTitre("Mon super titre");
		$article1->setDatePost(new \DateTime());
		$article1->setMessage("Lorem ipsum dolor sit amet, consectetur adipisicing elit. In quasi earum praesentium aut qui nesciunt consectetur necessitatibus temporibus autem quae.");
		
		$article2->setTitre("Mon autre super titre");
		$article2->setDatePost(new \DateTime());
		$article2->setMessage("Deleniti commodi rerum repellat iste aliquid optio consectetur architecto aspernatur laborum vel dolor dolorem veritatis blanditiis nostrum laudantium delectus vitae.");
		
		$commentaire1->setAuteur("Pierre");
		$commentaire1->setDatePost(new \DateTime());
		$commentaire1->setMessage("Je suis Pierre");
		
		$commentaire2->setAuteur("Paul");
		$commentaire2->setDatePost(new \DateTime());
		$commentaire2->setMessage("Je suis Paul");
		
		$commentaire3->setAuteur("Jacques");
		$commentaire3->setDatePost(new \DateTime());
		$commentaire3->setMessage("Je suis Jacques");
		
		$article1->addCommentaire($commentaire1);
		$article1->addCommentaire($commentaire2);
		$article2->addCommentaire($commentaire3);
		
		$manager->persist($article1);
		$manager->persist($article2);
		$manager->flush();
	}

}