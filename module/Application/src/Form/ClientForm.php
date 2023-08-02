<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element\Text;
use Zend\Form\Element\Csrf;
use  Zend\Db\Adapter\Adapter;
use Application\Form\Filter\ClientFilter;
use Zend\Form\Element\Hidden;

class ClientForm extends Form
{
    public function __construct(Adapter $adapter)
    {
        parent::__construct('client', []);

        $this->setInputFilter(new ClientFilter($adapter));

        $this->setAttributes(['method' => 'POST']);

        $id = new Hidden('id');

        $this->add($id);

        $name = new Text('name');
        $name->setLabel('Nome completo');
        $name->setAttributes([
            'class' => 'form-control',
            'maxlength' => 120
        ]);

        $this->add($name);

        $cpf_cnpj = new Text('cpf_cnpj');
        $cpf_cnpj->setLabel('CPF/CNPJ');
        $cpf_cnpj->setAttributes([
            'class' => 'form-control',
            'maxlength' => 20
        ]);

        $this->add($cpf_cnpj);

        $rg_ie = new Text('rg_ie');
        $rg_ie->setLabel('RG/Inscrição Estadual');
        $rg_ie->setAttributes([
            'class' => 'form-control',
            'maxlength' => 20
        ]);

        $this->add($rg_ie);

        $uf = new Text('uf');
        $uf->setLabel('Estado');
        $uf->setAttributes([
            'class' => 'form-control',
            'maxlength' => 120
        ]);

        $this->add($uf);

        $city = new Text('city');
        $city->setLabel('Cidade');
        $city->setAttributes([
            'class' => 'form-control',
            'maxlength' => 120
        ]);

        $this->add($city);

        $address = new Text('address');
        $address->setLabel('Endereço');
        $address->setAttributes([
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
