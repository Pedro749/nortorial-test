<?php

namespace Client\Form\Filter;

use Zend\InputFilter\Input;
use Zend\Validator\NotEmpty;
use Zend\Db\Adapter\Adapter;
use Zend\Validator\StringLength;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Db\NoRecordExists;

class ClientFilter extends InputFilter
{
    public function __construct(Adapter $adapter)
    {
        $name = new Input('name');
        $name->setRequired(true)
            ->getFilterChain()
            ->attachByName('stringtrim')
            ->attachByName('StripTags');

        $name->getValidatorChain()
            ->attach(new NotEmpty())
            ->attach(new StringLength(['max' => 120]));

        $this->add($name);

        $cpf_cnpj = new Input('cpf_cnpj');
        $cpf_cnpj->setRequired(true)
            ->getFilterChain()
            ->attachByName('stringtrim')
            ->attachByName('StripTags');

        $cpf_cnpj->getValidatorChain()
            ->attach(new NotEmpty())
            ->attach(new StringLength(['max' => 20, 'min' => 14]))
            ->attach(new NoRecordExists([
                'table' => 'clients',
                'field' => 'cpf_cnpj',
                'adapter' => $adapter,
                'messages' => [
                    'recordFound' => 'Este cliente já está cadastrado!',
                ],
            ]));

        $this->add($cpf_cnpj);

        $rg_ie = new Input('rg_ie');
        $rg_ie->setRequired(false)
            ->getFilterChain()
            ->attachByName('stringtrim')
            ->attachByName('StripTags');

        $rg_ie->getValidatorChain()
            ->attach(new StringLength(['max' => 120]));

        $this->add($rg_ie);

        $uf = new Input('uf');
        $uf->setRequired(false)
            ->getFilterChain()
            ->attachByName('stringtrim')
            ->attachByName('StripTags');

        $uf->getValidatorChain()
            ->attach(new StringLength(['max' => 120]));

        $this->add($uf);

        $city = new Input('city');
        $city->setRequired(false)
            ->getFilterChain()
            ->attachByName('stringtrim')
            ->attachByName('StripTags');

        $city->getValidatorChain()
            ->attach(new StringLength(['max' => 120]));

        $this->add($city);

        $address = new Input('address');
        $address->setRequired(false)
            ->getFilterChain()
            ->attachByName('stringtrim')
            ->attachByName('StripTags');

        $address->getValidatorChain()
            ->attach(new StringLength(['max' => 120]));

        $this->add($address);
    }
}
