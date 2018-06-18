<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\MultiUploadType;
use Sonata\AdminBundle\Exception\ModelManagerException;
use Sonata\MediaBundle\Controller\GalleryAdminController as Controller;
use Sonata\CoreBundle\Model\ManagerInterface;
use Sonata\MediaBundle\Provider\MediaProviderInterface;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormRenderer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GalleryAdminController extends Controller
{

    /**
     * @var ManagerInterface
     */
    private $mediaManager;

    public function __construct(ManagerInterface $mediaManager)
    {
        $this->mediaManager = $mediaManager;
    }

    public function createAction()
    {
        $twig = $this->get('twig');
        $request = $this->getRequest();
        // the key used to lookup the template
        $templateKey = 'edit';

        $this->admin->checkAccess('create');

        $class = new \ReflectionClass($this->admin->hasActiveSubClass() ? $this->admin->getActiveSubClass() : $this->admin->getClass());

        if ($class->isAbstract()) {
            return $this->renderWithExtraParams(
                '@SonataAdmin/CRUD/select_subclass.html.twig',
                [
                    'base_template' => $this->getBaseTemplate(),
                    'admin' => $this->admin,
                    'action' => 'create',
                ],
                null
            );
        }

        $newObject = $this->admin->getNewInstance();

        $preResponse = $this->preCreate($request, $newObject);
        if (null !== $preResponse) {
            return $preResponse;
        }

        $this->admin->setSubject($newObject);

        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->admin->getForm();
        $form->setData($newObject);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                $submittedObject = $form->getData();
                $this->admin->setSubject($submittedObject);
                $this->admin->checkAccess('create', $submittedObject);

                try {
                    $newObject = $this->admin->create($submittedObject);

                    if ($this->isXmlHttpRequest()) {
                        return $this->renderJson([
                            'result' => 'ok',
                            'objectId' => $this->admin->getNormalizedIdentifier($newObject),
                        ], 200, []);
                    }

                    $this->addFlash(
                        'sonata_flash_success',
                        $this->trans(
                            'flash_create_success',
                            ['%name%' => $this->escapeHtml($this->admin->toString($newObject))],
                            'SonataAdminBundle'
                        )
                    );

                    // redirect to edit mode
                    return $this->redirectTo($newObject);
                } catch (ModelManagerException $e) {
                    $this->handleModelManagerException($e);

                    $isFormValid = false;
                }
            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash(
                        'sonata_flash_error',
                        $this->trans(
                            'flash_create_error',
                            ['%name%' => $this->escapeHtml($this->admin->toString($newObject))],
                            'SonataAdminBundle'
                        )
                    );
                }
            } elseif ($this->isPreviewRequested()) {
                // pick the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }
        }

        $formView = $form->createView();
        // set the theme for the current Admin Form
        $twig->getRuntime(FormRenderer::class)->setTheme($formView, $this->admin->getFormTheme());

        // NEXT_MAJOR: Remove this line and use commented line below it instead
        $template = $this->admin->getTemplate($templateKey);
        // $template = $this->templateRegistry->getTemplate($templateKey);

        return $this->renderWithExtraParams($template, [
            'action' => 'create',
            'form' => $formView,
            'object' => $newObject,
            'objectId' => null,
        ], null);
    }

    public function multiUploadAction(Request $request)
    {
        $this->admin->checkAccess('create');

        $context = $request->query->get('context', 'default');

        $provider = $this->get('sonata.media.provider.image');

        $media = $this->mediaManager->create();
        $media->setContext($context);
        $media->setBinaryContent($request->files->get('file'));
        $media->setProviderName($provider->getName());
        $this->mediaManager->save($media);

        return new JsonResponse([
            'status' => 'ok',
            'path' => $provider->getCdnPath($provider->getReferenceImage($media), true),
            'mediaId' => $media->getId(),
        ]);
    }

    private function createMultiUploadForm(MediaProviderInterface $provider, string $context): FormInterface
    {
        return $this->createForm(MultiUploadType::class, null, [
            'data_class' => $this->mediaManager->getClass(),
            'provider' => $provider->getName(),
            'context' => $context,
        ]);
    }
}