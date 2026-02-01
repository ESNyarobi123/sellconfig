<?php

namespace App\Livewire\Admin\Configs;

use Livewire\Component;
use App\Models\Config;
use App\Models\Plan;

class Create extends Component
{
    public $plan_id;
    public $upload_type = 'bulk'; // bulk or single
    public $content; // for single
    public $bulk_content; // for bulk
    public $separator = 'newline';

    public function mount()
    {
        $this->plan_id = request()->query('plan_id');
    }

    public function save()
    {
        $this->validate([
            'plan_id' => 'required|exists:plans,id',
            'upload_type' => 'required|in:single,bulk',
        ]);

        if ($this->upload_type === 'single') {
            $this->validate(['content' => 'required|string']);

            Config::create([
                'plan_id' => $this->plan_id,
                'content' => trim($this->content),
                'status' => 'available',
            ]);

            session()->flash('success', 'Config imeongezwa!');
        } else {
            // Bulk
            $this->validate([
                'bulk_content' => 'required|string',
                'separator' => 'required|in:newline,comma,semicolon',
            ]);

            $delimiter = match ($this->separator) {
                'comma' => ',',
                'semicolon' => ';',
                default => "\n",
            };

            $configTexts = array_filter(
                array_map('trim', explode($delimiter, $this->bulk_content))
            );

            if (empty($configTexts)) {
                $this->addError('bulk_content', 'Hakuna configs zilizopatikana.');
                return;
            }

            $count = 0;
            foreach ($configTexts as $text) {
                if (!empty($text)) {
                    Config::create([
                        'plan_id' => $this->plan_id,
                        'content' => $text,
                        'status' => 'available',
                    ]);
                    $count++;
                }
            }

            session()->flash('success', "Configs {$count} zimeongezwa!");
        }

        return redirect()->route('admin.configs.index', ['selectedPlanId' => $this->plan_id]); // corrected query param name match Index component
    }

    public function render()
    {
        $plans = Plan::where('is_active', true)->get();
        return view('livewire.admin.configs.create', [
            'plans' => $plans
        ])->layout('layouts.admin');
    }
}
