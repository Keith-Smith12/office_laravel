<?php

namespace App\Livewire;

use Livewire\Component;

class FormComponente extends Component
{

    public $nome;

    public function render()
    {
        return view('livewire.form-componente');
    }

    public function atualizarNome($novoNome)
    {
        $this->nome = $novoNome;
    }
}
