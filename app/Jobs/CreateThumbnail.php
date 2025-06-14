<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Intervention\Image\ImageManager;

class CreateThumbnail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct($imagePath)
    {
        $this->imagePath = $imagePath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $img = ImageManager::imagick()->read(storage_path('app/public/' . $this->imagePath));
            $img->resize(150,150);
            $img->save(storage_path('app/public/thumbnails/' . basename($this->imagePath)));
        } catch (\Exception $e) {
            dd($e->getMessage(), $img);
        }

    }
}
