module.exports = function (grunt) {
    'use strict';

    // Project configuration.
    grunt.initConfig({
        // Configuration to be run (and then tested).
        emberTemplates: {
            options: {
                precompile: true,
                templateCompilerPath: '../ember/libs/ember-template-compiler.js',
                handlebarsPath: '../ember/libs/handlebars-v2.0.0.js',
                templateNamespace: 'HTMLBars'
            },
            'default': {
                files: {
                    'tmp/default.js': ['templates/**/*.hbs']
                }
            }
        }
    });

    // Actually load this plugin's task(s).
    grunt.loadTasks('tasks');
    //grunt.loadNpmTasks('grunt-ember-templates');

    // Whenever the "test" task is run, first clean the "tmp" dir, then run this
    // plugin's task(s), then test the result.
    grunt.registerTask('test', ['emberTemplates']);

    // By default, lint and run all tests.
    grunt.registerTask('default', ['test']);
};
