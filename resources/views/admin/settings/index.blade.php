@extends('admin.layouts.app')

@section('title', 'Site Settings')
@section('page-title', 'Site Settings')

@section('breadcrumbs')
    <span>Site Management / Settings</span>
@endsection

@section('content')
<div class="max-w-4xl">
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            @foreach($settings as $group => $groupSettings)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-3 border-b border-gray-200">
                    {{ ucwords(str_replace('_', ' ', $group)) }}
                </h3>

                <div class="space-y-4">
                    @foreach($groupSettings as $setting)
                    <div>
                        <label for="{{ $setting->key }}" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ ucwords(str_replace('_', ' ', str_replace($group . '_', '', $setting->key))) }}
                        </label>

                        @if($setting->type === 'textarea')
                        <textarea name="settings[{{ $setting->key }}]"
                                  id="{{ $setting->key }}"
                                  rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">{{ old('settings.' . $setting->key, $setting->value) }}</textarea>
                        @elseif($setting->type === 'email')
                        <input type="email"
                               name="settings[{{ $setting->key }}]"
                               id="{{ $setting->key }}"
                               value="{{ old('settings.' . $setting->key, $setting->value) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        @elseif($setting->type === 'url')
                        <input type="url"
                               name="settings[{{ $setting->key }}]"
                               id="{{ $setting->key }}"
                               value="{{ old('settings.' . $setting->key, $setting->value) }}"
                               placeholder="https://..."
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        @elseif($setting->type === 'tel')
                        <input type="tel"
                               name="settings[{{ $setting->key }}]"
                               id="{{ $setting->key }}"
                               value="{{ old('settings.' . $setting->key, $setting->value) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        @else
                        <input type="text"
                               name="settings[{{ $setting->key }}]"
                               id="{{ $setting->key }}"
                               value="{{ old('settings.' . $setting->key, $setting->value) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        @endif

                        @error('settings.' . $setting->key)
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        @if($setting->key === 'contact_email')
                            <p class="mt-1 text-xs text-gray-500">Primary email for contact forms and inquiries</p>
                        @elseif($setting->key === 'contact_phone')
                            <p class="mt-1 text-xs text-gray-500">Main contact phone number</p>
                        @elseif($setting->key === 'contact_address')
                            <p class="mt-1 text-xs text-gray-500">Physical address of the organization</p>
                        @elseif(str_contains($setting->key, 'facebook'))
                            <p class="mt-1 text-xs text-gray-500">Facebook profile or page URL</p>
                        @elseif(str_contains($setting->key, 'twitter'))
                            <p class="mt-1 text-xs text-gray-500">Twitter/X profile URL</p>
                        @elseif(str_contains($setting->key, 'instagram'))
                            <p class="mt-1 text-xs text-gray-500">Instagram profile URL</p>
                        @elseif(str_contains($setting->key, 'youtube'))
                            <p class="mt-1 text-xs text-gray-500">YouTube channel URL</p>
                        @elseif(str_contains($setting->key, 'linkedin'))
                            <p class="mt-1 text-xs text-gray-500">LinkedIn profile or company page URL</p>
                        @elseif($setting->key === 'seo_meta_description')
                            <p class="mt-1 text-xs text-gray-500">Default meta description for search engines (150-160 characters)</p>
                        @elseif($setting->key === 'seo_keywords')
                            <p class="mt-1 text-xs text-gray-500">Comma-separated keywords for SEO</p>
                        @elseif($setting->key === 'google_analytics_id')
                            <p class="mt-1 text-xs text-gray-500">Google Analytics tracking ID (e.g., G-XXXXXXXXXX)</p>
                        @elseif($setting->key === 'google_maps_api_key')
                            <p class="mt-1 text-xs text-gray-500">API key for Google Maps integration</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach

            @if($settings->isEmpty())
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <p class="text-lg font-medium text-gray-900">No settings found</p>
                <p class="text-sm text-gray-500 mt-1">Please run database seeders to populate settings</p>
            </div>
            @endif
        </div>

        @if($settings->isNotEmpty())
        <div class="mt-6 flex items-center justify-end space-x-3">
            <button type="submit"
                    class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-amber-800 transition">
                Save Settings
            </button>
        </div>
        @endif
    </form>
</div>
@endsection
