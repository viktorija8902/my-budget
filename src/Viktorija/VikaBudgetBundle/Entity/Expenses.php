<?php
/**
 * Created by PhpStorm.
 * User: Viktorija
 * Date: 6/22/2015
 * Time: 1:07 PM
 */

namespace Viktorija\VikaBudgetBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Viktorija\VikaBudgetBundle\Entity\BudgetUser;
use Viktorija\VikaBudgetBundle\Entity\InDetail\ExpensesInDetail;

/**
 * @ORM\Table(name="I_spent")
 * @ORM\Entity(repositoryClass="Viktorija\VikaBudgetBundle\Entity\ExpensesRepository")
 */
class Expenses {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $expenseType;


    /**
     * @ORM\Column(type="string", length=100)
     */
    private $picture;

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
    public function getExpenseType()
    {
        return $this->expenseType;
    }

    /**
     * @param mixed $expenseType
     */
    public function setExpenseType($expenseType)
    {
        $this->expenseType = $expenseType;
    }


    /**
    * @return mixed
    */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
    * @param mixed $picture
    */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }


    /**
     * @ORM\ManyToOne(targetEntity="Viktorija\VikaBudgetBundle\Entity\BudgetUser", inversedBy="expenses")
     * @ORM\JoinColumn(name="budgetUser_id", referencedColumnName="id")
     */
    protected $budgetUser;


    /**
     * Set budgetUser
     *
     * @param BudgetUser $budgetUser
     * @return Expenses
     */
    public function setBudgetUser(BudgetUser $budgetUser = null)
    {
        $this->budgetUser = $budgetUser;

        return $this;
    }

    /**
     * Get budgetUser
     * @return BudgetUser
     */
    public function getBudgetUser()
    {
        return $this->budgetUser;
    }

    /**
     * @ORM\OneToMany(targetEntity="Viktorija\VikaBudgetBundle\Entity\InDetail\ExpensesInDetail", mappedBy="expenses")
     */
    protected $detailedExpenses;

    public function __construct()
    {
        $this->detailedExpenses = new ArrayCollection();
    }


    /**
     * Add detailedExpenses
     *
     * @param ExpensesInDetail $detailedExpenses
     * @return Expenses
     */
    public function addDetailedExpense(ExpensesInDetail $detailedExpenses)
    {
        $this->detailedExpenses[] = $detailedExpenses;

        return $this;
    }

    /**
     * Remove detailedExpenses
     *
     * @param ExpensesInDetail $detailedExpenses
     */
    public function removeDetailedExpense(ExpensesInDetail $detailedExpenses)
    {
        $this->detailedExpenses->removeElement($detailedExpenses);
    }

    /**
     * Get detailedExpenses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDetailedExpenses()
    {
        return $this->detailedExpenses;
    }
}
