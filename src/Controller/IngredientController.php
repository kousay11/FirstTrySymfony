<?php

namespace App\Controller;

use App\Entity\Ingridient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Intl\Util\GitRepository;
use Symfony\Component\Routing\Annotation\Route;

class IngredientController extends AbstractController
{
    /**
     * this function desplays all ingredients
     *
     * @param IngredientRepository $Repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/ingredient', name: 'ingredient.index', methods:['GET'])]
    public function index( IngredientRepository $Repository,PaginatorInterface $paginator,Request $request): Response
    
    {
        $ingredients = $paginator->paginate(
            $Repository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        ); 
       //dd($ingredients);
        return $this->render('pages/ingredient/index.html.twig', [
            'ingredients'=>$ingredients
        ]);
    }
    /**
     *  This controller the form to create ingredients
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/ingredient/nouveau', name: 'ingredient.new', methods: ['GET', 'POST'])]
    public function new(Request $request,EntityManagerInterface $manager): Response
    {
        
        $ingredient = new Ingridient(); // Assurez-vous que le nom est bien 'Ingredient'
        $form = $this->createForm(IngredientType::class, $ingredient);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Affichage des données soumises
            $ingredient=$form->getData();
            $manager->persist($ingredient);
            $manager->flush();
            $this->addFlash(
                'success',
                'Votre ingrédient a été créé avec succès !'
            );


            return $this->redirectToRoute('ingredient.index');

        }

        return $this->render('pages/ingredient/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * This controller allow us to edit an ingredient
     *
     * @param id $id
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */

    #[Route('/ingredient/edition/{id}', name: 'ingredient.edit', methods: ['GET', 'POST'])]
    public function edit(
        int $id,  // Récupérer l'ID de l'ingrédient
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        // Récupérer l'ingrédient manuellement
        $ingredient = $manager->getRepository(Ingridient::class)->find($id);

        if (!$ingredient) {
            throw $this->createNotFoundException('Ingrédient non trouvé');
        }

        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($ingredient);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre ingrédient a été modifié avec succès !'
            );

            return $this->redirectToRoute('ingredient.index');
        }

        return $this->render('pages/ingredient/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/ingredient/suppression/{id}', name: 'ingredient.delete', methods: ['GET'])]
    public function delete(
        int $id,  // Utiliser l'ID directement
        EntityManagerInterface $manager
        ): Response {
        // Récupérer l'ingrédient manuellement
        $ingredient = $manager->getRepository(Ingridient::class)->find($id);

        if (!$ingredient) {
            throw $this->createNotFoundException('Ingrédient non trouvé');
        }

        $manager->remove($ingredient);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre ingrédient a été supprimé avec succès !'
        );

        return $this->redirectToRoute('ingredient.index');
    }







}
