<?php

class Car 
{
    private $id;
    private $marque;
    private $modele;
    private $annee;
    private $conso;
    private $color;
    private $prix_trois_jours;
    private $puissance;
    private $moteur;
    private $carburant;
    private $cent;
    private $nombre_de_place;
    private $nombre_de_voiture;
    private $id_category;
    private $image_url;
    private $name;

    public function __construct() {}
    

    /**
     * Get the value of id
     */ 
    public function get_id()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function set_id($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of marque
     */ 
    public function get_marque()
    {
        return $this->marque;
    }

    /**
     * Set the value of marque
     *
     * @return  self
     */ 
    public function set_marque($marque)
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * Get the value of modele
     */ 
    public function get_modele()
    {
        return $this->modele;
    }

    /**
     * Set the value of modele
     *
     * @return  self
     */ 
    public function set_modele($modele)
    {
        $this->modele = $modele;

        return $this;
    }

    /**
     * Get the value of annee
     */ 
    public function get_annee()
    {
        return $this->annee;
    }

    /**
     * Set the value of annee
     *
     * @return  self
     */ 
    public function set_annee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get the value of conso
     */ 
    public function get_conso()
    {
        return $this->conso;
    }

    /**
     * Set the value of conso
     *
     * @return  self
     */ 
    public function set_conso($conso)
    {
        $this->conso = $conso;

        return $this;
    }

    /**
     * Get the value of color
     */ 
    public function get_color()
    {
        return $this->color;
    }

    /**
     * Set the value of color
     *
     * @return  self
     */ 
    public function set_color($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get the value of prix_trois_jours
     */ 
    public function get_prix_trois_jours()
    {
        return $this->prix_trois_jours;
    }

    /**
     * Set the value of prix_trois_jours
     *
     * @return  self
     */ 
    public function set_prix_trois_jours($prix_trois_jours)
    {
        $this->prix_trois_jours = $prix_trois_jours;

        return $this;
    }

    /**
     * Get the value of puissance
     */ 
    public function get_puissance()
    {
        return $this->puissance;
    }

    /**
     * Set the value of puissance
     *
     * @return  self
     */ 
    public function set_puissance($puissance)
    {
        $this->puissance = $puissance;

        return $this;
    }

    /**
     * Get the value of moteur
     */ 
    public function get_moteur()
    {
        return $this->moteur;
    }

    /**
     * Set the value of moteur
     *
     * @return  self
     */ 
    public function set_moteur($moteur)
    {
        $this->moteur = $moteur;

        return $this;
    }

    /**
     * Get the value of carburant
     */ 
    public function get_carburant()
    {
        return $this->carburant;
    }

    /**
     * Set the value of carburant
     *
     * @return  self
     */ 
    public function set_carburant($carburant)
    {
        $this->carburant = $carburant;

        return $this;
    }

    /**
     * Get the value of cent
     */ 
    public function get_cent()
    {
        return $this->cent;
    }

    /**
     * Set the value of cent
     *
     * @return  self
     */ 
    public function set_cent($cent)
    {
        $this->cent = $cent;

        return $this;
    }

    /**
     * Get the value of nombre_de_place
     */ 
    public function get_nombre_de_place()
    {
        return $this->nombre_de_place;
    }

    /**
     * Set the value of nombre_de_place
     *
     * @return  self
     */ 
    public function set_nombre_de_place($nombre_de_place)
    {
        $this->nombre_de_place = $nombre_de_place;

        return $this;
    }

    /**
     * Get the value of nombre_de_voiture
     */ 
    public function get_nombre_de_voiture()
    {
        return $this->nombre_de_voiture;
    }

    /**
     * Set the value of nombre_de_voiture
     *
     * @return  self
     */ 
    public function set_nombre_de_voiture($nombre_de_voiture)
    {
        $this->nombre_de_voiture = $nombre_de_voiture;

        return $this;
    }

    /**
     * Get the value of id_category
     */ 
    public function get_id_category()
    {
        return $this->id_category;
    }

    /**
     * Set the value of id_category
     *
     * @return  self
     */ 
    public function set_id_category($id_category)
    {
        $this->id_category = $id_category;

        return $this;
    }

    /**
     * Get the value of image_url
     */ 
    public function get_image_url()
    {
        return $this->image_url;
    }

    /**
     * Set the value of image_url
     *
     * @return  self
     */ 
    public function set_image_url($image_url)
    {
        $this->image_url = $image_url;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function get_name()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function set_name($name)
    {
        $this->name = $name;

        return $this;
    }
}