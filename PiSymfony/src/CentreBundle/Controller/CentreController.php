<?php

namespace CentreBundle\Controller;

use CentreBundle\Entity\Centre;
use CentreBundle\Entity\CentreSearch;
use CentreBundle\Entity\notecentre;
use CentreBundle\Entity\Notification;
use CentreBundle\Form\rechercheCentreType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Centre controller.
 *
 * @Route("centre")
 */
class CentreController extends Controller
{
    /**
     * Lists all centre entities.
     *
     * @Route("/", name="centre_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $notification=new Notification();
        $notification=$em->getRepository("CentreBundle:Notification")->findAll();
        foreach ($notification as $not)
        {
            $em = $this->getDoctrine()->getManager();
            $notificationmod=$em->getRepository("CentreBundle:Notification")->findBy(array('id'=>$not->getId()));
            foreach ($notificationmod as $notmod) {
                $notmod->setSeen(1);
                $em->persist($notmod);
                $em->flush();
            }

        }
        $search=new CentreSearch();
        $em=$this->getDoctrine()->getManager();
        $touscentres=$em->getRepository('CentreBundle:Centre')->findAll();
        $centres=$em->getRepository('CentreBundle:Centre')->findAll();
        $form=$this->createForm(rechercheCentreType::class,$search);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $centres=$em->getRepository('CentreBundle:Centre')->findBy(array('nomCentre'=>$search->getNom()));

            return $this->render('centre/index.html.twig',array('form'=>$form->createView(),'centres'=>$centres,'touscentres'=>$touscentres));

        }

        return $this->render('centre/index.html.twig', array(
            'touscentres' => $touscentres,
            'form'=>$form->createView(),
            'centres'=>$centres,
        ));

    }

    public function indexFrontAction()
    {
        $em = $this->getDoctrine()->getManager();

        $centres = $em->getRepository('CentreBundle:Centre')->findAll();

        return $this->render('centre/show2.html.twig', array(
            'centres' => $centres,
        ));
    }

    /**
     * Creates a new centre entity.
     *
     * @Route("/new", name="centre_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $centre = new Centre();
        $form = $this->createForm('CentreBundle\Form\CentreType', $centre);
        $form->setData('imageCentre');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $file
             */
            $file=$centre->getImageCentre();

            $filename=md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('images_directory'),$filename
            );
            $centre->setImageCentre($filename);

            $em = $this->getDoctrine()->getManager();
            $em->persist($centre);
            $em->flush();

            return $this->redirectToRoute('centre_show', array('id' => $centre->getId()));
        }

        return $this->render('centre/new.html.twig', array(
            'centre' => $centre,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a centre entity.
     *
     * @Route("/{id}", name="centre_show")
     * @Method("GET")
     */
    public function showAction(Centre $centre)
    {
        $deleteForm = $this->createDeleteForm($centre);

        return $this->render('centre/show.html.twig', array(
            'centre' => $centre,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    public function showFrontAction(Centre $centre)
    {
        $notecentre = new notecentre();
        $user=$this->getUser();
        $notecentre->setIdCentre($centre->getId());
        $notecentre->setIdUser($user->getId());
        $em = $this->getDoctrine()->getManager();
        $notecentre1=new notecentre();
        $notecentre1=$em->getRepository("CentreBundle:notecentre")->findBy(array('idCentre'=>$centre->getId(),'idUser'=>$user->getId()));
        if (count($notecentre1)==0)
        {$this->CompareAction($notecentre,$centre);
        }

        else
            return $this->render('centre/show3.html.twig', array(
                'centre' => $centre,

            ));
        return $this->render('centre/show3.html.twig', array(
            'centre' => $centre,

        ));

    }
    public function CompareAction(notecentre $notecentre,Centre $centre)
    {         $em = $this->getDoctrine()->getManager();

        $em->persist($notecentre);
        $em->flush();

        $centre->setVuCentre($centre->getVuCentre() + 1);
        $notication = new Notification();
        $notication
            ->setTitle($centre->getNomCentre())
            ->setDescription($centre->getVuCentre())
            ->setRoute('centre_index')
            ->setIcon($centre->getid())
            ->setParameters(array('id' => $centre->getId()));
        $em->persist($notication);
        $em->flush();
        $pusher = $this->get('mrad.pusher.notificaitons');
        $pusher->trigger($notication);
        $this->getDoctrine()->getManager()->persist($centre);
        $em->flush();
        return $this->render('centre/show3.html.twig', array(
            'centre' => $centre,

        ));
    }

    /**
     * Displays a form to edit an existing centre entity.
     *
     * @Route("/{id}/edit", name="centre_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Centre $centre)
    {
        $deleteForm = $this->createDeleteForm($centre);
        $editForm = $this->createForm('CentreBundle\Form\CentreType', $centre);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {


            /**
             * @var UploadedFile $file
             */

            $file=$_FILES['image']['name'];

            $filename=md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('images_directory'),$filename
            );
            $centre->setImageCentre($request->get('image'));
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('centre_edit', array('id' => $centre->getId()));
        }

        return $this->render('centre/edit.html.twig', array(
            'centre' => $centre,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a centre entity.
     *
     * @Route("/{id}", name="centre_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {

        $em=$this->getDoctrine()->getManager();
        $centre=$em->getRepository("CentreBundle:Centre")->find($id);
        $em->remove($centre);
        $em->flush();

        // return $this->redirect($this->generateUrl('index_centre'));
    }

    /**
     * Creates a form to delete a centre entity.
     *
     * @param Centre $centre The centre entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Centre $centre)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('centre_delete', array('id' => $centre->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    public function acceuilAction()
    {

        return $this->render('default\index.html.twig', array(

        ));
    }
    public function delete1Action(Request $request, $id)
    {

        $em=$this->getDoctrine()->getManager();
        $centre=$em->getRepository("CentreBundle:Centre")->find($id);
        $centrenote=$em->getRepository("CentreBundle:notecentre")->findBy(array('idCentre'=>$id));
        foreach ($centrenote as $not)
        {
            $em->remove($not);
            $em->flush();
        }

        $em->remove($centre);
        $em->flush();
        return $this->redirect($this->generateUrl('centre_index'));
    }
    public function newNoteAction($centre)
    {
        $notecentre = new notecentre();

        $notecentre->setIdCentre($centre);
        $notecentre->setIdUser('app.user.id');
        $em = $this->getDoctrine()->getManager();
        $em->persist($notecentre);
        $em->flush();

        return $this->render('centre_show',array(
            'centre' => $centre,
        ));



    }
    public function chercherCentreAction(Request  $request)
    {
        $search=new CentreSearch();
        $em=$this->getDoctrine()->getManager();
        $centres=$em->getRepository('CentreBundle:Centre')->findAll();
        $form=$this->createForm(rechercheCentreType::class,$search);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $centres=$em->getRepository('CentreBundle:Centre')->findBy(array('nomCentre'=>$search->getNom()));
            return $this->render('centre/recherche.html.twig',array('Form'=>$form->createView(),'centres'=>$centres));

        }
        return $this->render('centre/recherche.html.twig',array('Form'=>$form->createView(),'centres'=>$centres));
    }
    /**
     * Lists all centre entities.
     *
     * @Route("/all", name="all")
     * @Method("GET")
     */
    public function alltestAction()
    {
        $centre=$this->getDoctrine()->getManager()->getRepository('CentreBundle:Centre')
            ->findAll();
        $serialize=new Serializer([new ObjectNormalizer()]);
        $formatted=$serialize->normalize($centre);
        return new JsonResponse($formatted);
    }
    public function AddCentreAction(Request $request)
    {    $em = $this->getDoctrine()->getManager();

        $centre=new Centre();
        $centre->setNomCentre($request->get('nomCentre'));
        $centre->setAdresseCentre($request->get('adresseCentre'));
        $centre->setDasCentre($request->get('dasCentre'));
        $centre->setImageCentre($request->get('imageCentre'));
        $centre->setMailCentre($request->get('mailCentre'));
        $centre->setTelephoneCentre($request->get('telephoneCentre'));

       $em->persist($centre);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($centre);
        return new JsonResponse($formatted,200);
    }
    public function SupprimerCentreAction(Request $request)
    { $em = $this->getDoctrine()->getManager();
        $idCentreFromUrl=$request->get('id');
        $centre=$em->getRepository('CentreBundle:Centre')->find($idCentreFromUrl);
        $em->remove($centre);
        $em->flush();
        return new JsonResponse('works', 200);
    }

    public function chercherCentremobileAction(Request  $request)
    {

        $em=$this->getDoctrine()->getManager();
     $nomcentre=$request->get('nomCentre');
            $centres=$em->getRepository('CentreBundle:Centre')->findBy(array('nomCentre'=>$nomcentre));
foreach ($centres as $cent)
{
    $em = $this->getDoctrine()->getManager();
    $centmod=$em->getRepository("CentreBundle:Centre")->findBy(array('id'=>$cent->getId()));
    foreach ($centmod as $c) {
        $c->setVuCentre($c->getVuCentre()+1);

        $em->flush();
    }

}

        $serialize=new Serializer([new ObjectNormalizer()]);
        $formatted=$serialize->normalize($centres);
        return new JsonResponse($formatted);
    }
    public function chercherCentreParIdmobileAction(Request  $request)
    {

        $em=$this->getDoctrine()->getManager();
        $id=$request->get('id');
        $centres=$em->getRepository('CentreBundle:Centre')->findBy(array('id'=>$id));


        $serialize=new Serializer([new ObjectNormalizer()]);
        $formatted=$serialize->normalize($centres);
        return new JsonResponse($formatted);
    }
    public function chercherCentreParIdVumobileAction(Request  $request)
    {

        $em=$this->getDoctrine()->getManager();

        $centre=$em->getRepository('CentreBundle:Centre')->find($request->get('id'));


      //  $centre->setVuCentre($centre->getVuCentre()+1);
        // $em->persist($centre);
        //$em->flush();

        $serialize=new Serializer([new ObjectNormalizer()]);
        $formatted=$serialize->normalize($centre);
        return new JsonResponse($formatted);
    }
    public function modifierAction(Request $request)
    {
       //  $editForm->handleRequest($request);

        $em=$this->getDoctrine()->getManager();
        $centre=$em->getRepository('CentreBundle:Centre')->find($request->get('id'));

        $centre->setNomCentre($request->get('nomCentre'));
        $centre->setAdresseCentre($request->get('adresseCentre'));
        $centre->setDasCentre($request->get('dasCentre'));
        $centre->setImageCentre($request->get('imageCentre'));
        $centre->setMailCentre($request->get('mailCentre'));
        $centre->setTelephoneCentre($request->get('telephoneCentre'));
           // $em->persist($centre);
            $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($centre);
        return new JsonResponse($formatted);
    }
    public function modifierNbVuAction(Request $request)
    {
        //  $editForm->handleRequest($request);

        $em=$this->getDoctrine()->getManager();
        $centre=$em->getRepository('CentreBundle:Centre')->find($request->get('id'));


        $centre->setVuCentre($centre->getVuCentre()+1);
        // $em->persist($centre);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($centre);
        return new JsonResponse($formatted);
    }



}
