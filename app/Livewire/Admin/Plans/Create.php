<?php

namespace App\Livewire\Admin\Plans;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Plan;

class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $type = 'weekly';
    public $description;
    public $price;
    public $duration;
    public $image;

    public function save()
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
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('plans', 'public');
        }

        Plan::create($data);

        session()->flash('success', 'Plan imeundwa kikamilifu!');
        return redirect()->route('admin.plans.index');
    }

    public function render()
    {
        return view('livewire.admin.plans.create')->layout('layouts.admin');
    }
}
