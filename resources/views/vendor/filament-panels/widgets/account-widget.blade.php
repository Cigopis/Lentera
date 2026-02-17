@php
    use Filament\Facades\Filament;

    $user = Filament::auth()->user();
    $roles = $user?->getRoleNames()->join(', '); 
@endphp

<x-filament-widgets::widget class="fi-account-widget">
    <x-filament::section>
        <div class="flex items-center gap-x-3">
            
            <x-filament-panels::avatar.user size="lg" :user="$user" />

            <div class="flex-1 flex flex-col justify-center">
                <!-- Nama -->
                <h2 class="text-base font-semibold text-gray-950 dark:text-white">
                    {{ filament()->getUserName($user) }}
                </h2>

        
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $roles ?? 'No role assigned' }}
                </p>
            </div>

            <div class="flex gap-2 items-center">
                
                <x-filament::button
                    size="sm"
                    color="primary"
                    labeled-from="sm"
                    icon="heroicon-m-key"
                    tag="a"
                    :href="filament()->getProfileUrl()"
                >
                    Change Password
                </x-filament::button>

                <!-- Logout -->
                <form action="{{ filament()->getLogoutUrl() }}" method="post" class="my-auto">
                    @csrf
                    <x-filament::button
                        color="danger"
                        icon="heroicon-m-arrow-left-on-rectangle"
                        icon-alias="panels::widgets.account.logout-button"
                        labeled-from="sm"
                        tag="button"
                        type="submit"
                    >
                        Logout
                    </x-filament::button>
                </form>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
