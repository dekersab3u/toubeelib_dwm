<?php

namespace rdv\core\dto;

use rdv\core\dto\DTO;

class SpecialiteDTO extends DTO
{
    protected string $ID;
    protected string $label;
    protected string $description;

    public function __construct(string $ID, string $label, string $description)
    {
        $this->ID = $ID;
        $this->label = $label;
        $this->description = $description;
    }
}