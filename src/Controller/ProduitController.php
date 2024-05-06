<?php

namespace App\Controller;

use App\Entity\Adminstrateur;
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;

#[Route('/produit')]
class ProduitController extends AbstractController
{
    #[Route('/', name: 'app_produit_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produit();
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour créer un produit.');
        }
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $produit->setUsers($user);
            $image = $form->get('image')->getData();
            $description = $form->get('labelle')->getData();
            if ($image) {
                $newFilename = uniqid() . '.' . $image->guessExtension();
                try {
                    $image->move(
                        $this->getParameter('images_directory'),  // Emplacement de stockage
                        $newFilename
                    );

                    // Redimensionner l'image
                    $imagine = new Imagine();
                    $size = new Box(800, 800);  // Taille maximale
                    $imagine->open($this->getParameter('images_directory') . '/' . $newFilename)
                        ->thumbnail($size)
                        ->save();

                    $produit->setImage($newFilename);  // Stocker le nom du fichier d'image dans l'entité
                } catch (FileException $e) {
                    throw new \Exception("Erreur lors du téléchargement de l'image");
                }
            }
            $produit->setLabelle($description);
            $entityManager->persist($produit);
            $entityManager->flush();
            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produit_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produit_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/user', name: 'app_produit_user', methods: ['GET'])]
    public function getProductUser(EntityManagerInterface $entityManager): Response{
        $user = $this->getUser();  
        if (!$user) {
            throw $this->createAccessDeniedException("Vous devez être connecté pour accéder à cette page.");
        }
        $users = $entityManager->getRepository(Adminstrateur::class)->findOneBy(['email' => $user->getUserIdentifier()]);
        if (!$users) {
            throw $this->createNotFoundException("Utilisateur non trouvé.");
        }
        $produits = $entityManager->getRepository(Produit::class)->findBy(['users' => $users]);
        return $this->render('produit/user_product.html.twig', [
            'produits' => $produits,
        ]);
    }
}
