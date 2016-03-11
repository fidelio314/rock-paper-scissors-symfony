<?php

namespace AppBundle\Form;

use AppBundle\Model\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Class StartGame
 * Username and Game mode start form
 *
 * @package AppBundle\Form
 */
class StartGameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                'required' => true,
                'data' => $options['username']
            ))
            ->add('autoMode', ChoiceType::class, array(
                    'choices'  => array(
                        'No' => false,
                        'Yes' => true
                    ),
//                    'data' => $options['autoMode']
                ))
            ->add('gameMode', ChoiceType::class, array(
                'choices'  => array(
                    'easy' => Game::MODE_EASY,
                    'expert' => Game::MODE_EXPERT,
                ),
            ))
            ->add('save', SubmitType::class, array(
                    'label' => 'Start the Game'
                )
            );

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(array(
                'username',
            ));
        $resolver->setDefault('username', null);
    }
}
