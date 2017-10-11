<?php

namespace EverestBill\Repositories;

use Exception;
use EverestBill\Models\Domain as DomainModel;

class Domain
{
    public function __construct(DomainModel $domain)
    {
        $this->domain = $domain;
    }

    /**
     * Save domain to the database
     *
     * @param array $data
     */
    public function create($data)
    {
        $this->domain->user_id   = $data['user_id'];
        $this->domain->name      = $data['domain_name'];
        $this->domain->extension = $data['domain_extension'];

        if (!$this->domain->save()) {
            throw new Exception('Unable to save data to the database');
        }

        return $this->domain->id;
    }

    public function getAll()
    {
        return $this->domain->all();
    }
}