<?php
/**
 * Created by PhpStorm.
 * User: Viktorija
 * Date: 7/9/2015
 * Time: 2:20 PM
 */

namespace Viktorija\VikaBudgetBundle\Entity\InDetail;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Table(name="All_expenses_in_detail")
 * @ORM\Entity(repositoryClass="Viktorija\VikaBudgetBundle\Entity\InDetail\ExpensesInDetailRepository")
 */
class ExpensesInDetail {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $itemPrice;

    /**
     * @ORM\Column(type="integer")
     */
    private $dateAdded;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function getItemPrice()
    {
        return $this->itemPrice;
    }

    /**
     * @param mixed $itemPrice
     */
    public function setItemPrice($itemPrice)
    {
        $this->itemPrice = $itemPrice;
    }

    /**
     * @return mixed
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * @param mixed $dateAdded
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;
    }


    /**
     * @ORM\ManyToOne(targetEntity="Viktorija\VikaBudgetBundle\Entity\Expenses", inversedBy="detailedExpenses")
     * @ORM\JoinColumn(name="expense_group_id", referencedColumnName="id")
     */
    protected $expenses;



    /**
     * Set expenses
     *
     * @param \Viktorija\VikaBudgetBundle\Entity\Expenses $expenses
     * @return ExpensesInDetail
     */

    public function setExpenses(\Viktorija\VikaBudgetBundle\Entity\Expenses $expenses = null)
    {
        $this->expenses = $expenses;

        return $this;
    }

    /**
     * Get expenses
     *
     * @return \Viktorija\VikaBudgetBundle\Entity\Expenses
     */
    public function getExpenses()
    {
        return $this->expenses;
    }
}
