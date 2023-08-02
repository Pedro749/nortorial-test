<?php

namespace Protocol\Form;

use Zend\Form\Form;
use Zend\Form\Element\Text;
use Zend\Form\Element\Csrf;
use Protocol\Form\Filter\ProtocolFilter;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Textarea;

class ProtocolForm extends Form
{
    public function __construct()
    {
        parent::__construct('protocol', []);

        $this->setInputFilter(new ProtocolFilter());
        $this->setAttributes(['method' => 'POST']);

        $id = new Hidden('id');

        $this->add($id);

        $applicant = new Text('applicant');
        $applicant->setLabel('Requerente');
        $applicant->setAttributes([
            'class' => 'form-control',
            'maxlength' => 120
        ]);

        $this->add($applicant);

        $cpf_cnpj = new Text('cpf_cnpj');
        $cpf_cnpj->setLabel('CPF/CNPJ');
        $cpf_cnpj->setAttributes([
            'class' => 'form-control',
            'maxlength' => 20
        ]);

        $this->add($cpf_cnpj);

        $subject = new Textarea('subject');
        $subject->setLabel('Assunto');
        $subject->setAttributes([
            'class' => 'form-control',
            'maxlength' => 255
        ]);

        $this->add($subject);

        $csrf = new Csrf('csrf');
        $csrf->setOptions([
            'csrf_options' => [
                'timeout' => 600,
            ],
        ]);

        $this->add($csrf);
    }
}
