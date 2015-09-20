<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Calculator;
use AppBundle\Services\CalculatorService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Template()
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $calculator = new Calculator();
        $form = $this->createForm('form_calculator', $calculator);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $calculatorService = $this->get('calculator');
            $calculatorService->enterNumber($calculator->getFirst());
            $calculatorService->enterNumber($calculator->getSecond());
            $calculatorService->calculate(CalculatorService::OPERATION_ADD);
            $result = $calculatorService->getResult();
        }

        return array(
            'form' => $form->createView(),
            'result' => isset($result) ? $result : null
        );
    }
}
