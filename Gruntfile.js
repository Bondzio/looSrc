/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
module.exports = function (grunt) {
  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    
    watch: {
      scripts: {
        files: 'js/*.js',
        tasks: ['concat', 'copy']
      },
      index: {
        files: '*.php',
        tasks: ['copy']
      }
    },
    
    clean: {
      build: {
        src: ['build/js']
      }
    },
    copy: {
      build: {
        files: [ '*.php' ],
        dest: 'build',
        expand: true
      }
    },
    
    //OK, concat is fine!
    concat: {
      options: {
        // define a string to put between each file in the concatenated output
        separator: ';'
      },
      dist: {
        // the files to concatenate
        src: ['src/**/*.js'],
        // the location of the resulting JS file
        dest: 'dist/<%= pkg.name %>.js'
      }
    },
    
    
//    compass: {
//      compile: {
//        options: {
//          sassDir: 'src/scss',
//          cssDir: 'public_html/css',
//        }
//      }
//    },

    //OK, ftp works fine!!
    ftpush: {
      build: {
        auth: {
          host: 'ftp.loooping.ch',
          port: 21,
          authKey: 'loooping'
        },
        src: 'dist',
        dest: 'try',
        exclusions: ['path/to/source/folder/**/.DS_Store', 'path/to/source/folder/**/Thumbs.db', 'dist/tmp'],
        keep: ['/important/images/at/server/*.jpg']
      }
    }
  });
  
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-ftpush');
  grunt.registerTask(
      'build',
      'Compiles all the assets and copies the files to the build directory.',
     [ 'clean', 'copy', 'concat' ]
  );
};
