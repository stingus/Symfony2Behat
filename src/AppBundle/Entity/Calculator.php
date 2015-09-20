<?php
/**
 * Contains the
 *
 * @author Arthur Kerpician <arthur@bluechip.ro>
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Calculator
 *
 * @ORM\Entity()
 * @ORM\Table(name="calculator")
 */
class Calculator
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(type="integer", nullable=false, options={"unique":true})
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $first;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $second;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10, nullable=false)
     */
    private $operator;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $result;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getFirst()
    {
        return $this->first;
    }

    /**
     * @param int $first
     * @return $this
     */
    public function setFirst($first)
    {
        $this->first = $first;

        return $this;
    }

    /**
     * @return int
     */
    public function getSecond()
    {
        return $this->second;
    }

    /**
     * @param int $second
     * @return $this
     */
    public function setSecond($second)
    {
        $this->second = $second;

        return $this;
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @param string $operator
     * @return $this
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;

        return $this;
    }

    /**
     * @return int
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param int $result
     * @return $this
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }
}
