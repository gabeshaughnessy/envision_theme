module.exports = function(grunt) {
  //HAML
  grunt.loadNpmTasks('grunt-newer');
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    sass:{
      sourcemap: 'none'
      }
  });

  //local debug variable for uncompressed js
  grunt.config('local', grunt.option('local') || process.env.LOCAL || false);

  //SASS DIRECTORY IMPORT - dynamically include all sass partials in a directory
  grunt.loadNpmTasks('grunt-sass-directory-import');
  grunt.config('sass_directory_import', {
    patterns: {
        files: {
            // The file pattern to add @imports to.
            src: ['scss/patterns/_all-patterns.scss']
        },
    }
  });

  //SASS
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.config('sass', {
      dist: {
        options: {
          style: 'compact',
          sourcemap: 'none'
        },
        files: {
          'css/app.css': 'scss/app.scss',
        }
      }
  });

  //CONCAT
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.config('concat', {
    dist: {
      options: {
        separator: ';',
      },
      src: [
        'js/modernizr.js',
        'js/smooth-scrolling.js',

      ],
      dest: 'js/app.js',
    }
  });

  //UGLIFY
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.config('uglify', {
    options: {
      compress: false,
      mangle: false
    },
      dist: {
        files: {
          'js/app.min.js': ['js/app.js']
        }
      }
  });

  //CSS MIN
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.config('cssmin', {
    dist : {
      files: [{
      expand: true,
      cwd: 'css/',
      src: ['*.css', '!*.min.css', '!*.css.map'],
      dest: 'css/',
      ext: '.min.css'
    }]
    }

  });

  //SVG MIN
  grunt.loadNpmTasks('grunt-svgmin');
  grunt.config('svgmin', {
    options: {
      plugins: [
                {
                    removeViewBox: false
                }, {
                    removeUselessStrokeAndFill: false
                }
            ]
    },
       dist: {
                expand: true,
                cwd: 'images',
                src: ['**/*.svg'],
                dest: 'compressed-images/',
                ext: '.svg'
            }
  });


  //WATCH
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.config('watch',{
    options: {
      livereload: 35730 //set to unique port number to avoid conflicts
    },
    grunt: { files: ['Gruntfile.js'] },
    scripts: {
      files: ['js/app.js'],
      tasks: ['concat']
    },
    compress: {
      files: ['js/app.js'],
      tasks: ['uglify']
    },

    sass: {
      files: 'scss/**/*.scss',
      tasks: ['sass_directory_import','sass']
    },
    svg: {
      files: ['images/**/*.svg'],
      tasks: ['svgmin']
    },
    css : {
      files: ['css/*.css', '!css/*.min.css', '!*.css.map'],
      tasks : ['cssmin']

    }

  });

  grunt.registerTask('default', ['newer:sass_directory_import', 'newer:sass', 'newer:concat', 'newer:uglify', 'newer:cssmin', 'newer:svgmin', 'watch']);

}