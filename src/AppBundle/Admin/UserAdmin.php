<?php
/**
 * Created by PhpStorm.
 * User: rdbn
 * Date: 04.09.2018
 * Time: 21:40
 */

namespace AppBundle\Admin;

use AppBundle\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'sonata_user';
    protected $baseRoutePattern = 'user';

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
            ->add('username', TextType::class)
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ])
            ->add('role', ChoiceType::class, [
                'choices' => User::ROLE_USER,
            ])
        ;
    }

    /**
     * @param DatagridMapper $filter
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('username');
    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('id')
            ->add('username')
            ->add('createdAt', 'date', [
                'format' => 'Y-m-d H:i:s',
            ])
            ->add('_action', null, [
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ],
            ])
        ;
    }

    /**
     * @param User $user
     */
    public function prePersist($user)
    {
        if ($user->getPlainPassword()) {
            $encoder = $this->getConfigurationPool()
                ->getContainer()
                ->get('security.password_encoder');

            $user->setPassword($encoder->encodePassword($user, $user->getPlainPassword()));
        }
    }

    /**
     * @param User $user
     */
    public function preUpdate($user)
    {
        if ($user->getPlainPassword()) {
            $encoder = $this->getConfigurationPool()
                ->getContainer()
                ->get('security.password_encoder');

            $user->setPassword($encoder->encodePassword($user, $user->getPlainPassword()));
        }
    }
}