<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Niveau;
use App\Form\CoursType;
use App\Entity\Etudiant;
use App\Entity\Enseignant;
use App\Repository\CoursRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/cours")
 */
class CoursController extends AbstractController
{
    /**
     * @Route("/", name="cours_index", methods={"GET"})
     */
    public function index(CoursRepository $coursRepository): Response
    {
        return $this->render('cours/index.html.twig', [
            'cours' => $coursRepository->findAll(),
        ]);
    }

     /**
     * @Route("/ListeCours_Enseignants", name="ListeCours_Enseignants", methods={"GET"})
     */
    public function ListeCours_Enseignants(Request $request, CoursRepository $coursRepository): Response
    {

        $repo = $this->getDoctrine()->getRepository(Enseignant::class);
        $email=$request->query->get('email');
        $enseignant = $repo->findOneByEmail($email);
        $lista = $enseignant->getCours();

        
        return $this->render('cours/ListeCours_Enseignants.html.twig', [
            'cours' => $coursRepository->findAll(),
            'lista' => $lista,
        ]);
    }

    /**
     * @Route("/ListeCours_Etudiants", name="ListeCours_Etudiants", methods={"GET"})
     */
    public function ListeCours_Etudiants(Request $request, CoursRepository $coursRepository): Response
    {
        $repo = $this->getDoctrine()->getRepository(Etudiant::class);
        $email=$request->query->get('email');
        $etudiant = $repo->findOneByEmail($email);

        $niveau = $etudiant->getNiveauEtu();

        $liste = $niveau->getCours();


        return $this->render('cours/ListeCours_Etudiants.html.twig', [
            'cours' => $coursRepository->findAll(),
            'liste' => $liste,
        ]);
    }

    /**
     * @Route("/new", name="cours_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $cour = new Cours();
        $repo = $this->getDoctrine()->getRepository(Enseignant::class);
        $email=$request->query->get('email');
        $enseignant = $repo->findOneByEmail($email);
        $cour->setEnseignantcrs($enseignant);
        $form = $this->createForm(CoursType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $brochureFile = $form['brochureFileName']->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $cour->setBrochureFileName($newFilename);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cour);
            $entityManager->flush();

            return $this->redirectToRoute('cours_index', [
                'email' => $email]);
        }

        return $this->render('cours/new.html.twig', [
            'cour' => $cour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cours_show", methods={"GET"})
     */
    public function show(Cours $cour): Response
    {
        return $this->render('cours/show.html.twig', [
            'cour' => $cour,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cours_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Cours $cour): Response
    {
        $form = $this->createForm(CoursType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cours_index');
        }

        return $this->render('cours/edit.html.twig', [
            'cour' => $cour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cours_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Cours $cour): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cour->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cours_index');
    }
}
