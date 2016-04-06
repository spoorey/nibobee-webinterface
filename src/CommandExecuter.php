<?php
/**
 * Created by PhpStorm.
 * User: David Spörri
 * Date: 23.03.2016
 * Time: 11:00
 */

namespace NiboLib;

use COM;
use DateTime;
use NiboLib\Command\CommandInterface;

class CommandExecuter
{
    protected $com = 'COM5';

    protected $fileDir = null;

    public function executeCommands(array $commands)
    {
        $exec = 'request';
        foreach ($commands as $command) {
            if ($command instanceof CommandInterface) {
                $exec .= ' ' . $command->getCommand();
            }
        }

        $cmd = 'echo ' . $exec . ' > ' . $this->getCOM();

        $fileName = $this->getFileName();

        $ext = '.bat';
        $fileDir = $this->getFileDir();
        $batFile = $fileDir . $fileName . $ext;

        /*
        while (is_file($batFile)) {
            $batFile = $fileDir . $this->getFileName() . $ext;
        }
        */
        if (is_file($batFile)) {
            unlink($batFile);
        }

        file_put_contents($batFile, $cmd);
        $cmd = 'sh ' . $batFile;

        $cmd = file_get_contents(__DIR__ . '/../command.bat');
        $cmd = trim($cmd);

        echo 'run: ' . $cmd . PHP_EOL;
        //file_put_contents('command.bat', $cmd);
        $cmd = file_get_contents(getcwd() . '/command.bat');
        $starttime = microtime(true);
        echo exec($cmd);
        $endtime = microtime(true);
        $time_taken = $endtime - $starttime;
    }

    /**
     * @return mixed
     */
    public function getCom()
    {
        return $this->com;
    }

    /**
     * @param mixed $com
     */
    public function setCom($com)
    {
        $this->com = $com;
    }

    /**
     * @return null
     */
    public function getFileDir()
    {
        return (null == $this->fileDir ? __DIR__ . '/../data/bats/' : $this->fileDir);
    }

    /**
     * @param null $fileDir
     */
    public function setFileDir($fileDir)
    {
        $this->fileDir = $fileDir;
    }

    /**
     * @return string
     */
    protected function getFileName()
    {
        /*$dateTime = new DateTime();
        $fileName = 'temp-' . $dateTime->format('Y-m-d-H-i-');
        $seconds = (int)$dateTime->format('s');
        $seconds = $seconds / 10;
        $fileName .= (int)$seconds;*/
        $fileName = 'command';

        return $fileName;
    }


}
 