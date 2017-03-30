var gulp = require('gulp');
var spritesmith = require('gulp.spritesmith');
var merge = require('merge-stream');
svgSprite               = require('gulp-svg-sprite');

config                  = {
    mode                : {
        css             : {
            dest : './',
            bust : false,
            sprite : "img/svg/sprites.svg",
            prefix: '.icon-%s ',
            render      : {
                css     : true,
                less: true
            },
            example         : true
        }
    },
    shape : {
      spacing : {
        padding : 1
      }
    }
};

config2                  = {
    mode                : {
        symbol : {
          example: true
        }
    }
};

gulp.task('icons:c', function () {
  gulp.src('wisewire/source/*.svg')
      .pipe(svgSprite(config))
      .pipe(gulp.dest('wisewire/dest'));
});

gulp.task('icons:s', function () {
  gulp.src('wisewire/svg-symbols/*.svg')
      .pipe(svgSprite(config2))
      .pipe(gulp.dest('dest'));
});
