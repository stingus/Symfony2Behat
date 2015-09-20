<?php

namespace AppBundle\Contexts;

use AppBundle\Entity\Calculator;
use AppBundle\Services\CalculatorService;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext, KernelAwareContext
{
    /** @var KernelInterface */
    private $kernel;

    /** @var CalculatorService */
    private $calculatorService;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
        $this->calculatorService = $kernel->getContainer()->get('calculator');
    }

    /**
     * @BeforeScenario
     */
    public function purgeDb()
    {
        /** @var EntityManagerInterface $em */
        $em = $this->kernel->getContainer()->get('doctrine')->getManager();
        $purger = new ORMPurger();
        $executor = new ORMExecutor($em, $purger);
        $executor->purge();
    }

    /**
     * @Given I have the number :arg1 and the number :arg2
     * @param $arg1
     * @param $arg2
     */
    public function iHaveTheNumberAndTheNumber($arg1, $arg2)
    {
        $this->calculatorService->enterNumber($arg1);
        $this->calculatorService->enterNumber($arg2);
    }

    /**
     * @When I add them
     */
    public function iAddThem()
    {
        $this->calculatorService->calculate(CalculatorService::OPERATION_ADD);
    }

    /**
     * @Then I want to get the result :arg1
     * @param $arg1
     * @throws \Exception
     */
    public function iWantToGetTheResult($arg1)
    {
        $result = $this->calculatorService->getResult();
        if ($result != $arg1) {
            throw new \Exception(sprintf('Results don\t match, expecting %s but got %s', $arg1, $result));
        }
    }

    /**
     * @Then I want the calculator result to be persisted
     */
    public function iWantTheCalculatorResultToBePersisted()
    {
        $em = $this->kernel->getContainer()->get('doctrine')->getManager();
        $results = $em->getRepository('AppBundle:Calculator')->findAll();
        if (count($results) === 1 && $results[0] instanceof Calculator) {
            $calculator = $results[0];
            if ($calculator->getResult() == $this->calculatorService->getResult()) {
                return true;
            }
        }
        throw new \Exception('Result not persisted');
    }
}
