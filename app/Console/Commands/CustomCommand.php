<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// the name of the command is what users type after "php bin/console"
//#[AsCommand(name: 'do:create-user')]
class CustomCommand extends Command
{
    protected static $defaultName = 'do:create-user';
    protected static $defaultDescription = "simple command to create new user";

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // ... put here the code to create the user

        // this method must return an integer number with the "exit status code"
        // of the command. You can also use these constants to make code more readable

        $section1 = $output->section();

        $output->section()->writeln('Hello World!');
        // Output displays "Hello\nWorld!\n"

        // overwrite() replaces all the existing section contents with the given content
        $section1->overwrite('Goodbye');
        // Output now displays "Goodbye\nWorld!\n"
//
//        // clear() deletes all the section contents...
//        $section2->clear();
//        // Output now displays "Goodbye\n"
//
//        // ...but you can also delete a given number of lines
//        // (this example deletes the last two lines of the section)
//        $section1->clear(2);
        // Output is now completely empty!
        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
//        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
//         return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
         return Command::INVALID;
    }



}