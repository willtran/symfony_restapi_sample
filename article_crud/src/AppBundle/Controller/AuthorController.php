<?php

namespace AppBundle\Controller;

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Authors as Author;

class AuthorController extends AppController
{
    /**
     * @Rest\Get("/author")
     */
    public function getAction() {
        try {
            $aAuthors = $this->getDoctrine()->getRepository('AppBundle:Authors')->findAll();
            if ($aAuthors === null) {
                $aAuthors = [];
            }
            $aResponse = $this->getSuccessResponse($aAuthors);
        } catch (Exception $e) {
            $aResponse = $this->getFailedResponse($e->getMessage());
        }

        return $aResponse;
    }

    /**
     * @Rest\Post("/author")
     */
    public function postAction(Request $oRequest) {
        $vName = $oRequest->query->filter('name',null,FILTER_SANITIZE_SPECIAL_CHARS);
        try {
            // for now just put into db without checking for unique value
            $oAuthor = new Author;
            $oAuthor->setName($vName);
            $this->getDoctrine()->getManager()->persist($oAuthor);
            $this->getDoctrine()->getManager()->flush();
            $aResponse = $this->getSuccessResponse();
        } catch (Exception $e) {
            $aResponse = $this->getFailedResponse($e->getMessage());
        }
        return $aResponse;
    }

}
