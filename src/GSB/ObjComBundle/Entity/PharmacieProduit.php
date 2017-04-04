<?php

namespace GSB\ObjComBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PharmacieProduit
 *
 * @ORM\Table(name="pharmacie_produit")
 * @ORM\Entity(repositoryClass="GSB\ObjComBundle\Repository\PharmacieProduitRepository")
 */
class PharmacieProduit
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float")
     */
    private $montant;

    /**
     *
     * @ORM\ManyToOne(targetEntity="GSB\ObjComBundle\Entity\Pharmacie")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pharmacie;

    /**
     *
     * @ORM\ManyToOne(targetEntity="GSB\ObjComBundle\Entity\Produit")
     * @ORM\JoinColumn(nullable=false)
     */
    private $produit;


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
     * Set montant
     *
     * @param float $montant
     * @return PharmacieProduit
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return float 
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set pharmacie
     *
     * @param \GSB\ObjComBundle\Entity\Pharmacie $pharmacie
     * @return PharmacieProduit
     */
    public function setPharmacie(\GSB\ObjComBundle\Entity\Pharmacie $pharmacie)
    {
        $this->pharmacie = $pharmacie;

        return $this;
    }

    /**
     * Get pharmacie
     *
     * @return \GSB\ObjComBundle\Entity\Pharmacie 
     */
    public function getPharmacie()
    {
        return $this->pharmacie;
    }

    /**
     * Set produit
     *
     * @param \GSB\ObjComBundle\Entity\Produit $produit
     * @return PharmacieProduit
     */
    public function setProduit(\GSB\ObjComBundle\Entity\Produit $produit)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return \GSB\ObjComBundle\Entity\Produit 
     */
    public function getProduit()
    {
        return $this->produit;
    }
}
