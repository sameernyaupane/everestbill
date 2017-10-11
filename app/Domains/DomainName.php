<?php

namespace EverestBill\Domains;

use EverestBill\Decorators\Domain as DomainDecorator;
use EverestBill\Repositories\Domain as DomainRepository;

class DomainName
{
    /**
     * DomainNameDecorator instance
     *
     * @var DomainNameDecorator
     */
    public $domainDecorator;

    /**
     * DomainNameRepository instance
     *
     * @var DomainNameRepository
     */
    public $domainRepository;

    /**
     * Plan constructor
     *
     * @param DomainDecorator  $domainDecorator
     * @param DomainRepository $domainRepository
     */
    public function __construct(
        DomainDecorator $domainDecorator,
        DomainRepository $domainRepository
    ) {
        $this->domainDecorator  = $domainDecorator;
        $this->domainRepository = $domainRepository;
    }

    /**
     * Get all the plans from the database
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        $plans = $this->domainRepository->getAll();

        return $this->domainDecorator->decorateAll($plans);
    }
}