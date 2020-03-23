<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Etudiant;
use App\Entity\Enseignant;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil" , methods={"GET","POST"})
     */
    public function profil(Request $request)
    {
        $email=$request->query->get('email');
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findOneByEmail($email);

        $id=$request->query->get('email');
        $repos = $this->getDoctrine()->getRepository(Etudiant::class);
        $etudiant = $repos->findOneByEmail($id);

        $id2=$request->query->get('email');
        $reposi = $this->getDoctrine()->getRepository(Enseignant::class);
        $enseignant = $reposi->findOneByEmail($id2);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {

            $brochureFile = $form['image']->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = 'profilpic';
                $str =strval($user->getEmail());
                
                $newFilename = $safeFilename.'-'.$str.'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setImage($newFilename);
            }



            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            if($user->getStatut() == 0){

                $etudiant->setImage($user->getImage());
                $entityManager->persist($etudiant);
                $entityManager->flush();
            }else{
                $enseignant->setImage($user->getImage());
                $entityManager->persist($enseignant);
                $entityManager->flush();
            }
 

            return $this->redirectToRoute('profil', [
                'email' => $user->getEmail()
                ]);
        }

        return $this->render('Profil/profil.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
