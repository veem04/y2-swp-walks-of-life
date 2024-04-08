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
                    <br><span class="text-red-600">{{ __("todo implement show and sort by emissions, access profiles")}}</span>
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
                                <div class='p-3 my-2 text-lg border-2 border-green-600 shadow-md rounded duration-200 hover:bg-green-100'>
                                    {{ __($count) }}
                                    {{ __($user->name) }}<br>
                                    {{ __('Saved [X] kg over the past week') }}
                                </div>
                            </a>
                            
                        </li>
                    @empty
                    <div class="px-6 py-3 text-gray-900">
                        {{ __("No users found. ...what?") }}
                    </div>
                    @endforelse
                    {{ $users->links() }}
                </ul>
                
            </div>
        </div>
    </div>
</x-app-layout>
