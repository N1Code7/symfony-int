<?php 

  namespace App\DTO;

  class SearchAuthorCriteria {
    public ?string $name = null; 

    public ?string $orderBy = "id";

    public ?string $direction = "DESC";

    public ?int $limit = 25;

    public ?int $page = 1;
  }
