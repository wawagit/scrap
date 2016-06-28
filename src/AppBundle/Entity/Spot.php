<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use CoreCommonBundle\Entity\Traits\InsertUpdateDateTimeTrait;
use Gedmo\Mapping\Annotation as Gedmo;
use DoctrineProxyBundle\Annotations\TableType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use CoreCommonBundle\Util\Canonicalizer;

/**
 * Spot
 *
 * @ORM\Table(name="spot")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SpotRepository")
 */
class Spot {

    /**
     * @ORM\Column(name="spot_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="label", type="string")
     */
    private $label;

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
     * Set label
     *
     * @param string $label
     *
     * @return Spot
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }
}
