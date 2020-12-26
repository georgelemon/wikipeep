<?php 

namespace App\Core\Parsedown\Blocks;

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

    protected function blockCheckInput($Line)
    {

        $currentLine = $Line['text'];

        // Checkbox that should be checked by default
        // It checks if [x] is first as position, also if is inserted under a list
        // it may be a difference of 1-2 as position
        $allowedPosition = ['0', '1', '2'];

        if(in_array(strpos($currentLine, $this->checkbox['checked']), $allowedPosition)) {
            $checked = true;
            $tag = $this->checkbox['checked'];

        // Checkbox that should not be checked
        } elseif( strpos($currentLine, $this->checkbox['unchecked']) ) {
            $checked = false;
            $tag = $this->checkbox['unchecked'];
        }

        // Replace the checkbox markdown tag and, in case exists,
        // it will strip the space rest from start of the string
        // $currentLine = ltrim(str_replace($tag, '', $currentLine));
        var_dump($currentLine);
        die;
        return [
            'element' => [
                'name' => 'input',
                'text' => $this->lines([$currentLine]),
                'attributes' => [
                    'type' => 'checkbox',
                    'disabled' => 'disabled',
                    'checked' => $checked
                ]
            ]
        ];
    }

    protected function blockCheckInputContinue($Line, $Block)
    {
        // var_dump($Block); die;
    }

    protected function blockCheckInputComplete($Block)
    {
        return $Block;
    }
}