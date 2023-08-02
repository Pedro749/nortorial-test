<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Client\Model\ClientTable;
use Zend\View\Model\ViewModel;
use Protocol\Model\ProtocolTable;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    protected $clientTable;
    protected $protocolTable;

    public function __construct(ClientTable $clientTable, ProtocolTable $protocolTable)
    {
        $this->clientTable = $clientTable;
        $this->protocolTable = $protocolTable;
    }
    public function indexAction()
    {
        return new ViewModel();
    }
}
