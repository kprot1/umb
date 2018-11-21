<?php
/**
 * Created by PhpStorm.
 * User: kprot
 * Date: 20.11.2018
 */

namespace Umb\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Umb\Entity\StringFinderRequestDto;
use Umb\Form\MainForm;
use Umb\Services\StringFinderService;

/**
 * Class MainController
 * @package Umb\Controller
 */
class MainController extends Controller
{
    /**
     * @var StringFinderService
     */
    private $stringFinderService;

    /**
     * MainController constructor.
     * @param StringFinderService $stringFinderService
     */
    public function __construct(
        StringFinderService $stringFinderService
    ) {
        $this->stringFinderService = $stringFinderService;
    }

    /**
     * @return Response
     */
    public function mainAction(): Response
    {
        $form = $this->createFormBuilder(new MainForm())
            ->add('search', TextType::class, [
                'label' => 'Enter the string: ',
                'required' => true
            ])
            ->add('file', FileType::class, [
                'multiple' => false,
                'label' => false,
                'required' => true
            ])
            ->getForm();

        return $this->render('@Umb/main.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @ParamConverter("stringFinderRequest", class="StringFinderRequestDto", converter="string_finder_param_converter" )
     *
     * @param StringFinderRequestDto $stringFinderRequest
     * @param array $validateErrors
     * @return Response
     */
    public function umbAction(StringFinderRequestDto $stringFinderRequest, array $validateErrors = []): Response
    {
        if (!empty($validateErrors)) {
            return new Response(array_shift($validateErrors));
        }

        try {
            $stringFinderResponseDto =
                $this->stringFinderService->find(
                    $stringFinderRequest->getSearch(),
                    $stringFinderRequest->getFile()
                );

            return new Response('Line: ' . $stringFinderResponseDto->getLine() . "\n" . 'Position: ' . $stringFinderResponseDto->getPosition());
        } catch (\DomainException $exception) {
            return new Response($exception->getMessage());
        }
    }
}
