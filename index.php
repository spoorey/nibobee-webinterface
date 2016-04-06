<?php
require_once 'vendor/autoload.php';
require_once 'template.php';
use NiboLib\Command\LEDCommand;
use NiboLib\Command\MotorCommand;
use NiboLib\CommandExecuter;


$executer = new CommandExecuter();
if (isset($_POST['back'])) {
    $command = new LEDCommand();
    $command->startLED3()->startLED1()->startLED2();

    $killCommand = new MotorCommand();
    $killCommand->killEngines();

    $executer->executeCommands([$command, $killCommand]);
} elseif (isset($_POST['speed']) && isset($_POST['direction'])) {
    $speed = (int)$_POST['speed'];
    $command = new MotorCommand();
    if ($speed <= 1500) {
        $command->setSpeed($speed);
    }

    switch ($_POST['direction']) {
        case 'left':
            $command->setDirection(MotorCommand::DIRECTION_LEFT);
            break;
        case 'right':
            $command->setDirection(MotorCommand::DIRECTION_RIGHT);
            break;
        case 'none':
            $command->setDirection(MotorCommand::DIRECTION_NEUTRAL);
            break;
        case 'h_left':
            $command->setDirection(MotorCommand::DIRECTION_HARD_LEFT);
            break;
        case 'h_right':
            $command->setDirection(MotorCommand::DIRECTION_HARD_RIGHT);
            break;
        case 'r_left':
            $command->setDirection(MotorCommand::DIRECTION_ROTATE_LEFT);
            break;
        case 'r_right':
            $command->setDirection(MotorCommand::DIRECTION_ROTATE_RIGHT);
            break;
        default:
            break;
    }


    $executer->executeCommands([$command]);
}