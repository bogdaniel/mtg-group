namespace App\Controller;

use App\Entity\DiskConfiguration;
use App\Form\DiskConfigurationType;
use App\Repository\DiskConfigurationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/disk/configuration")
 */
class DiskConfigurationController extends AbstractController
{
    /**
     * @Route("/", name="disk_configuration_index", methods={"GET"})
     */
    public function index(DiskConfigurationRepository $diskConfigurationRepository): Response
    {
        return $this->render('disk_configuration/index.html.twig', [
            'disk_configurations' => $diskConfigurationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="disk_configuration_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $diskConfiguration = new DiskConfiguration();
        $form = $this->createForm(DiskConfigurationType::class, $diskConfiguration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($diskConfiguration);
            $entityManager->flush();

            return $this->redirectToRoute('disk_configuration_index');
        }

        return $this->render('disk_configuration/new.html.twig', [
            'disk_configuration' => $diskConfiguration,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="disk_configuration_show", methods={"GET"})
     */
    public function show(DiskConfiguration $diskConfiguration): Response
    {
        return $this->render('disk_configuration/show.html.twig', [
            'disk_configuration' => $diskConfiguration,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="disk_configuration_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DiskConfiguration $diskConfiguration): Response
    {
        $form = $this->createForm(DiskConfigurationType::class, $diskConfiguration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('disk_configuration_index');
        }

        return $this->render('disk_configuration/edit.html.twig', [
            'disk_configuration' => $diskConfiguration,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="disk_configuration_delete", methods={"DELETE"})
     */
    public function delete(Request $request, DiskConfiguration $diskConfiguration): Response
    {
        if ($this->isCsrfTokenValid('delete'.$diskConfiguration->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($diskConfiguration);
            $entityManager->flush();
        }

        return $this->redirectToRoute('disk_configuration_index');
    }
}
