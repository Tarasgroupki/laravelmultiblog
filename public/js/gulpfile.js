var elixir = require('laravel-elixir');
var _ = require('underscore');
require('laravel-elixir-ngtemplatecache');

elixir(function (mix) {
    var namespace = 'console';
    var instances = [
    	{name: 'admin'}
    	//add more instance here
    ];

    _.each(instances, function (instance) {
        mix.coffee([
            namespace + '/' + instance.name + '/app.coffee',
            namespace + '/' + instance.name + '/**/**'
        ], elixir.config.get('public.js.outputFolder') + '/' + namespace + '/' + instance.name + '/app.js');

        mix.sass([namespace + '/' + instance.name + '/app.sass'], elixir.config.get('public.css.outputFolder') + '/' + namespace + '/' + instance.name);

        mix.ngTemplateCache('/' + namespace + '/' + instance.name + '/**/*.html', elixir.config.get('public.js.outputFolder') + '/' + namespace + '/' + instance.name, null, {
            templateCache: {
                standalone: true
            },
            htmlmin: {
                collapseWhitespace: true,
                removeComments: true
            }
        });
    });
});