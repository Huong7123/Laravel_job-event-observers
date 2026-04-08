<?php

namespace App\Jobs;

use Illuminate\Container\Attributes\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class TestJob implements ShouldQueue
{
    use Queueable;

    protected $data;
    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        
    }
}
