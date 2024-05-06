<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Produit;

class SearchController extends AbstractController
{
    #[Route('/submit_form', name: 'form_submission', methods: ['POST'])]  // Route du formulaire
    public function submitForm(Request $request, EntityManagerInterface $em)
    {
        $searchTerm = $request->request->get('s');
        if (!$searchTerm) {
            throw $this->createNotFoundException("No search term provided.");
        }
        $products = $em->getRepository(Produit::class)->createQueryBuilder('p')
            ->leftJoin('p.categorie', 'c')
            ->where('p.nom LIKE :query')
            ->orWhere('c.nom LIKE :query')
            ->setParameter('query', '%' . $searchTerm . '%')
            ->getQuery()
            ->getResult();

        return $this->render('search/index.html.twig', [
            'products' => $products,
            'searchTerm' => $searchTerm,
        ]);
    }

}
