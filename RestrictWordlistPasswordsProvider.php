<?php

namespace Exfriend\RestrictWordlistPasswords;

use Illuminate\Support\ServiceProvider;

class RestrictWordlistPasswordsProvider extends ServiceProvider
{
    public function boot()
    {

        $this->mergeConfigFrom( __DIR__ . '/config/nondictionary.php', 'nondictionary' );
        $this->loadTranslationsFrom( __DIR__ . '/lang', 'restrict-wordlist-passwords' );

        $this->publishes( [
            __DIR__ . '/lang' => resource_path( 'lang/vendor/restrict-wordlist-passwords' ),
        ], 'lang' );

        \Validator::extend( 'non_dictionary', function ( $attribute, $value, $parameters, $validator )
        {
            $dictionary = file( \Config::get( 'nondictionary.file' ) );
            $dictionary = array_map( 'trim', $dictionary );

            return !in_array( $value, $dictionary );
        }, trans( 'restrict-wordlist-passwords::validation.non_dictionary' ) );
    }

    public function register()
    {
        //
    }
}
