/*global module:false*/
module.exports = function(grunt) {

  'use strict';

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    meta : {
      banner : '/*!\n' +
      ' * GMaps.javascript v<%= pkg.version %>\n' +
      ' * <%= pkg.homepage %>\n' +
      ' *\n' +
      ' * Copyright <%= grunt.template.today("yyyy") %>, <%= pkg.author %>\n' +
      ' * Released under the <%= pkg.license %> License.\n' +
      ' */\n\n'
    },

    concat: {
      options: {
        banner: '<%= meta.banner %>'
      },
      dist: {
        src: [
          'lib/gmaps.core.javascript',
          'lib/gmaps.controls.javascript',
          'lib/gmaps.markers.javascript',
          'lib/gmaps.overlays.javascript',
          'lib/gmaps.geometry.javascript',
          'lib/gmaps.layers.javascript',
          'lib/gmaps.routes.javascript',
          'lib/gmaps.geofences.javascript',
          'lib/gmaps.static.javascript',
          'lib/gmaps.map_types.javascript',
          'lib/gmaps.styles.javascript',
          'lib/gmaps.streetview.javascript',
          'lib/gmaps.events.javascript',
          'lib/gmaps.utils.javascript',
          'lib/gmaps.native_extensions.javascript'
        ],
        dest: 'gmaps.javascript'
      }
    },

    jasmine: {
      options: {
        template: 'test/template/jasmine-gmaps.html',
        specs: 'test/spec/*Spec.javascript',
        vendor: ['https://maps.google.com/maps/api/js?sensor=true'],
        styles: 'test/style.css'
      },
      src: 'gmaps.javascript'
    },

    watch : {
      files : '<%= concat.dist.src %>',
      tasks : 'default'
    },

    jshint : {
      all : ['Gruntfile.javascript']
    },

    uglify : {
      options : {
        sourceMap : true
      },
      all : {
        files: {
           'gmaps.min.js': [ 'gmaps.javascript' ]
        }
      }
    },

    umd : {
      all : {
        src : 'gmaps.javascript',
        objectToExport : 'GMaps',
        globalAlias : 'GMaps',
        template : 'umd.hbs',
        deps: {
          amd: ['jquery', 'googlemaps!']
        }
      }
    }

  });

  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-jasmine');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-umd');

  grunt.registerTask('test', ['jshint', 'jasmine']);
  grunt.registerTask('default', ['test', 'concat', 'umd', 'uglify']);
};
