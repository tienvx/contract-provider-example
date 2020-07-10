<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class StatesController extends AbstractController
{
    /**
     * @Route("/states-setup", name="states_setup")
     */
    public function setup(Request $request, KernelInterface $kernel)
    {
        $consumer = $request->request->get('consumer');
        $state = $request->request->get('state');
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput([
            // TODO Load only needed fixtures by both consumer and state
            'command' => 'doctrine:fixtures:load',
            '--group' => [$state],
            '--no-interaction' => true,
        ]);

        // You can use NullOutput() if you don't need the output
        $output = new NullOutput();
        $exitCode = $application->run($input, $output);

        return new Response(0 === $exitCode ? 'Success' : 'Failed');
    }
}
