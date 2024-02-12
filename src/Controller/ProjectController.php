<?php

namespace App\Controller;

use App\DataTransferObject\ProjectFileUploadDataTransfer;
use App\Entity\Project;
use App\Entity\ProjectPump;
use App\Form\ProjectFileUploadType;
use App\Form\ProjectType;
use App\Repository\CountryRepository;
use App\Repository\ProjectPumpRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception as ReaderException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard/project')]
class ProjectController extends AbstractController
{
    public function __construct(
        private ProjectRepository $projectRepository,
        private CountryRepository $countryRepository,
        private ProjectPumpRepository $projectPumpRepository,
    ) {
        if (!isset($_COOKIE['dashboard'])) {
            header('Location: /');
        }
    }

    #[
        Route('/', name: 'app_project_index', methods: ['GET'])]
    public function index(ProjectRepository $projectRepository): Response
    {
        if (!isset($_COOKIE['dashboard'])) {
            die();
        }
        return $this->render('project/index.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_project_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!isset($_COOKIE['dashboard'])) {
            die();
        }
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('project/new.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/upload-csv', name: 'app_project_upload_csv', methods: ['GET', 'POST'])]
    public function uploadCsv(Request $request): Response
    {
        if (!isset($_COOKIE['dashboard'])) {
            die();
        }
        $form = $this->createForm(ProjectFileUploadType::class, new ProjectFileUploadDataTransfer());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['file']->getData();
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '-' . uniqid('', true) . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('uploads_directory'), // You need to configure this parameter
                        $newFilename,
                    );

                    // Now you can process the CSV file
                    $this->processXlsx($this->getParameter('uploads_directory') . '/' . $newFilename);

                    $this->addFlash('success', 'File uploaded and processed successfully.');
                } catch (FileException $e) {
                    $this->addFlash('error', 'Failed to upload file.');
                }
            }

            return $this->redirectToRoute('app_project_upload_csv');
        }

        return $this->render('project/csv.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function processXlsx(string $filePath): void
    {
        if (!isset($_COOKIE['dashboard'])) {
            die();
        }

        try {
            $inputFileType = IOFactory::identify($filePath);
            $reader = IOFactory::createReader($inputFileType);
            $reader->setReadEmptyCells(false);
            $reader->setReadDataOnly(true);


            $spreadsheet = $reader->load($filePath);
            $sheets = $spreadsheet->getAllSheets();
            foreach ($sheets as $sheet) {
                $this->processSheet($sheet);
            }
        } catch (ReaderException $e) {
            // Handle the error, e.g., log it or notify the user
            throw new \RuntimeException('Failed to read the spreadsheet: ' . $e->getMessage());
        }
    }

    private function processSheet(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
    {
        if (!isset($_COOKIE['dashboard'])) {
            die();
        }

        $data = [];
        $i = 0;

        foreach ($sheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // This ensures we iterate over all cells
            $rowData = [];
            if ($i == 0) {
                $i++;
                continue;
            }
            foreach ($cellIterator as $cell) {
                // Check if cell is not null
                if ($cell !== null) {
                    // Use getFormattedValue() if you want to get the value as seen in Excel
                    $value = $cell->getFormattedValue();
                    $rowData[] = $value;
                } else {
                    $rowData[] = ''; // Add a placeholder to keep column alignment
                }
            }
            $countryName = ucfirst(strtolower($rowData[0]));

            if ($countryName === 'Moldova') {
                $countryName = 'Moldova, Republic of';
            }

            $country = $this->countryRepository->findOneBy(['name' => $countryName]);
            if (empty($country)) {
                continue;
            }

            $modelName = strtolower(trim($rowData[4]));
            $model = $this->projectPumpRepository->findOneBy(['name' => $modelName]);

            if ($model === null) {
                $model = new ProjectPump();
                $model->setName(strtolower(trim($rowData[4])));
                $model->setDescription(strtolower(trim($rowData[5])));
                $this->projectPumpRepository->save($model);
            }

            $project = new Project();
            $project->setCountry($country);
            $project->setName(strtolower(trim($rowData[1])));
            $year = explode(' ', $rowData[2]);
            $project->setYearStarted((int)$year[0]);
            $project->setDescription(strtolower(trim($rowData[3])));
            $project->setPump($model);
            $this->projectRepository->save($project);


            // At this point, $rowData should contain all the cell values for the row
            // Process $rowData as needed, e.g., save to database, log, etc.

            // Example: Just outputting the row data to see what's been read
            // Remove or replace this line according to your actual processing needs
            $data[] = $rowData;
        }
    }

    #[Route('/{id}', name: 'app_project_show', methods: ['GET'])]
    public function show(Project $project): Response
    {
        if (!isset($_COOKIE['dashboard'])) {
            die();
        }

        return $this->render('project/show.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_project_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Project $project, EntityManagerInterface $entityManager): Response
    {
        if (!isset($_COOKIE['dashboard'])) {
            die();
        }

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('project/edit.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_project_delete', methods: ['POST'])]
    public function delete(Request $request, Project $project, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $project->getId(), $request->request->get('_token'))) {
            $entityManager->remove($project);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
    }

}
