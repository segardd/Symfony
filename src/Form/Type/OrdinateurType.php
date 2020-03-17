<?php
namespace App\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Ordinateur;
use App\Entity\Marque;
class OrdinateurType extends AbstractType {
 public function buildForm(FormBuilderInterface $builder, array $options) {
 $builder->add('numero', TextType::class)
 ->add('ip', TextType::class)
 ->add('marque', EntityType::class,
 array('class' => Marque::class));
 }
 public function configureOptions(OptionsResolver $resolver) {
 $resolver->setDefaults(array(
 'data_class' => Ordinateur::class,
 ));
 }
}
