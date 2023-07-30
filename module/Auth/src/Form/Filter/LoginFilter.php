<?php

namespace Auth\Form\Filter;

use Zend\InputFilter\Input;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;
use Zend\InputFilter\InputFilter;

class LoginFilter extends InputFilter
{
    public function __construct()
    {
        $email = new Input('email');
        $email->setRequired(true)
            ->getFilterChain()->attachByName('stringtrim')->attachByName('StripTags');
        $email->getValidatorChain()->attach(new NotEmpty())
            ->attach(new StringLength(['max' => 255]));

        $this->add($email);

        $password = new Input('password');
        $password->setRequired(true)
            ->getFilterChain()->attachByName('stringtrim')->attachByName('StripTags');
        $password->getValidatorChain()->attach(new NotEmpty())
            ->attach(new StringLength(['max' => 48, 'min' => 5]));

        $this->add($password);
    }
}
