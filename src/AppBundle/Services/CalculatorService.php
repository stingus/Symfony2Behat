<?php
/**
 * Contains the
 *
 * @author Arthur Kerpician <arthur@bluechip.ro>
 */

namespace AppBundle\Services;

use AppBundle\Entity\Calculator;
use Doctrine\Bundle\DoctrineBundle\Registry;

class CalculatorService
{
    /** Allowed operations */
    const OPERATION_ADD = 'add';

    /** @var Registry */
    private $doctrine;

    /** @var array Input numbers to perform calculations on */
    private $numbers = array();

    /** @var string Operation performed */
    private $operator;

    /** @var number The result */
    private $result;

    /**
     * @return Registry
     */
    public function getDoctrine()
    {
        return $this->doctrine;
    }

    /**
     * @param Registry $doctrine
     * @return $this
     */
    public function setDoctrine($doctrine)
    {
        $this->doctrine = $doctrine;

        return $this;
    }

    /**
     * Add a number to the input array
     *
     * @param number $number
     */
    public function enterNumber($number)
    {
        $this->numbers[] = $number;
    }

    /**
     * Compute a math operation
     *
     * @param string $operator
     * @return null|number
     * @throws \Exception
     */
    public function calculate($operator)
    {
        $result = null;
        switch ($operator) {
            case self::OPERATION_ADD:
                $result = array_sum($this->numbers);
                break;
            default:
                throw new \Exception('Unknown operation ' . $operator);
        }

        $this->operator = $operator;
        $this->result = $result;

        $this->save();
    }

    /**
     * Save the calculation
     */
    private function save()
    {
        $calculator = new Calculator();
        $calculator->setFirst($this->numbers[0]);
        $calculator->setSecond($this->numbers[1]);
        $calculator->setOperator($this->operator);
        $calculator->setResult($this->result);
        $em = $this->getDoctrine()->getManager();
        $em->persist($calculator);
        $em->flush();
    }

    /**
     * Get the result
     *
     * @return number
     */
    public function getResult()
    {
        return $this->result;
    }
}
