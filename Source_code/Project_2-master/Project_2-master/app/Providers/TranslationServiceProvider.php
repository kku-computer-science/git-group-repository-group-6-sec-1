<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;

class TranslationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('TranslationService', function () {
            return new class {
                public function translate($text, $targetLanguage)
                {
                    // Split text into sentences for better translation to be able to translate longer
                    $sentences = preg_split('/(\.|\?|!)/', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
                    $translatedText = '';

                    foreach ($sentences as $sentence) {
                        if (trim($sentence) !== '') {
                            $url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=auto&tl={$targetLanguage}&dt=t&q=" . urlencode($sentence);
                            $response = Http::get($url);

                            if ($response->successful()) {
                                $translation = json_decode($response->body(), true);
                                $translatedText .= $translation[0][0][0] . ' ';
                            } else {
                                return 'Translation API Error: ' . $response->body();
                            }
                        }
                    }

                    return trim($translatedText);
                }
            };
        });
    }
}
