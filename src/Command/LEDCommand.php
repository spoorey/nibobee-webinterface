<?php
/**
 * Created by PhpStorm.
 * User: David Spörri
 * Date: 23.03.2016
 * Time: 11:02
 */

namespace NiboLib\Command;


class LEDCommand extends AbstractCommand
{
    protected $activeLEDs;

    /**
     * @return $this
     */
    public function startLED0()
    {
        $this->activeLEDs['LED-0'] = 'LED-0';

        return $this;
    }

    /**
     * @return $this
     */
    public function startLED1()
    {
        $this->activeLEDs['LED-1'] = 'LED-1';

        return $this;
    }


    /**
     * @return $this
     */
    public function startLED2()
    {
        $this->activeLEDs['LED-2'] = 'LED-2';

        return $this;
    }

    /**
     * @return $this
     */
    public function startLED3()
    {
        $this->activeLEDs['LED-3'] = 'LED-3';

        return $this;
    }

    /**
     * @return $this
     */
    public function stopLED0()
    {
        if (isset($this->activeLEDs['LED-0'])) {
            unset($this->activeLEDs['LED-0']);
        }

        return $this;
    }


    /**
     * @return $this
     */
    public function stopLED1()
    {
        if (isset($this->activeLEDs['LED-1'])) {
            unset($this->activeLEDs['LED-1']);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function stopLED2()
    {
        if (isset($this->activeLEDs['LED-2'])) {
            unset($this->activeLEDs['LED-2']);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function stopLED3()
    {
        if (isset($this->activeLEDs['LED-3'])) {
            unset($this->activeLEDs['LED-3']);
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function led0Active()
    {
        return (isset($this->activeLEDs['LED-0']) && $this->activeLEDs['LED-0'] == 'LED-0');
    }

    /**
     * @return bool
     */
    public function led1Active()
    {
        return (isset($this->activeLEDs['LED-1']) && $this->activeLEDs['LED-1'] == 'LED-1');
    }

    /**
     * @return bool
     */
    public function led2Active()
    {
        return (isset($this->activeLEDs['LED-2']) && $this->activeLEDs['LED-2'] == 'LED-2');
    }

    /**
     * @return bool
     */
    public function led3Active()
    {
        return (isset($this->activeLEDs['LED-3']) && $this->activeLEDs['LED-3'] == 'LED-3');
    }

    /**
     * @return string
     */
    function getRegister()
    {
        return '3';
    }


    /**
     * @throws \Exception
     * @return mixed
     */
    function getValue()
    {
        if ($this->led1Active() && $this->led2Active() && $this->led3Active()) {
            return '30';
        } elseif ($this->led1Active() && $this->led3Active() && count($this->activeLEDs) == 2) {
            return '10';
        } elseif ($this->led2Active() && count($this->activeLEDs) == 1) {
            return '20';
        } elseif ($this->led0Active() && count($this->activeLEDs) == 1) {
            return '5';
        } elseif ($this->led0Active() && $this->led3Active() && count($this->activeLEDs) == 2) {
            return '25';
        } elseif ($this->led0Active() && $this->led1Active() && count($this->activeLEDs) == 2) {
            return '35';
        } elseif ($this->led3Active() && count($this->activeLEDs) == 1) {
            return '40';
        } elseif (count($this->activeLEDs) == 0)  {
            return '0';
        } else {
            throw new \Exception('Could not find value for led settings: ' . print_r($this->activeLEDs, true));
        }
    }
}
 