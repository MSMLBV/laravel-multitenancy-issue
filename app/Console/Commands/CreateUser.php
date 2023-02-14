<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Jobs\UpdateUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Multitenancy\Commands\Concerns\TenantAware;

class CreateUser extends Command
{
    use TenantAware;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {--tenant=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::beginTransaction();

        $user = User::factory()->create();
        UpdateUser::dispatchSync($user);

        DB::commit();

        return Command::SUCCESS;
    }
}
