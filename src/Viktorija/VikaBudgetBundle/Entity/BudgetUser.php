<?php

//use Symfony\Component\Security\Core\Role\Role;

namespace Viktorija\VikaBudgetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Table(name="Users")
 * @ORM\Entity(repositoryClass="Viktorija\VikaBudgetBundle\Entity\UserRepository")
 * @UniqueEntity(fields="email", message="Email is already in use")
 * @UniqueEntity(fields="username", message="Username is already in use")
 */
class BudgetUser implements AdvancedUserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=100)
     */
    private $firstname;


    /**
    * @Assert\Range(
    *      min = 3,
    *      max = 123,
    *      minMessage = "You must be at least 3 to enter",
    *      maxMessage = "Nice try! Are you really older than the oldest person ever?"
    * )
    * @ORM\Column(type="integer")
    */
    private $age;


    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank()
     * @Assert\Length(min=5)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    public function __construct()
    {
        $this->isActive = true;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age)
    {
        $this->age = $age;
    }






    public function getUsername()
    {
        return $this->username;
    }

    public function getSalt()
    {
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->isActive
            ) = unserialize($serialized);
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return BudgetUser
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return BudgetUser
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return BudgetUser
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return BudgetUser
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }




    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }

    /**
    * @Assert\IsTrue(message = "The password cannot match your username")
    */
    public function isPasswordLegal()
    {
        return $this->username !== $this->password;
    }

    /**
     * @ORM\OneToMany(targetEntity="Viktorija\VikaBudgetBundle\Entity\Expenses", mappedBy="budgetUser")
     */
    protected $expenses;

    public function _construct()
    {
        $this->expenses = new ArrayCollection();
        $this->income = new ArrayCollection();
    }



    /**
     * Add expenses
     *
     * @param \Viktorija\VikaBudgetBundle\Entity\Expenses $expenses
     * @return BudgetUser
     */
    public function addExpense(\Viktorija\VikaBudgetBundle\Entity\Expenses $expenses)
    {
        $this->expenses[] = $expenses;

        return $this;
    }

    /**
     * Remove expenses
     *
     * @param \Viktorija\VikaBudgetBundle\Entity\Expenses $expenses
     */
    public function removeExpense(\Viktorija\VikaBudgetBundle\Entity\Expenses $expenses)
    {
        $this->expenses->removeElement($expenses);
    }

    /**
     * Get expenses
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExpenses()
    {
        return $this->expenses;
    }


    /**
     * @ORM\OneToMany(targetEntity="Viktorija\VikaBudgetBundle\Entity\Income", mappedBy="budgetUser")
     */
    protected $income;


    /**
     * @return mixed
     */
    public function getIncome()
    {
        return $this->income;
    }

    /**
     * @param mixed $income
     */
    public function setIncome($income)
    {
        $this->income = $income;
    }




    /**
     * Add income
     *
     * @param \Viktorija\VikaBudgetBundle\Entity\Income $income
     * @return BudgetUser
     */
    public function addIncome(\Viktorija\VikaBudgetBundle\Entity\Income $income)
    {
        $this->income[] = $income;

        return $this;
    }

    /**
     * Remove income
     *
     * @param \Viktorija\VikaBudgetBundle\Entity\Income $income
     */
    public function removeIncome(\Viktorija\VikaBudgetBundle\Entity\Income $income)
    {
        $this->income->removeElement($income);
    }
}
