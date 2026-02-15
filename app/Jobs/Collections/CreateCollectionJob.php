<?php

namespace App\Jobs\Collections;

use App\Data\CreateInvoiceData;
use App\Domains\Collection\CollectionResolver;
use App\Models\Integration;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;

class CreateCollectionJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public CreateInvoiceData $data, public Integration $integration)
    {
        /** use custom queue worker */
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        CollectionResolver::resolve($this->integration->driver)->create($this->data, $this->integration);
    }

    /**
     * Handle a job failure.
     */
    public function failed(?Throwable $exception): void
    {
        // Send user notification of failure, etc...
        logger($exception->getMessage());
    }
}
