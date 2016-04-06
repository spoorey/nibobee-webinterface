<?php
/**
 * Created by PhpStorm.
 * User: David Spörri
 * Date: 23.03.2016
 * Time: 11:02
 */

namespace NiboLib\Command;


abstract class AbstractCommand implements CommandInterface {
    public function getCommand(){
        return 'set ' . $this->getRegister() . ', ' . $this->getValue();
    }

    /**
     * @return mixed
     */
    abstract function getRegister();

    /**
     * @return mixed
     */
    abstract function getValue();
}
 