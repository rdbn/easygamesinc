<?php
/**
 * Created by PhpStorm.
 * User: rdbn
 * Date: 04.09.2018
 * Time: 21:40
 */

namespace AppBundle\Admin;

use AppBundle\Entity\Category;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CategoryAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'sonata_category';
    protected $baseRoutePattern = 'category';

    /**
     * @var array
     */
    protected $datagridValues = [
        '_page' => 1,
    ];

    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('name', 'text')
            ->add('groupId', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'required' => false,
            ]);
    }

    /**
     * @param DatagridMapper $filter
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('name')
            ->add('groupId');
    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('id')
            ->add('name')
            ->add('groupId')
            ->add('createdAt', 'date', [
                'format' => 'Y-m-d H:i:s',
            ]);
    }

    /**
     * @param Category $object
     */
    public function prePersist($object)
    {
        if ($object->getGroupId() instanceof Category) {
            $object->setGroupId($object->getGroupId()->getId());
        }
    }

    /**
     * @param Category $object
     */
    public function preUpdate($object)
    {
        if ($object->getGroupId() instanceof Category) {
            $object->setGroupId($object->getGroupId()->getId());
        }
    }

    /**
     * @param Category $object
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postPersist($object)
    {
        if (0 == $object->getGroupId()) {
            $object->setGroupId($object->getId());
            $this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager')->flush();
        }
    }

    /**
     * @param Category $object
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postUpdate($object)
    {
        if (0 == $object->getGroupId()) {
            $object->setGroupId($object->getId());
            $this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager')->flush();
        }
    }
}