<?php

namespace App\Form;

use App\Entity\Cliente;
use App\Entity\Orcamento;
use App\Entity\Produto;
use App\Entity\Servico;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrcamentoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo_orcamento')
            ->add('data_solicitacao', null, [
                'widget' => 'single_text',
            ])
            ->add('valor_total')
            ->add('cliente', EntityType::class, [
                'class' => Cliente::class,
                'choice_label' => 'id',
            ])
            ->add('servico', EntityType::class, [
                'class' => Servico::class,
                'choice_label' => 'id',
            ])
            ->add('produto', EntityType::class, [
                'class' => Produto::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Orcamento::class,
        ]);
    }
}
