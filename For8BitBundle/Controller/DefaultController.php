<?php

namespace Ilias25\For8BitBundle\Controller;

use Ilias25\For8BitBundle\Entity\Location;
use Ilias25\For8BitBundle\Form\LocationType;
use Ilias25\For8BitBundle\Services\GoogleGeoService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $formFactory = $this->container->get('form.factory');
        $form = $formFactory->create(LocationType::class);

        return $this->render('For8BitBundle:Default:index.html.twig', ['form' => $form->createView()]);
    }

    public function getAction(Request $request)
    {
        $formFactory = $this->container->get('form.factory');
        $form = $formFactory->create(LocationType::class);

        $form->submit($request->query->all());

        $locations = [];
        $errors = [];
        try {
            if (!$form->isValid()) {
                foreach ($form->getErrors(true) as $error) {
                    $errors[] = [
                        'message'   => $error->getMessage(),
                        'code'      => $error->getOrigin()->getName(),
                    ];
                }
            } else {
                /** @var GoogleGeoService $geoService */
                $geoService = $this->container->get('ilias25_for_8bit.geo.google');

                $formData = $form->getData();
                $locationEntities = $geoService->getLocationsByPlace($formData['text']);

                $locations = array_map(
                    function (Location $item) {
                        return $item->getAsArray();
                    },
                    $locationEntities
                );
            }
        } catch (\Exception $e) {
            $errors[] = [
                'message'   => $e->getMessage(),
                'code'      => $e->getCode(),
            ];
        }

        if (empty($errors)) {
            $data = [
                'locations' => $locations,
                'success'   => true,
            ];
        } else {
            $data = [
                'errors'    => $errors,
                'success'   => false,
            ];
        }

        return new JsonResponse($data);
    }
}
