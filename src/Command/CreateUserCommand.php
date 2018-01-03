<?php

namespace App\Command;


use App\Document\User;
use App\Service\DoctrineDocumentManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;

class CreateUserCommand extends Command
{
    protected static $defaultName = 'dju_api:user:create';
    private $dm;

    public function __construct($name = null, DoctrineDocumentManager $documentManager)
    {
        parent::__construct($name);
        $this->dm = $documentManager->getManager();

    }

    protected function configure()
    {
        $this
            ->setDescription('Create user')
            ->addArgument('username', InputArgument::REQUIRED, 'User name')
            ->addArgument('password', InputArgument::REQUIRED, 'User password')
            ->addArgument('email', InputArgument::REQUIRED, 'user email')
            ->addOption('super-admin', null, InputOption::VALUE_NONE, 'Set super admin')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $userName = $input->getArgument('username');
        $pwd = $input->getArgument('password');
        $email = $input->getArgument('email');
        $roles = ['ROLE_USER'];
        if ($input->getOption('super-admin')) {
            $roles[] = 'ROLE_ADMIN';
        }//create user
        $user = new User();
        $user->setUsername($userName);
        $user->setEmail($email);
        //generate salt
        $user->setSalt(rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '='));

        //get encoder & generate secure pass
        $encoder = new BCryptPasswordEncoder(12);
        $user->setPassword($encoder->encodePassword($pwd, $user->getSalt()));

        //generate random api key
        $user->setApiKey(rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '='));

        //add user roles
        $user->setRoles($roles);

        try{
            $this->dm->persist($user);
            $this->dm->flush();
        }catch (\Exception $exception){
            $io->error('DB Connection error ! Please fix it and retry user creation');
            $io->error($exception->getMessage());
        }

        $io->success('Success user creation with api key : '.$user->getApiKey());
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {

        $questions = array();
        if (!$input->getArgument('username')) {
            $question = new Question('Please choose a username:');
            $question->setValidator(function ($username) {
                if (empty($username)) {
                    throw new \Exception('Username can not be empty');
                }
                return $username;
            });
            $questions['username'] = $question;
        }
        if (!$input->getArgument('email')) {
            $question = new Question('Please choose an email:');
            $question->setValidator(function ($email) {
                if (empty($email)) {
                    throw new \Exception('Email can not be empty');
                }
                return $email;
            });
            $questions['email'] = $question;
        }
        if (!$input->getArgument('password')) {
            $question = new Question('Please choose a password:');
            $question->setValidator(function ($password) {
                if (empty($password)) {
                    throw new \Exception('Password can not be empty');
                }
                return $password;
            });
            $question->setHidden(true);
            $questions['password'] = $question;
        }
        foreach ($questions as $name => $question) {
            $answer = $this->getHelper('question')->ask($input, $output, $question);
            $input->setArgument($name, $answer);
        }
    }

}