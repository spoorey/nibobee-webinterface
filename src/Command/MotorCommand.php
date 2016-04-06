<?php
/**
 * Created by PhpStorm.
 * User: David Spörri
 * Date: 23.03.2016
 * Time: 14:52
 */

namespace NiboLib\Command;


class MotorCommand implements CommandInterface {
    const SPEED_MAX = 2000;
    const DIRECTION_NEUTRAL = 'neutral';

    const DIRECTION_SOFT_LEFT = 's_left';
    const DIRECTION_LEFT = 'left';
    const DIRECTION_HARD_LEFT = 'h_left';
    const DIRECTION_ROTATE_LEFT = 'r_left';

    const DIRECTION_SOFT_RIGHT = 's_right';
    const DIRECTION_RIGHT = 'right';
    const DIRECTION_HARD_RIGHT = 'h_right';
    const DIRECTION_ROTATE_RIGHT = 'r_right';

    const REGISTER_PID = 9;
    const REGISTER_PWD_LEFT = 7;
    const REGISTER_PWD_RIGHT = 8;
    const REGISTER_MOTOR_STATUS = 6;

    const LEFT_CORRECTION = 0.9859154929577465;

    protected $motorStatus = '2';
    protected $speed = 0;


    /**
     * By how much the right and left engine speed will be multiplied.
     * These values must not be greater than 1.
     *
     * @var float
     */
    protected $leftMultiplier = 1;
    protected $rightMultiplier = 1;

    protected $leftPID = 20;
    protected $rightPID = 20;


    /**
     * @param int $speed
     */
    public function setSpeed($speed = 0)
    {
        $speed = (int)$speed;
        if ($speed > self::SPEED_MAX) {
            throw new \InvalidArgumentException('Max speed: ' . self::SPEED_MAX . '. Tried to set speed to ' . $speed);
        }

        $this->speed = $speed;
    }

    /**
     * @param string $direction
     */
    public function setDirection($direction = null)
    {
        switch ($direction) {
            case (self::DIRECTION_SOFT_LEFT):
                $this->setLeftMultiplier(0.75);
                $this->setRightMultiplier(1);

                break;
            case (self::DIRECTION_LEFT):
                $this->setLeftMultiplier(0.5);
                $this->setRightMultiplier(1);

                break;
            case (self::DIRECTION_HARD_LEFT):
                $this->setLeftMultiplier(0.25);
                $this->setRightMultiplier(1);

                break;
            case (self::DIRECTION_ROTATE_LEFT):
                $this->setLeftMultiplier(0);
                $this->setRightMultiplier(1);

                break;
            case (self::DIRECTION_ROTATE_RIGHT):
                $this->setLeftMultiplier(1);
                $this->setRightMultiplier(0);

                break;

            case (self::DIRECTION_SOFT_RIGHT):
                $this->setRightMultiplier(0.75);
                $this->setLeftMultiplier(1);

                break;
            case (self::DIRECTION_RIGHT):
                $this->setRightMultiplier(0.5);
                $this->setLeftMultiplier(1);
                break;
            case (self::DIRECTION_HARD_RIGHT):
                $this->setRightMultiplier(0.25);
                $this->setLeftMultiplier(1);

                break;
            case (self::DIRECTION_NEUTRAL):
            default:
            $this->setRightMultiplier(1);
            $this->setLeftMultiplier(1);

            break;
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCommand()
    {
        $leftSpeed = $this->speed * $this->getLeftMultiplier();
        $rightSpeed = $this->speed * $this->getRightMultiplier();
        $leftSpeed *= self::LEFT_CORRECTION;
        $leftSpeed = (int) $leftSpeed;
        $rightSpeed = (int) $rightSpeed;

        return
            'set ' . self::REGISTER_MOTOR_STATUS . ', ' . $this->motorStatus .
            ' set ' . self::REGISTER_PID . ', ' . $this->rightPID .
            ' set ' . self::REGISTER_PWD_LEFT . ', ' . $leftSpeed .
            ' set ' . self::REGISTER_PWD_RIGHT . ', ' . $rightSpeed;
    }

    /**
     * @return int
     */
    public function getRightMultiplier()
    {
        return $this->rightMultiplier;
    }

    /**
     * @param int $rightMultiplier
     */
    public function setRightMultiplier($rightMultiplier)
    {
        if ($rightMultiplier > 1) {
            throw new \InvalidArgumentException('Right multiplier may not be bigger than 1!');
        }

        $this->rightMultiplier = $rightMultiplier;
    }

    /**
     * @return float
     */
    public function getLeftMultiplier()
    {
        return $this->leftMultiplier;
    }

    /**
     * @param float $leftMultiplier
     */
    public function setLeftMultiplier($leftMultiplier)
    {
        if ($leftMultiplier > 1) {
            throw new \InvalidArgumentException('Left multiplier may not be bigger than 1!');
        }

        $this->leftMultiplier = $leftMultiplier;
    }

    /**
     * Only call this, if you do not want to use the NiboBees engines before restarting the robot!
     */
    public function killEngines(){
        $this->motorStatus = 0;
        return $this;
    }
}
 