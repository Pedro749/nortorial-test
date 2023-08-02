<?php

namespace Protocol\Model;

use Core\Model\CoreModelTrait;

class Protocol
{
    use CoreModelTrait;

    public $id;
    public $applicant;
    public $cpf_cnpj;
    public $subject;
    public $user_id;
}
