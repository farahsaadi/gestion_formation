<?php
namespace App\Entity;

use App\Entity\Formation;

class FormationSearch
{
    private ?Formation $formation = null;

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): self
    {
        $this->formation = $formation;
        return $this;
    }
}
