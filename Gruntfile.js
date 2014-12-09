/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
module.exports = function (grunt) {
  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    clean: {
      build: {
        src: ['build/js']
      }
    },
    copy: {
      build: {
        cwd: 'src',
        src: [ 'index.html' ],
        dest: 'build',
        expand: true
      }
    },
    concat: {
      build: {
        src: [ 'src/js/*.js' ],
        dest: 'build/js/myJS.js',
      }
    },
//    compass: {
//      compile: {
//        options: {
//          sassDir: 'src/scss',
//          cssDir: 'public_html/css',
//        }
//      }
//    }
  });
  
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.registerTask(
      'build',
      'Compiles all the assets and copies the files to the build directory.',
     [ 'clean', 'copy', 'concat' ]
  );
};
