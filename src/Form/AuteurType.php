<?php

namespace App\Form;

use App\Entity\Auteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\String\Slugger\AsciiSlugger;

class AuteurType extends AbstractType
{
    // public function __construct(private FormListenerFactory $ListenerFactory)
    // {
    // }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, [
            // 'empty_data' => ''
        ])
        ->add('prenom', TextType::class, [
            // 'empty_data' => ''
        ])
        ->add('slug', TextType::class, [
            'required' => false
        ])
        
        // ->addEventListener(FormEvents::PRE_SUBMIT, $this->ListenerFactory->autoSlug('nom'));

        ->addEventListener(FormEvents::PRE_SUBMIT, $this->autoSlug(...))
        ;
    }

    public function autoSlug(PreSubmitEvent $event): void
    {
        $data = $event->getData();
        if (empty($data['slug'])){
            $slugger = new AsciiSlugger();
            $data['slug'] = strtolower($slugger->slug($data['nom']));
            $event->setData($data);
        }
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Auteur::class,
        ]);
    }
}

?>


