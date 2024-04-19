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
                    {{ __("Friends") }}
                </div>
                <div class="px-6 py-3 text-lg text-gray-900">
                    Your friend code is: <b>{{ Auth::user()->friend_code }}</b>
                </div>
                
                <div class="px-6 py-3 text-lg text-gray-900">
                    Add a new friend using a friend code!
                    <form action="{{ route( 'friends.store' )}}" method="post" class="py-1">
                        @csrf
                        <input type="text" name="fcode" id="fcode" class="rounded" maxLength="4" />
                        <button type="submit" class="px-2 py-2 my-3 text-white bg-my-green rounded-md duration-200 hover:bg-green-800">Send request</button>
                    </form>
                </div>
                <ul class='my-6 flex flex-col place-items-center'>
                    @forelse ($friends as $user)
                        <li class='w-5/6'>
                            <a href="{{ route("profile.show", $user->id) }}">
                                <div class='py-3 px-4 my-2 text-lg flex justify-between items-center border-2 border-green-600 shadow-md rounded duration-200 hover:bg-green-100'>
                                    <div class="flex gap-6">
                                        <img src="{{ asset('storage/images/'.$user->image) }}" alt="" class="max-h-14">
                                        <div>
                                            <span class="font-medium">{{ __($user->name) }}</span><br>
                                            {{ __("Friend code: " . $user->friend_code) }}
                                        </div>
                                    </div>
                                    
                                    <form action="{{ route('friends.destroy', $user )}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-2 my-3 text-white bg-red-400 rounded-md duration-200 hover:bg-red-700">Remove friend</button>
                                    </form>
                                </div>
                            </a>
                        </li>
                    @empty
                    <div class="px-6 py-3 text-gray-900">
                        {{ __("You haven't added any friends yet!") }}
                    </div>
                    @endforelse
                </ul>
                
                <div class="py-5">
                    <div class="font-medium text-xl px-6 py-4 text-gray-900">
                        {{ __("Incoming friend requests") }}
                    </div>
                    @if (sizeof($incomingRequests) === 0)
                        <div class="px-6 py-1 text-gray-900">
                            {{ __("You have no incoming friend requests.") }}
                        </div>
                    @else
                        <ul class='my-6 flex flex-col place-items-center'>
                            @foreach ($incomingRequests as $user)
                                <li class='w-5/6'>
                                    <a href="{{ route("profile.show", $user->id) }}">
                                        <div class='p-3 my-2 text-lg flex justify-between items-center border-2 border-green-600 shadow-md rounded duration-200 hover:bg-green-100'>
                                            <div>
                                                <span class="font-medium">{{ __($user->name) }}</span><br>
                                                {{ __("Friend code: " . $user->friend_code) }}
                                            </div>

                                            <div class="flex gap-4">
                                                <form action="{{ route('friends.update', $user->id )}}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="px-2 py-2 my-3 text-white bg-my-green rounded-md duration-200 hover:bg-green-700">Accept</button>
                                                </form>
    
                                                <form action="{{ route('friends.destroy', $user->id )}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-2 py-2 my-3 text-white bg-red-400 rounded-md duration-200 hover:bg-red-700">Reject</button>
                                                </form>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="py-5">
                    <div class="font-medium text-xl px-6 py-2 text-gray-900">
                        {{ __("Outgoing friend requests") }}
                    </div>
                    @if (sizeof($outgoingRequests) === 0)
                        <div class="px-6 py-2 text-gray-900">
                            {{ __("You have no outgoing friend requests.") }}
                        </div>
                    @else
                        <ul class='my-6 flex flex-col place-items-center'>
                            @foreach ($outgoingRequests as $user)
                                <li class='w-5/6'>
                                    <a href="{{ route("profile.show", $user->id) }}">
                                        <div class='p-3 my-2 text-lg flex justify-between items-center border-2 border-green-600 shadow-md rounded duration-200 hover:bg-green-100'>
                                            <div>
                                                <span class="font-medium">{{ __($user->name) }}</span><br>
                                                {{ __("Friend code: " . $user->friend_code) }}
                                            </div>
                                            <form action="{{ route('friends.destroy', $user->id )}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2 py-2 my-3 text-white bg-red-400 rounded-md duration-200 hover:bg-red-700">Cancel request</button>
                                            </form>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        let fcode = document.getElementById('fcode')
        fcode.addEventListener("input", function(e){
            fcode.value = fcode.value.toUpperCase();
        });
    </script>
</x-app-layout>
