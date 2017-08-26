<?php

namespace EverestBill\Adapters;

use EverestBill\Translators\Cpanel as CpanelTranslator;

class Cpanel
{
    /**
     * Cpanel Adapter constructor.
     *
     * @param CpanelTranslator $translator
     */
    public function __construct(CpanelTranslator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Create a new cpanel account
     *
     * @return object
     */
    public function createCpanelAccount()
    {
        $response = $this->translator->get('json-api/createacct', [
            'api.version'               => 1,
            'username'                  => 'user' . rand(),
            'domain'                    => 'everestbill-'. rand().'.com',
            'plan'                      => 'package_name',
            'featurelist'               => 'default',
            'quota'                     => 0,
            'password'                  => substr(md5(uniqid()), 0, 8),
            'cgi'                       => 1,
            'hasshell'                  => 0,
            'contactemail'              => 'user@everestbill.com',
            'cpmod'                     => 'paper_lantern',
            'maxftp'                    => 5,
            'maxsql'                    => 5,
            'maxpop'                    => 5,
            'maxlst'                    => 5,
            'maxsub'                    => 1,
            'maxpark'                   => 1,
            'maxaddon'                  => 1,
            'bwlimit'                   => 500,
            'language'                  => 'en',
            'useregns'                  => 1,
            'hasuseregns'               => 1,
            'reseller'                  => 0,
            'mxcheck'                   => 'local',
            'max_email_per_hour'        => 100,
            'max_defer_fail_percentage' => 80,
        ]);

        $decodedBody = json_decode($response);

        return $decodedBody;
    }
}