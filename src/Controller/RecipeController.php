<?php

namespace App\Controller;

use App\Form\RecipeType;
use App\Entity\Recipe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\RecipeRepository;

class RecipeController extends AbstractController
{
    #[Route('/recette', name: 'recipe.index', methods: ['GET'])]
    public function index(RecipeRepository $Repository, PaginatorInterface $paginator, Request $request): Response
    {
        $recipes = $paginator->paginate(
            $Repository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('pages/recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }
    /**
     * This controller allow as to create a new recipe
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/recette/creation', 'recipe.new', methods: ['GET', 'POST'])]
    public function new(Request $request,EntityManagerInterface $manager): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recipe = $form->getData();
            //$recipe->setUser($this->getUser());

            $manager->persist($recipe);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre recette a été créé avec succès !'
            );

            return $this->redirectToRoute('recipe.index');
        }



        return $this->render('pages/recipe/new.html.twig',[
            'form' => $form->createView(),
        ]);
    }
    

     
     /**
      * This controller allow as to edit a new recipe
      *
      * @param Recipe $recipe
      * @param Request $request
      * @param EntityManagerInterface $manager
      * @return Response
      */
    #[Route('/recette/edition/{id}', name: 'recipe.edit', methods: ['GET', 'POST'])]
     public function edit(
         int $id,
         Request $request,
         EntityManagerInterface $manager
     ): Response {
         // Récupérer l'ingrédient manuellement
         $recipe = $manager->getRepository(Recipe::class)->find($id);
 
         if (!$recipe) {
             throw $this->createNotFoundException('Recette non trouvé');
         }
 
         $form = $this->createForm(RecipeType::class, $recipe);
         $form->handleRequest($request);
 
         if ($form->isSubmitted() && $form->isValid()) {
             $manager->persist($recipe);
             $manager->flush();
 
             $this->addFlash(
                 'success',
                 'Votre recette a été modifié avec succès !'
             );
 
             return $this->redirectToRoute('recipe.index');
         }
 
         return $this->render('pages/recipe/edit.html.twig', [
             'form' => $form->createView()
         ]);
     }
    
     
     
     #[Route('/recette/suppression/{id}', name: 'recipe.delete', methods: ['GET'])]
     public function delete(
         int $id,
         EntityManagerInterface $manager
         ): Response {
         // Récupérer l'ingrédient manuellement
         $recipe = $manager->getRepository(Recipe::class)->find($id);
 
         if (!$recipe) {
             throw $this->createNotFoundException('Recette non trouvé');
         }
 
         $manager->remove($recipe);
         $manager->flush();
 
         $this->addFlash(
             'success',
             'Votre recette a été supprimé avec succès !'
         );
 
         return $this->redirectToRoute('recipe.index');
     }

}
