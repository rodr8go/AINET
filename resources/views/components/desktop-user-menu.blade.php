<flux:dropdown position="bottom" align="start">
    <flux:sidebar.profile
        :name="auth()->user()->name"
        :initials="auth()->user()->initials()"
        :avatar="auth()->user()->photo_url ? auth()->user()->photo_full_url : null"
        icon:trailing="chevrons-up-down"
        data-test="sidebar-menu-button"
    />

    <flux:menu>
        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
            <flux:avatar
                :name="auth()->user()->name"
                :initials="auth()->user()->initials()"
                :src="auth()->user()->photo_url ? auth()->user()->photo_full_url : null"
            />
            <div class="grid flex-1 text-start text-sm leading-tight">
                <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
            </div>
        </div>

        @if(Gate::check('viewMy', \App\Models\Discipline::class) ||
            Gate::check('viewMy', \App\Models\Teacher::class) ||
            Gate::check('viewMy', \App\Models\Student::class))
            <flux:menu.separator />

            <flux:menu.radio.group>
                @can('viewMy', \App\Models\Discipline::class)
                <flux:menu.item icon="document" :href="route('disciplines.my')"
                    :current="request()->routeIs('disciplines.my')" wire:navigate>
                    My Disciplines
                </flux:menu.item>
                @endcan
                @can('viewMy', \App\Models\Teacher::class)
                    <flux:menu.item icon="user" :href="route('teachers.my')"
                    :current="request()->routeIs('teachers.my')" wire:navigate>
                    My Teachers
                </flux:menu.item>
                @endcan
                @can('viewMy', \App\Models\Student::class)
                <flux:menu.item icon="users" :href="route('students.my')"
                    :current="request()->routeIs('students.my')" wire:navigate>
                    My Students
                </flux:menu.item>
                @endcan
            </flux:menu.radio.group>
        @endif
        <flux:menu.separator />

        <flux:menu.radio.group>
            <flux:menu.item :href="match(auth()->user()->type) {
                    'S' => route('students.show', ['student' => auth()->user()->student]),
                    'T' => route('teachers.show', ['teacher' => auth()->user()->teacher]),
                    'A' => route('administratives.show', ['administrative' => auth()->user()])
                }" icon="document-text" wire:navigate>
                My Record
            </flux:menu.item>
            <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                {{ __('Settings') }}
            </flux:menu.item>
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item
                    as="button"
                    type="submit"
                    icon="arrow-right-start-on-rectangle"
                    class="w-full cursor-pointer"
                    data-test="logout-button"
                >
                    {{ __('Log out') }}
                </flux:menu.item>
            </form>
        </flux:menu.radio.group>
    </flux:menu>
</flux:dropdown>
