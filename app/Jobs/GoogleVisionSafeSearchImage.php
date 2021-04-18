<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Models\ImageAnnouncement;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;

class GoogleVisionSafeSearchImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $image_announcement_id;

    public function __construct($image_announcement_id)
    {
       $this->image_announcement_id = $image_announcement_id;


    }

    
    public function handle()
    {
        $i = ImageAnnouncement::find( $this->image_announcement_id);

        if(!$i){return;}

        $image = file_get_contents(storage_path('/app/' . $i->file));

        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . base_path('google_credential.json'));

        $imageAnnotator = new ImageAnnotatorClient();
        $response = $imageAnnotator->safeSearchDetection($image);
        $imageAnnotator->close();

        $safe = $response->getSafeSearchAnnotation();

        $adult = $safe->getAdult();
        $medical = $safe->getMedical();
        $spoof = $safe->getSpoof();
        $violence = $safe->getViolence();
        $racy = $safe->getRacy();

        // echo json_encode([
        //     $adult,
        //     $medical, 
        //     $spoof,
        //     $violence, 
        //     $racy, 
        // ]);

        $likelihoodName = [
            'UNKNOW', 'VERY_UNLIKELY', 'UNLIKELY' , 'POSSIBLE', 'LIKELY', 'VERY_LIKELY'
        ];

        $i->adult = $likelihoodName[$adult];
        $i->medical = $likelihoodName[$medical];
        $i->spoof = $likelihoodName[$spoof];
        $i->violence = $likelihoodName[$violence];
        $i->racy = $likelihoodName[$racy];

        $i->save();

    }
}
