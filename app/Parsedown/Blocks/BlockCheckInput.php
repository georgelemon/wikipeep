<?php 

namespace App\Parsedown\Blocks;

trait BlockCheckInput
{

    /**
     * The default format of how a checkbox can be recognized
     * @var array
     */
    protected $checkbox = [
        'checked' => '[x]',
        'unchecked' => '[ ]'
    ];

    protected function blockUnCheckInput($Line)
    {
        return $this->inputHandler($Line);
    }

    protected function blockCheckInput($Line)
    {
        return $this->inputHandler($Line);
    }

    protected function inputHandler($Line)
    {

        $lineText = $Line['text'];

        // Checkbox that should be checked by default
        // It checks if [x] is first as position, also if is inserted under a list
        // it may be a difference of 1-2 as position
        $allowedPosition = ['0', '1', '2'];
        $Block = [];

        if( str_contains($lineText, $this->checkbox['checked']) ) {

            if( in_array(stripos($lineText, $this->checkbox['checked']), $allowedPosition) ) {
                $state = true;
                $tag = $this->checkbox['checked'];
            }

        } elseif( str_contains($lineText, $this->checkbox['unchecked']) ) {
            if( in_array(stripos($lineText, $this->checkbox['unchecked']), $allowedPosition)) {
                $state = false;
                $tag = $this->checkbox['unchecked'];
            }

        } else {
            return false;
        }

        // Replace the checkbox markdown tag and, in case exists,
        // it will strip the space rest from start of the string
        $lineText = ltrim(str_replace($tag, '', $lineText));

        $Block = [
            'type' => 'InputCheck',
            'element' => [
                'name' => 'input',
                'text' => $this->lines([$lineText]),
                'attributes' => [
                    'type' => 'checkbox',
                    'disabled' => 'disabled',
                ]
            ]
        ];

        $state ? $Block['element']['attributes']['checked'] = true : '';

        return $Block;
    }

    // protected function blockCheckInputContinue($Line, $Block)
    // {
    //     return $Block;
    // }

    protected function blockCheckInputComplete($Block)
    {
        return $Block;
    }

    protected function blockUnCheckInputComplete($Block)
    {
        return $Block;
    }
}