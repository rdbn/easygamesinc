<?php
/**
 * Created by PhpStorm.
 * User: rdbn
 * Date: 04.09.2018
 * Time: 21:40
 */

namespace AppBundle\Admin;

use AppBundle\Entity\Category;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

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
        $form
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
            ])
            ->add('title', 'text')
            ->add('text', CKEditorType::class);
    }

    /**
     * @param DatagridMapper $filter
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('category')
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
            ->add('category.name')
            ->add('title')
            ->add('createdAt', 'date', [
                'format' => 'Y-m-d H:i:s',
            ]);
    }
}