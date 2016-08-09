<?php

namespace Admin\View\Helper;

use Zend\Authentication\AuthenticationService;
use Zend\View\Helper\AbstractHelper;

class AuthHelper extends AbstractHelper {

    public function getAdmin() {
        $auth = new AuthenticationService();
        $storage = $auth->getStorage();
        return $storage->read();
    }

}
