<?php

namespace Ilias25\For8BitBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Length;

class LocationType extends AbstractType
{
    const TEXT_INVALID = 'Text is invalid';

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', TextType::class, [
                'trim'              => true,
                'required'          => true,
                'invalid_message'   => self::TEXT_INVALID,
                'constraints'       => [
                    new NotNull(['message' => self::TEXT_INVALID]),
                    new Type(['type' => 'string', 'message' => self::TEXT_INVALID]),
                    new Length(['min' => 2, 'max' => 1024, 'maxMessage' => self::TEXT_INVALID]),
                ],
                'data'              => 'restaurants in Sydney',
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false
        ]);
    }
}