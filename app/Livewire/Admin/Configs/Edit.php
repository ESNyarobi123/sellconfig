<?php

namespace App\Livewire\Admin\Configs;

use Livewire\Component;
use App\Models\Config;

class Edit extends Component
{
    public Config $config;
    public $content;

    public function mount(Config $config)
    {
        if ($config->status === 'sold') {
            session()->flash('error', 'Huwezi kuhariri config iliyouzwa.');
            return redirect()->route('admin.configs.index', ['selectedPlanId' => $config->plan_id]);
        }

        $this->config = $config;
        $this->content = $config->content;
    }

    public function update()
    {
        $this->validate(['content' => 'required|string']);

        $this->config->update(['content' => $this->content]);

        session()->flash('success', 'Config imesasishwa!');
        return redirect()->route('admin.configs.index', ['selectedPlanId' => $this->config->plan_id]);
    }

    public function render()
    {
        return view('livewire.admin.configs.edit')->layout('layouts.admin');
    }
}
