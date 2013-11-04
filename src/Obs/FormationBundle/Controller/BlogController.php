<?php
namespace Obs\FormationBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Session\Session;
use Obs\FormationBundle\Entity\Article;
use Obs\FormationBundle\Entity\Commentaire;
use Obs\FormationBundle\Form\ArticleType;
use Obs\FormationBundle\Form\CommentaireType;

class BlogController extends Controller{
	
	const NOMBRE_PAR_PAGE = 5;
	/*private $articles;
	
	
	public function __construct()
	{
		$this->articles = array(
				array(
						"titre" => "Mon super titre",
						"slug" => "mon-super-titre",
						"date_post" => new \DateTime(),
						"message" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. In quasi earum praesentium aut qui nesciunt consectetur necessitatibus temporibus autem quae.",
						"commentaires" => array(
								array(
										"auteur" => "Pierre",
										"message" => "Je suis Pierre",
										"date_post" => new \DateTime()
								),
								array(
										"auteur" => "Paul",
										"message" => "Je suis Paul",
										"date_post" => new \DateTime()
								)
						)
				),
				array(
						"titre" => "Mon autre super titre",
						"slug" => "mon-autre-super-titre",
						"date_post" => new \DateTime(),
						"message" => "Deleniti commodi rerum repellat iste aliquid optio consectetur architecto aspernatur laborum vel dolor dolorem veritatis blanditiis nostrum laudantium delectus vitae.",
						"commentaires" => array(
								array(
										"auteur" => "Jacques",
										"message" => "Je suis Jacques",
										"date_post" => new \DateTime()
								)
						)
				)
		);
	}*/
	
	public function indexAction($page)
	{
		$em = $this->getDoctrine()->getManager();
		//php app/console container:debug
		//$session = $this->get('session');
		//$session->set("article", $this->articles);
		//$session->get('articles');
		//$this->getRequest()->cookies->add();
		//$this->getRequest()->cookies->get();
		//$this->getRequest()->cookies->set();
		//$this->getRequest()->cookies->replace();
		
		
		$articles = $em->getRepository("ObsFormationBundle:Article")->getArticles($this::NOMBRE_PAR_PAGE, $page);
		
		if($page < 1)
		{
			throw $this->createNotFoundException("La page demandée doit être supérieure à 1.");
		}
	
		return $this->render("ObsFormationBundle:Blog:index.html.twig", array(
				'articles' => $articles,
				'page' => $page,
				'nb_pages' => ceil(count($articles)/$this::NOMBRE_PAR_PAGE)
		));
	}
	
	public function voirArticleAction(Article $article)
	{
		$em = $this->getDoctrine()->getManager();
		$commentaire = new Commentaire();
		$commentaire->setArticle($article);
		$form = $this->createForm(new CommentaireType(), $commentaire);
		
		$form->handleRequest($this->getRequest());
		
		if($form->isValid())
		{
			$em->persist($commentaire);
			$em->flush();
			
			$this->get('session')->getFlashBag()->add(
				'notice',
				'Le commentaire a bien été envoyé.'
			);
			
			return $this->redirect($this->generateUrl("obs_formation_blog_voir", array('slug' => $article->getSlug())));
		}
		
		return $this->render("ObsFormationBundle:Blog:article.html.twig", array(
				"article" => $article,
				"form" => $form->createView()
		));
	}
	
	public function ecrireArticleAction()
	{
		$em = $this->getDoctrine()->getManager();
		$article = new Article();
		$form = $this->createForm(new ArticleType(), $article);
		
		$form->handleRequest($this->getRequest());
		
		if($form->isValid())
		{
			$em->persist($article);
			$em->flush();
			
			return $this->redirect($this->generateUrl("obs_formation_blog_voir", array("slug" => $article->getSlug())));
		}
		
		return $this->render("ObsFormationBundle:Blog:ajouter.html.twig", array(
			"form" => $form->createView()
		));
	}
	
	public function modifierArticleAction(Article $article)
	{
		$form = $this->createForm(new ArticleType(), $article);
		
		$form->handleRequest($this->getRequest());
		
		if($form->isValid())
		{
			$em->persist($article);
			$em->flush();

			return $this->redirect($this->generateUrl("obs_formation_blog_voir", array("slug" => $article->getSlug())));
		}
		
		return $this->render("ObsFormationBundle:Blog:modifier.html.twig", array(
			"form" => $form->createView()
		));
	}
	
	public function supprimerArticleAction(Article $article)
	{
		$em = $this->getDoctrine()->getManager();
		
		$request = $this->getRequest();
		
		if($request->isMethod("POST"))
		{
			$em->remove($article);
			$em->flush();
			
			return $this->redirect($this->generateUrl("obs_formation_blog_homepage"));
		}
		return $this->render("ObsFormationBundle:Blog:supprimer.html.twig", array(
			"article" => $article->getTitre()
		));
	}
}