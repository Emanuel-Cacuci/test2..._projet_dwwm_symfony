<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Categorie;
use App\Entity\Produit;
// use Symfony\Component\Form\Extension\Core\type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
// use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
// use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\String\Slugger\AsciiSlugger;
// use Symfony\Component\Validator\Constraints\Negative;

// use Symfony\Component\Validator\Constraints\Length;
// use Symfony\Component\Validator\Constraints\Regex;
// use Symfony\Component\Validator\Constraints\Sequentially;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                // 'label' => 'Change le nom du champ'
                 'empty_data' => ''
            ])
            ->add('prix', TextType::class, [
                'empty_data' => ''
            ])
            ->add('images')
            ->add('stock')
            ->add('description')
            ->add('slug', TextType::class, [
                'required' => false
                // 'constraints' => new Sequentially([
                //     new Length(min: 10),
                //     new Regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', message: "Ceci n'est pas un slug valide")

                // ])
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                                                                // Ajoute empty-data quand c'est necessaire... !!!!
                                                                 // Regarde la fin de la video de Grafikart (Validator) ...
            ])
            ->add('auteur', EntityType::class, [
                'class' => Auteur::class,
                'choice_label' => 'prenom',
            ])
            //     ->add('save', SubmitType::class, [
            //         'label' => 'Modifier'
            //     ])
            //
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->autoSlug(...))
            // ->addEventListener(FormEvents::POST_SUBMIT, $this->atachTimesstamps(...))
        ;
    }

    public function autoSlug(PreSubmitEvent $event): void
    {
        $data = $event->getData();
        if (empty($data['slug'])) {
            $slugger = new AsciiSlugger();
            $data['slug'] = strtolower($slugger->slug($data['nom']));
            $event->setData($data);
        }
    }

    // public function atachTimesstamps(PostSubmitEvent $event): void
    // {
    //     $data = $event->getData();
    //     if (!($data instanceof Produit)) {
    //         return;
    //     }

    //     $data->setUpdatedAt(new \DateTimeImmutable());
    //     if (!$data-getId()) {
    //         $data-setCreatedAt(new \DateTimeImmutable());
    //     }
    // }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
