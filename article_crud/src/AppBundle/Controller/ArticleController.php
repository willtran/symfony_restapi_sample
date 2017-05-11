<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Articles as Article;
use AppBundle\Entity\Authors as Author;

class ArticleController extends AppController
{
    /**
     * @Rest\Get("/article")
     */
    public function getAction()
    {
        try {
            $aArticles = $this->getDoctrine()->getRepository('AppBundle:Articles')->findAll();
            if ($aArticles === null) {
                $aArticles = [];
            }
            $aResponse = $this->getSuccessResponse($aArticles);
        } catch (Exception $e) {
            $aResponse = $this->getFailedResponse($e->getMessage());
        }

        return $aResponse;
    }

    /**
     * @Rest\Get("/article/{id}")
     */
    public function idAction($id)
    {
        try {
            $oArticle = $this->getDoctrine()->getRepository('AppBundle:Articles')->find($id);
            if (!$oArticle) {
                throw new Exception('No article with provided id');
            }
            $aResponse = $this->getSuccessResponse($oArticle);
        } catch (Exception $e) {
            $aResponse = $this->getFailedResponse($e->getMessage());
        }

        return $aResponse;
    }

    /**
     * @Rest\Delete("/article/{id}")
     */
    public function deleteArticleAction($id)
    {
        try {
            $oArticle = $this->getDoctrine()->getRepository('AppBundle:Articles')->find($id);
            if (!$oArticle) {
                throw new Exception('No article with provided id');
            }
            $this->getDoctrine()->getManager()->remove($oArticle);
            $this->getDoctrine()->getManager()->flush();
            $aResponse = $this->getSuccessResponse('Deleted');
        } catch (Exception $e) {
            $aResponse = $this->getFailedResponse($e->getMessage());
        }

        return $aResponse;
    }

    /**
     * @Rest\Post("/article")
     */
    public function postAction(Request $oRequest)
    {
        $vAuthorId = $oRequest->query->filter('author_id', null, FILTER_SANITIZE_SPECIAL_CHARS);
        $vTitle = $oRequest->query->filter('title', null, FILTER_SANITIZE_SPECIAL_CHARS);
        $vUrl = $oRequest->query->filter('url', null, FILTER_SANITIZE_SPECIAL_CHARS);
        $vContent = $oRequest->query->filter('content', null, FILTER_SANITIZE_SPECIAL_CHARS);
        try {
            // for now just put into db without checking for unique value
            $oArticle = new Article();
            $oAuthor = $this->getDoctrine()->getRepository('AppBundle:Authors')->find($vAuthorId);
            if (!$oAuthor) {
                throw new Exception('Cannot find author with provided id');
            }
            $oArticle->setAuthor($oAuthor)
                ->setTitle($vTitle)
                ->setUrl($vUrl)
                ->setContent($vContent);
            $oArticle->setCreatedAt(new \DateTime());
            $oArticle->setUpdatedAt(new \DateTime());
            $this->getDoctrine()->getManager()->persist($oArticle);
            $this->getDoctrine()->getManager()->flush();
            $aResponse = $this->getSuccessResponse();
        } catch (Exception $e) {
            $aResponse = $this->getFailedResponse($e->getMessage());
        }
        return $aResponse;
    }

    /**
     * @Rest\Put("/article")
     */
    public function updateArticleAction($vId, Request $oRequest)
    {
        $vAuthorId = $oRequest->query->filter('author_id', null, FILTER_SANITIZE_SPECIAL_CHARS);
        $vTitle = $oRequest->query->filter('title', null, FILTER_SANITIZE_SPECIAL_CHARS);
        $vUrl = $oRequest->query->filter('url', null, FILTER_SANITIZE_SPECIAL_CHARS);
        $vContent = $oRequest->query->filter('content', null, FILTER_SANITIZE_SPECIAL_CHARS);
        try {
            // for now just put into db without checking for unique value
            $oArticle = $this->getDoctrine()->getRepository('AppBundle:Authors')->find($vId);
            $oAuthor = $this->getDoctrine()->getRepository('AppBundle:Authors')->find($vAuthorId);
            if (!$oArticle) {
                throw new Exception('Cannot find article with provided id');
            }
            if (!$oAuthor) {
                throw new Exception('Cannot find author with provided id');
            }
            $oArticle->setAuthor($oAuthor)
                ->setTitle($vTitle)
                ->setUrl($vUrl)
                ->setContent($vContent);
            $oArticle->setUpdatedAt(new \DateTime());
            $this->getDoctrine()->getManager()->persist($oArticle);
            $this->getDoctrine()->getManager()->flush();
            $aResponse = $this->getSuccessResponse();
        } catch (Exception $e) {
            $aResponse = $this->getFailedResponse($e->getMessage());
        }
        return $aResponse;
    }

}
