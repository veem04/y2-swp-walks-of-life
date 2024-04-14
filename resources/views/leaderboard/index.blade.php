<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="font-medium text-2xl px-6 py-4 text-gray-900">
                    {{ __("Leaderboard") }}
                </div>
                <div class="px-6 py-3 text-gray-900">
                    {{ __("See how your savings stack up against the world's!") }}
                    <br><span class="text-red-600 font-medium">{{ __("todo access profiles")}}</span>
                </div>

                <ul class='my-6 flex flex-col place-items-center'>
                    @php
                        $count = 0;
                    @endphp
                    @forelse ($users as $user)
                    @php
                        $count += 1;
                    @endphp
                        <li class='w-5/6'>
                            <a href="#">
                                <x-user-link :user="$user" :count="$count" />
                            </a>
                        </li>
                    @empty
                    <div class="px-6 py-3 text-gray-900">
                        {{ __("No users have submitted journeys in the past 2 weeks.") }}
                    </div>
                    @endforelse
                    {{ $users->links() }}
                </ul>
                
            </div>
        </div>
    </div>
</x-app-layout>
