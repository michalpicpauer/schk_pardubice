<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Collection;
use AppBundle\Entity\Member;
use AppBundle\Entity\Page;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Sonata\FormatterBundle\Form\Type\FormatterType;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class MemberAdmin extends BaseAdmin
{
    const ROUTE = 'member';

    protected $baseRoutePattern = self::ROUTE;

    protected $baseRouteName = self::ROUTE;

    /** @var EntityManagerInterface */
    protected $em;

    public function __construct($code, $class, $baseControllerName, RegistryInterface $registry)
    {
        parent::__construct($code, $class, $baseControllerName);

        $this->em = $registry->getManager();
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->with('Member')
            ->add('name')
            ->add('breed', null, ['required' => false])
            ->add('catteryName', null, ['required' => false])
            ->add('web', UrlType::class, ['required' => false])
            ->end();
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('name')
            ->add('breed')
            ->add('catteryName')
            ->add('web', 'url');

        parent::configureListFields($list);
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('name')
            ->add('breed')
            ->add('catteryName');

        parent::configureDatagridFilters($filter);
    }

    /**
     * @param Member $object
     */
    public function prePersist($object)
    {
        $membersPages = $this->em->getRepository(Page::class)->findBy(['type' => Page::TYPE_MEMBERS]);

        if (!empty($membersPages) && $object->getPage() == null) {
            $object->setPage($membersPages[0]);
        }
    }
}
