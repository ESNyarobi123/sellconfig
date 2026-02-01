<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Setting;

class Settings extends Component
{
    // General
    public $site_name;
    public $whatsapp_number;
    public $support_message;

    // Payment
    public $harakapay_api_key;
    public $payment_enabled;

    // Social Links
    public $social_whatsapp;
    public $social_youtube;

    // App Downloads
    public $app_halotel_link;
    public $app_airtel_link;

    public function mount()
    {
        // General
        $this->site_name = Setting::get('site_name', 'SellConfig');
        $this->whatsapp_number = Setting::get('whatsapp_number', '');
        $this->support_message = Setting::get('support_message', '');

        // Payment
        $this->harakapay_api_key = Setting::get('harakapay_api_key', '');
        $this->payment_enabled = Setting::get('payment_enabled', true);

        // Social
        $this->social_whatsapp = Setting::get('social_whatsapp', 'https://wa.me/260966122504');
        $this->social_youtube = Setting::get('social_youtube', 'https://www.youtube.com/@CyberHunter-b6n3t');

        // Apps
        $this->app_halotel_link = Setting::get('app_halotel_link', 'https://uploadapk.store/view-app.php?id=226');
        $this->app_airtel_link = Setting::get('app_airtel_link', '#');
    }

    public function save()
    {
        $this->validate([
            'site_name' => 'required|string|max:255',
            'whatsapp_number' => 'nullable|string',
            'harakapay_api_key' => 'nullable|string',
            'social_whatsapp' => 'nullable|url',
            'social_youtube' => 'nullable|url',
            'app_halotel_link' => 'nullable|string',
            'app_airtel_link' => 'nullable|string',
        ]);

        // Save General
        Setting::set('site_name', $this->site_name);
        Setting::set('whatsapp_number', $this->whatsapp_number);
        Setting::set('support_message', $this->support_message);

        // Save Payment
        Setting::set('harakapay_api_key', $this->harakapay_api_key);
        Setting::set('payment_enabled', $this->payment_enabled, 'boolean');

        // Save Social
        Setting::set('social_whatsapp', $this->social_whatsapp);
        Setting::set('social_youtube', $this->social_youtube);

        // Save Apps
        Setting::set('app_halotel_link', $this->app_halotel_link);
        Setting::set('app_airtel_link', $this->app_airtel_link);

        session()->flash('success', 'Mipangilio imehifadhiwa kikamilifu!');
    }

    public function render()
    {
        return view('livewire.admin.settings')->layout('layouts.admin');
    }
}
