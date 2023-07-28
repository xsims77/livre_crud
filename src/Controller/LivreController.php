<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreFormType;
use App\Repository\LivreRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LivreController extends AbstractController
{
    #[Route('/', name: 'app.index', methods:['GET', 'POST'])]
    public function index(LivreRepository $livreRepository): Response
    {
        $livres = $livreRepository->findAll();

        return $this->render('pages/index.html.twig', [
            "livres" => $livres

        ]);

    }

    #[Route('/create', name: 'app.create', methods:['GET','POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {

        $livre = new Livre();

        $form = $this->createForm(LivreFormType::class, $livre);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {

            $livre->setCreateAt(new DateTimeImmutable('now'));
            $livre->setUpdatedAt(new DateTimeImmutable('now'));
            
            // dd('test');
            $em->persist($livre);
            $em->flush();

            return $this->redirectToRoute('app.index');
        }


        return $this->render('pages/create.html.twig',[
            "form"  => $form->createView()
        ]);
    }

    #[Route('/show/{id<\d+>}', name: 'app.show', methods:['GET'])]
    public function show(Livre $livre) : Response
    {

        return $this->render('pages/show.html.twig', [
            "livre" => $livre
        ]);
    }

    #[Route('/edit/{id<\d+>}', name: 'app.edit', methods: ['GET', 'PUT'])]
    public function edit(Livre $livre, Request $request, EntityManagerInterface $em) : Response
    {

        $form = $this->createForm(LivreFormType::class, $livre,[
            "method"    => "PUT"
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {

            $livre->setCreateAt(new DateTimeImmutable('now'));
            $livre->setUpdatedAt(new DateTimeImmutable('now'));

            $em->persist($livre);
            $em->flush();

            return $this->redirectToRoute('app.index');
        }

        return $this->render('pages/edit.html.twig', [
            "livre"   => $livre,
            'form'      =>$form
        ]);
    }

    #[Route('/delete/{id<\d+>}', name: 'app.delete', methods: ['DELETE'])]
    public function delete(
        Livre $livre, 
        Request $request, 
        LivreRepository $livreRepository, 
        EntityManagerInterface $em) : Response
    {

        $token = $request->request->get('csrf_token');

        if ($this->isCsrfTokenValid('delete_' . $livre->getId(),$token)) 
        {
            $em->remove($livre);
            $em->flush();
        }

        return $this->redirectToRoute(('app.index'));
    }
}
