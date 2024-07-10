<?php

namespace App\Controller;

use App\Entity\Propriete;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\ProprieteRepository;

class FrontendController extends AbstractController
{
   
    public function index(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request): Response
    {
	$queryBuilder = $entityManager->getRepository(Propriete::class)->createQueryBuilder('p');

        $pagination = $paginator->paginate(
            $queryBuilder->getQuery(),
            $request->query->getInt('page', 1), // Current page number, default to 1
            10 // Number of items per page
        );

	    return $this->render('frontend/index.html.twig', [
		'pagination' => $pagination,
		'controller_name' => 'FrontendController',
        ]);
    }

    
    public function listeproprietes(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request): Response
    {
	$queryBuilder = $entityManager->getRepository(Propriete::class)->createQueryBuilder('p');

        $pagination = $paginator->paginate(
            $queryBuilder->getQuery(),
            $request->query->getInt('page', 1), // Current page number, default to 1
            10 // Number of items per page
        );    
	    
	return $this->render('frontend/listeproprietes.html.twig', [
 		'pagination' => $pagination,
        ]);
    }
   
     public function listByPriceRange(float $minPrice, float $maxPrice, ProprieteRepository $proprieteRepository): Response
    {
	   if ($minPrice < 0 || $maxPrice < $minPrice) {
            throw $this->createNotFoundException('La plage de prix n\'est pas valide.');
        }
	  
	   
	    $proprietes = $proprieteRepository->findPropertyByRangeOfPrice($minPrice, $maxPrice);

        return $this->render('frontend/list_by_price_range.html.twig', [
            'proprietes' => $proprietes,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
        ]);
    }



   #[Route('/proprietedetail/{id}', name:'propriete_detail')]
   public function proprietedetail(int $id=null,ProprieteRepository $proprieteRepository): Response
   {    
   
	   $propriete = $proprieteRepository->findProprieteById($id);

	

	   return $this->render('frontend/propriete_detail.html.twig', [
		   'propriete' => $propriete,
	   ]);
   }

}
