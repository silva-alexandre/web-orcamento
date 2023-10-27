<?php

namespace App\Form;

use App\Entity\Cliente;
use App\Entity\Orcamento;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrcamentoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo_orcamento')
            ->add('data_solicitacao')
            ->add('cliente', EntityType::class, [
                    'class' => Cliente::class,
                    'choice_label' => function (Cliente $cliente) : string {
                        return $cliente->getNomeCliente();
                    },
            ])
            ->add('servico')
            ->add('produto')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Orcamento::class,
        ]);
    }
}