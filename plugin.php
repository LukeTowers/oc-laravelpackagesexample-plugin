<?php namespace LukeTowers\LaravelPackagesExample;

use App;
use Config;
use System\Classes\PluginBase;
use Illuminate\Foundation\AliasLoader;

/**
 * Class Plugin
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Laravel Packages Example',
            'description' => 'OctoberCMS plugin for demonstrating the use of Laravel Packages within October plugins',
            'author'      => 'Luke Towers',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Runs right before the request route
     */
    public function boot()
    {    
        // Setup required packages
        $this->bootPackages();
    }
    
    /**
     * Boots (configures and registers) any packages found within this plugin's packages.load configuration value
     *
     * @see https://luketowers.ca/blog/how-to-use-laravel-packages-in-october-plugins
     * @author Luke Towers <octobercms@luketowers.ca>
     */
    public function bootPackages()
    {
        // Get the namespace of the current plugin to use in accessing the Config of the plugin
        $pluginNamespace = str_replace('\\', '.', strtolower(__NAMESPACE__));
        
        // Instantiate the AliasLoader for any aliases that will be loaded
        $aliasLoader = AliasLoader::getInstance();
        
        // Get the packages to boot
        $packages = Config::get($pluginNamespace . '::packages');
        
        // Boot each package
        foreach ($packages as $name => $options) {
            // Setup the configuration for the package, pulling from this plugin's config
            if (!empty($options['config'] && !empty($options['config_namespace']))) {
                $configKeys = array_keys(array_dot($options['config']));
                
                // Set each config key under the package config namespace
                foreach ($configKeys as $key) {
                    Config::set($options['config_namespace'] . '.' . $key, array_get($options['config'], $key));
                }
            }
            
            // Register any Service Providers for the package
            if (!empty($options['providers'])) {
                foreach ($options['providers'] as $provider) {
                    App::register($provider);
                }
            }
            
            // Register any Aliases for the package
            if (!empty($options['aliases'])) {
                foreach ($options['aliases'] as $alias => $path) {
                    $aliasLoader->alias($alias, $path);
                }
            }
        }
    }
}