<?php

namespace Crawler\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\Question;

/**
 * Class NewProjectCommand
 * @package Crawler\Command
 */
class CrawlCommand extends AbstractCommand
{

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->addDefaults()
            ->setName('crawl')
            ->setDescription('Crawl patreon')
            ->addArgument('url', InputArgument::REQUIRED, 'The url to the comments page')
            ->setHelp(<<<EOT
            Crawl a comment page on patreon and get all the users and their pledge level
EOT
            );
    }

    /**
     * @return mixed|void
     */
    protected function doExecute()
    {
        $url = $this->input->getArgument('url');
        $nameQuestion = 'What is your patreon account email?';
        $myName = $this->io->ask($nameQuestion);
        $passwordQuestion = 'What is your patreon account password?';
        $myPassword = $this->io->askHidden($passwordQuestion);
        $context = stream_context_create(array(
            'http' => array(
                'header' => "Authorization: Basic " . base64_encode("$myName:$myPassword")
            )
        ));

        // Get initial comments page
        $data = \file_get_contents($url, false, $context);
        $matches = [];

        /** Get list of the actual comments from the comments page */
        \preg_match('/https...www\.patreon\.com.api.posts.\d+.comments/', $data, $matches);
        $data = \file_get_contents($matches[0], false, $context);

        $comments = \json_decode($data, true);
        $comments = $comments['data'];
        $users = [];
        foreach ($comments as $comment) {
//            if ($comment['attributes']['is_by_patron']) {
            $userLink = ($comment['relationships']['commenter']['links']['related']);
            $data = \file_get_contents($userLink, false, $context);
            $userData = \json_decode($data, true);
            $userName = $userData['data']['attributes']['full_name'];

            $users[$userName] = 1;
//            }
        }

        $file = 'people.txt';
        \file_put_contents($file, '');
        foreach ($users as $user => $amount) {
            for ($i = 0; $i < $amount; $i++) {
                \file_put_contents($file, $user . "\n", FILE_APPEND | LOCK_EX);
            }
        }
    }
}
