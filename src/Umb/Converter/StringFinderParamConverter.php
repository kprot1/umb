<?php
/**
 * Created by PhpStorm.
 * User: kprot
 * Date: 21.11.2018
 */

namespace Umb\Converter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Umb\Entity\StringFinderRequestDto;
use Umb\Validator\StringFinderRequestValidator;

/**
 * Class StringFinderParamConverter
 * @package Umb\Converter
 */
class StringFinderParamConverter implements ParamConverterInterface
{
    /**
     * @var StringFinderRequestValidator
     */
    private $validator;

    /**
     * StringFinderParamConverter constructor.
     * @param StringFinderRequestValidator $validator
     */
    public function __construct(StringFinderRequestValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Stores the object in the request.
     *
     * @param Request $request
     * @param ParamConverter $configuration Contains the name, class and options of the object
     *
     * @return void True if the object has been successfully set, else false
     */
    public function apply(Request $request, ParamConverter $configuration): void
    {
        [$search, $file] = $this->getParametersFromRequest($request);

        $stringFinderRequest = new StringFinderRequestDto($search, $file);
        $errors = $this->validator
            ->validate($stringFinderRequest)
            ->getErrors();

        $request->attributes->set($configuration->getName(), $stringFinderRequest);
        $request->attributes->set('validateErrors', $errors);
    }

    /**
     * Checks if the object is supported.
     *
     * @param ParamConverter $configuration
     * @return bool True if the object is supported, else false
     */
    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getClass() !== null;
    }

    /**
     * @param Request $request
     * @return array
     */
    private function getParametersFromRequest(Request $request): array
    {
        $search = $request->get('search') ?? $request->get('form')['search'] ?? '';
        $file = $request->files->get('file') ?? $request->files->get('form')['file'] ?? null;

        return [$search, $file];
    }
}