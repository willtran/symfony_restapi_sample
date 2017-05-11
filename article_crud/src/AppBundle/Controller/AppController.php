<?php

namespace AppBundle\Controller;

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

abstract class AppController extends FOSRestController
{
    const FAILED_RESPONSE_CODE = '200'; // Common failed response code for now
    const SUCCESS_RESPONSE_CODE = '100'; // common success response code

    protected function getSuccessResponse($aData = null) {
        return [
            'success' => true,
            'code'  =>  self::SUCCESS_RESPONSE_CODE,
            'data' => $aData
        ];
    }

    protected function getFailedResponse($vErrorMessage) {
        return [
            'success'   =>  false,
            'code'      =>  self::FAILED_RESPONSE_CODE,
            'message'   =>  $vErrorMessage
        ];
    }

}
