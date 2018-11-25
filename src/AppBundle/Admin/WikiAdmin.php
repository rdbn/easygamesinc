<?php
/**
 * Created by PhpStorm.
 * User: rdbn
 * Date: 04.09.2018
 * Time: 21:40
 */

namespace AppBundle\Admin;

use AppBundle\Entity\Wiki;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\CallbackTransformer;

class WikiAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'sonata_wiki';
    protected $baseRoutePattern = 'wiki';

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
        $parent = $this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager')
            ->getRepository(Wiki::class)
            ->findOneBy(['id' => $this->getSubject()->getParent()]);

        $form
            ->add('parent', EntityType::class, [
                'class' => Wiki::class,
                'choice_label' => 'title',
                'required' => false,
            ])
            ->add('title', 'text')
            ->add('text', CKEditorType::class);

        $form
            ->get('parent')
            ->addModelTransformer(new CallbackTransformer(function () use ($parent) {
                return $parent;
            }, function ($wiki) {
                if ($wiki instanceof Wiki) {
                    /** @var Wiki $wiki */
                    return $wiki->getId();
                }

                return 0;
            }));
    }

    /**
     * @param DatagridMapper $filter
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('title')
            ->add('text');
    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('id')
            ->add('title')
            ->add('parent')
            ->add('createdAt', 'date', [
                'format' => 'Y-m-d H:i:s',
            ])
            ->add('_action', null, [
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    /**
     * @param Wiki $object
     */
    public function prePersist($object)
    {
        if (is_null($object->getParent())) {
            $object->setParent(0);
        }

        if ($object->getParent() instanceof Wiki) {
            $object->setParent($object->getParent()->getId());
        }
    }


    /**
     * @param Wiki $object
     */
    public function preUpdate($object)
    {
        if (is_null($object->getParent())) {
            $object->setParent(0);
        }

        if ($object->getParent() instanceof Wiki) {
            $object->setParent($object->getParent()->getId());
        }
    }
}