<div class='p-3 my-2 text-lg border-2 border-green-600 shadow-md rounded duration-200 hover:bg-green-100'>
    <span class="font-medium">{{ __($user->name) }}</span><br>
    {{ __("Friend code: " . $user->friend_code) }}
</div>