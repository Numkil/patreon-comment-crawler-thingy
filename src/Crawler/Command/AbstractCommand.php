<?php

namespace Crawler\Command;

use Cilex\Provider\Console\Command;
use Crawler\Traits\IOTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AbstractCommand
 * @package Crawler\Command
 */
abstract class AbstractCommand extends Command
{
   use IOTrait;

    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected  $output;

    /**
     * @param  InputInterface $input
     * @param  OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        try {
            $this->doPreExecute();
            $this->doExecute($input, $output);
        } catch (\Exception $ex) {
            echo($ex->getMessage());
        }
    }

    /**
     * @return mixed
     */
    abstract protected function doExecute();

    /**
     *
     */
    private function doPreExecute()
    {
        if (!$this->input->getOption('hideLogo')) {
            $this->output->writeln("Executing " . get_class($this));
        }
        $this->setUpIO($this->input, $this->output);
    }

    /**
     * @return $this
     */
    public function addDefaults()
    {
        $this
            ->addOption("--hideLogo", null, InputOption::VALUE_NONE, 'If set, no logo or statistics will be shown');
        return $this;
    }
}