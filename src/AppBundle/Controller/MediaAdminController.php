<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\MultiUploadType;
use Sonata\MediaBundle\Controller\MediaAdminController as Controller;
use Sonata\CoreBundle\Model\ManagerInterface;
use Sonata\MediaBundle\Provider\MediaProviderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MediaAdminController extends Controller
{

    /**
     * @var ManagerInterface
     */
    private $mediaManager;

    public function __construct(ManagerInterface $mediaManager)
    {
        $this->mediaManager = $mediaManager;
    }

    public function createAction(Request $request = null)
    {
        $this->admin->checkAccess('create');

        if (!$request->get('provider') && $request->isMethod('get')) {
            $pool = $this->get('sonata.media.pool');
            return $this->render('@App/admin/CRUD/select_provider.html.twig', [
                'providers' => $pool->getProvidersByContext(
                    $request->get('context', $pool->getDefaultContext())
                ),
                'action' => 'create',
            ]);
        }

        return parent::createAction($request);
    }

    public function multiUploadAction(Request $request)
    {
        $this->admin->checkAccess('create');

        $providerName = $request->query->get('provider');
        $context = $request->query->get('context', 'default');

        /** @var MediaProviderInterface $provider */
        $provider = $this->get($providerName);

        $form = $this->createMultiUploadForm($provider, $context);
        if (!$request->files->has('file')) {
            return $this->render('@App/admin/CRUD/multi_upload.html.twig', [
                'action' => 'multi_upload',
                'form' => $form->createView(),
                'admin' => $this->admin
            ]);
        }

        $media = $this->mediaManager->create();
        $media->setContext($context);
        $media->setBinaryContent($request->files->get('file'));
        $media->setProviderName($providerName);
        $this->mediaManager->save($media);

        return new JsonResponse([
            'status' => 'ok',
            'path' => $provider->getCdnPath($provider->getReferenceImage($media), true),
            'edit' => $this->admin->generateUrl('edit', ['id' => $media->getId()]),
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