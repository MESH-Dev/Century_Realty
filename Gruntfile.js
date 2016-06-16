module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        // concat - combine files to production version
        compass: {
          dist: {
            options: {
              sassDir : 'sass/',
              cssDir: 'css/',
              environment: 'development'
            }
          }
        },
        concat: {
          js: {
            // add/remove/edit files and order to project needs
            src: ['js/*.js'],
            dest: 'js/cr.js'
          }
        },
        // uglify - minify production js file created through concat
        uglify: {
          js: {
            files: {
              'js/cr.js': ['js/cr.min.js']
            }
          }
        },
        // watch - tasks triggered with [grunt watch] is initiated in the cli
        watch:{
 
          jsuglify:{
            files: ['js/*.js'],
            tasks: ['uglify']
          },
          css: {
            files: 'sass/*.scss',
            tasks: ['compass']
          }
        }

    });
    // load tasks from node_modules
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');

    // tasks that will be triggered with [grunt] in the cli
    grunt.registerTask('default', ['compass', 'concat:js', 'uglify:js']);
};
