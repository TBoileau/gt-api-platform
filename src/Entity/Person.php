<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\PersonRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotIdenticalTo;

#[ApiResource(
    collectionOperations: [
        'get',
        'post'
    ],
    itemOperations: [
        'get',
        'delete',
        'put'
    ],
    attributes: [
        'pagination_enabled' => false
    ]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'firstName' => SearchFilter::STRATEGY_PARTIAL,
    'lastName' => SearchFilter::STRATEGY_PARTIAL,
])]
#[ApiFilter(OrderFilter::class, properties: ['firstName', 'lastName'], arguments: ['orderParameterName' => 'order'])]
#[ORM\Entity(repositoryClass: PersonRepository::class)]
class Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['item'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[NotBlank]
    #[Groups(['item'])]
    private string $firstName;

    #[ORM\Column(type: 'string', length: 255)]
    #[NotBlank]
    #[NotIdenticalTo(propertyPath: 'firstName')]
    #[Groups(['item'])]
    private string $lastName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }
}
