<?php

namespace EverestBill\Domains;

use Illuminate\Session\SessionManager;

class CustomerFlow
{
    /**
     * SessionManager instance
     * 
     * @var SessionManager
     */
    public $session;

    /**
     * Plan constructor
     * 
     * @param SessionManager $session
     */
    public function __construct(
        SessionManager $session
    )
    {
        $this->session  = $session;
    }

    /**
     * Check if the customer flow is in session
     * 
     * @return boolean
     */
    public function isInSession()
    {
        if (
            $this->session->has('plan_id') and 
            $this->session->has('domain_name') and
            $this->session->has('domain_extension')
        ) {
            return true;
        }
        
        return false;
    }
}