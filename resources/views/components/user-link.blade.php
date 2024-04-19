<div class='py-3 px-5 my-2 flex items-center gap-6 text-lg border-2 border-green-600 shadow-md rounded duration-200 hover:bg-green-100'>
    <div class="font-medium text-3xl text-green-700">
        {{ __($count) }}
    </div>
    <img src="{{ asset('storage/images/'.$user->image) }}" alt="" class="max-h-14">
    <div>
        {{ __($user->name) }}<br>
        {{ __("Saved $user->co2_saved kg over the past 2 weeks") }}
    </div>
</div>