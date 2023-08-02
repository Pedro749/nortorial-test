<?php

namespace Application\Form\Filter;

use Zend\InputFilter\Input;
use Zend\Validator\NotEmpty;
use Zend\Form\Element\Textarea;
use Zend\Validator\StringLength;
use Zend\InputFilter\InputFilter;

class ProtocolFilter extends InputFilter
{
    public function __construct()
    {
        $applicant = new Input('applicant');
        $applicant->setRequired(true)
            ->getFilterChain()
            ->attachByName('stringtrim')
            ->attachByName('StripTags');

        $applicant->getValidatorChain()
            ->attach(new NotEmpty())
            ->attach(new StringLength(['max' => 120]));

        $this->add($applicant);

        $cpf_cnpj = new Input('cpf_cnpj');
        $cpf_cnpj->setRequired(true)
            ->getFilterChain()
            ->attachByName('stringtrim')
            ->attachByName('StripTags');

        $cpf_cnpj->getValidatorChain()
            ->attach(new NotEmpty())
            ->attach(new StringLength(['max' => 20, 'min' => 14]));

        $this->add($cpf_cnpj);
    }
}
