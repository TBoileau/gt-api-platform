<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;

final class RandomMovie
{
    public function __construct(private MovieRepository $movieRepository)
    {
    }

    public function __invoke(): Movie
    {
        return $this->movieRepository->getRandomMovie();
    }
}
