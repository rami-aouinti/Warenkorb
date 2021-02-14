<?php

namespace App\Traits;

use Exception;
use Doctrine\ORM\Mapping as ORM;

trait ResourceId
{

   /**
     * @var int|null
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private ?int $id = null;

    
    public function getId(): ?int
    {
        return $this->id;
    }
}