<?php

namespace Client\Model;

use Core\Model\CoreModelTrait;

class Client
{
    use CoreModelTrait;

    public $id;
    public $name;
    public $cpf_cnpj;
    public $rg_ie;
    public $uf;
    public $city;
    public $address;
    public $user_id;
}
