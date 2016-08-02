<?php

namespace SON\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use SON\UserBundle\Entity\User;
use SON\UserBundle\Form\UserType;

use SON\UserBundle\Form\RegisterFormType;


class RegisterController extends Controller
{

    /**
     * Lists all User entities.
     *
     * @Route("/register", name="user_register")
     * @Template()
     */
    public function registerAction(Request $request)
    {
       //$defaultData = array("username" => "Escolha um User");
        $defaultData = new User();
        $defaultData->setUsername("escolha um user");

        $form = $this->createForm(new RegisterFormType(), $defaultData);

        if('POST' == $request->getMethod()){
            $form->bind($request);

            if($form->isValid()){
                /** @var  User */
                $user = $form->getData();
                $user->setPassword($this->encodePassword($user, $user->getPlainPassword()));

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $request->getSession()->setFlash('success', 'Registro feito com sucesso!');

                return $this->redirect($this->generateUrl("catalogo"));
            }

        }

        return array("form"=>$form->createView());
    }

    private function encodePassword($user, $plainPassword) {
        $encoder = $this->get("security.encoder_factory")
            ->getEncoder($user);

        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }

}
