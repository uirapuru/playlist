<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class PlaylistType
 * @package AppBundle\Form
 */
final class PlaylistType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("playlist", 'entity', [
            'class' => 'AppBundle\Entity\Playlist',
            'label' => false,
            'placeholder' => 'wybierz playliste',
            'property' => 'name'
        ])
        ->add('set', 'submit',[
            'label' => "Ustaw"
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'playlist_form';
    }
}