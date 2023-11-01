<?php

namespace App\Controller\Admin\Cache;

use App\Form\CacheClearFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard/cache/clear', name: 'app_cache_clear', methods: ['GET', 'POST'])]
class CacheController extends AbstractController
{
    private $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    #[Route('/dashboard/cache/load', name: 'app_cache_load', methods: ['GET'])]
    public function loadAction(): Response
    {
        $form = $this->createForm(CacheClearFormType::class);

        return $this->render('cache/load.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function clearAction(Request $request): Response
    {
        $form = $this->createForm(CacheClearFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $env = $data['env'];

            $application = new \Symfony\Bundle\FrameworkBundle\Console\Application($this->kernel);
            $application->setAutoExit(false);

            $input = new ArrayInput([
                'command' => 'cache:clear',
                '--env'   => $env,
            ]);

            $output = new NullOutput();
            $application->run($input, $output);

            $this->addFlash('success', 'Cache cleared successfully for ' . $env . ' environment.');

            return $this->redirectToRoute('app_cache_clear');
        }

        return $this->render('cache/clear.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
