<?php

namespace MailerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User implements UserInterface
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="password", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users", cascade={"all"})
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="UserRole", mappedBy="user", cascade={"all"})
     */
    private $userRoles;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        $result = json_encode([
            $this->roles,
            $this->name,
            $this->id
        ]);
        if (json_last_error()) {
            trigger_error("Cannot encode json");
        }

        return $result;
    }

    /**
     * @return array The user roles
     */
    public function getRoles()
    {
        $roles = [];
        foreach ($this->userRoles as $userRole) {
            $roles[] = $userRole->getRole();
        }
        return $roles;
    }

    /**
     * @return string The password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @return string The username
     */
    public function getUsername()
    {
        return $this->name;
    }

    public function eraseCredentials()
    {
    }

    public function getUserRoles()
    {
        return $this->userRoles;
    }

    public function setUserRoles($userRoles = [])
    {
        $this->userRoles = $userRoles;
    }

    public function addUserRole(UserRole $role)
    {
        $this->userRoles[] = $role;
    }
}
