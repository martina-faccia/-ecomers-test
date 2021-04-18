<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Models\ImageAnnouncement;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class GoogleVisionLabelImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

        private $image_announcement_id;

    public function __construct($image_announcement_id)
    {
        $this->$image_announcement_id = $image_announcement_id;
    }

    public function handle()
    {
        $i = ImageAnnouncement::find( $this->image_announcement_id);

        if(!$i){return;}

        $image = file_get_contents(storage_path('/app/' . $i->file));

        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . base_path('google_credential.json'));

        $imageAnnotator = new ImageAnnotatorClient();
        $response = $imageAnnotator->labelDetection($image);
        $labels = $response->getLabelAnnotations();

        if ($labels) {
            
            $result = [];
            foreach($labels as $label){
                
            }
        }
        $imageAnnotator->close();


    }
}
