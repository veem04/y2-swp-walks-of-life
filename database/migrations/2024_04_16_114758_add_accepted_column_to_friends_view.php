<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;
use Staudenmeir\LaravelMergedRelations\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::createOrReplaceMergeView(
            'friends_view',
            [(new User())->acceptedFriendsTo()->withPivot('accepted'), 
            (new User())->acceptedFriendsFrom()->withPivot('accepted')]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::createOrReplaceMergeView(
            'friends_view',
            [(new User())->acceptedFriendsTo(), 
            (new User())->acceptedFriendsFrom()]
        );
    }
};
