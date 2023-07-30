<?php

namespace Client\Form;

use Zend\Form\Form;
use Zend\Form\Element\Text;
use Zend\Form\Element\Csrf;
use  Zend\Db\Adapter\Adapter;
use Client\Form\Filter\ClientFilter;

class ClientForm extends Form
{
    public function __construct(Adapter $adapter)
    {
        parent::__construct('client', []);

        $this->setInputFilter(new ClientFilter($adapter));

        $this->setAttributes(['method' => 'POST']);

        $name = new Text('name');
        $name->setAttributes([
            'placeholder' => 'Nome completo',
            'class' => 'form-control',
            'maxlength' => 120
        ]);

        $this->add($name);

        $cpf_cnpj = new Text('cpf_cnpj');
        $cpf_cnpj->setAttributes([
            'placeholder' => 'CPF/CNPJ',
            'class' => 'form-control',
            'maxlength' => 20
        ]);

        $this->add($cpf_cnpj);

        $rg_ie = new Text('rg_ie');
        $rg_ie->setAttributes([
            'placeholder' => 'RG/Inscrição Estadual',
            'class' => 'form-control',
            'maxlength' => 20
        ]);

        $this->add($rg_ie);

        $uf = new Text('uf');
        $uf->setAttributes([
            'placeholder' => 'Estado',
            'class' => 'form-control',
            'maxlength' => 120
        ]);

        $this->add($uf);

        $city = new Text('city');
        $city->setAttributes([
            'placeholder' => 'Cidade',
            'class' => 'form-control',
            'maxlength' => 120
        ]);

        $this->add($city);

        $address = new Text('address');
        $address->setAttributes([
            'placeholder' => 'Endereço',
            'class' => 'form-control',
            'maxlength' => 255
        ]);

        $this->add($address);

        $csrf = new Csrf('csrf');
        $csrf->setOptions([
            'csrf_options' => [
                'timeout' => 600,
            ],
        ]);

        $this->add($csrf);
    }
}
