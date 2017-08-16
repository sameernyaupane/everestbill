<?php

namespace EverestBill\Domains;

use Illuminate\Session\SessionManager;
use EverestBill\Repositories\Order as OrderRepository;
use EverestBill\Repositories\Domain as DomainRepository;

class Order
{
    /**
     * @var SessionManager
     */
    private $session;

    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * @var DomainRepository
     */
    private $domainRepository;

    public function __construct(
        SessionManager $session,
        OrderRepository $orderRepository,
        DomainRepository $domainRepository
    )
    {
        $this->session          = $session;
        $this->orderRepository  = $orderRepository;
        $this->domainRepository = $domainRepository;
    }

    /**
     * Save session items to the database
     *
     * @param $data
     */
    public function saveSessionItemsToDatabase($data)
    {
        $data['domain_id'] = $this->domainRepository->create($data);

        $this->orderRepository->create($data);
    }
}