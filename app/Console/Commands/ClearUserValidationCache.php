<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MicroserviceClient;

class ClearUserValidationCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:clear-user-validation {email? : The email of the user to clear cache for}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear user validation cache. Use with email parameter to clear specific user cache, or without to clear all.';

    /**
     * Execute the console command.
     */
    public function handle(MicroserviceClient $microserviceClient)
    {
        $email = $this->argument('email');
        
        if ($email) {
            // Clear cache for specific user
            $result = $microserviceClient->clearUserValidationCache($email);
            
            if ($result) {
                $this->info("User validation cache cleared for: {$email}");
            } else {
                $this->error("Failed to clear cache for: {$email}");
            }
        } else {
            // Clear all user validation cache
            $result = $microserviceClient->clearAllUserValidationCache();
            
            if ($result) {
                $this->info("All user validation cache cleared successfully!");
            } else {
                $this->error("Failed to clear all user validation cache");
            }
        }
        
        return $result ? 0 : 1;
    }
}
