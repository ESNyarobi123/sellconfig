<?php

namespace App\Livewire\Admin\Plans;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Plan;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public Plan $plan;
    public $name;
    public $type;
    public $description;
    public $price;
    public $duration;
    public $image;
    public $is_active;

    public function mount(Plan $plan)
    {
        $this->plan = $plan;
        $this->name = $plan->name;
        $this->type = $plan->type;
        $this->description = $plan->description;
        $this->price = $plan->price;
        $this->duration = $plan->duration;
        $this->is_active = $plan->is_active;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:weekly,bi_weekly,monthly',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:100',
            'duration' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = [
            'name' => $this->name,
            'type' => $this->type,
            'description' => $this->description,
            'price' => $this->price,
            'duration' => $this->duration,
            'is_active' => $this->is_active,
        ];

        if ($this->image) {
            if ($this->plan->image) {
                Storage::disk('public')->delete($this->plan->image);
            }
            $data['image'] = $this->image->store('plans', 'public');
        }

        $this->plan->update($data);

        session()->flash('success', 'Plan imesasishwa!');
        return redirect()->route('admin.plans.index');
    }

    public function render()
    {
        return view('livewire.admin.plans.edit')->layout('layouts.admin');
    }
}
